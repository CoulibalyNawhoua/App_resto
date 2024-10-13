<?php

namespace App\Repositories;

use App\Models\ProductUnit;
use App\Models\ReceptionProcuct;
use App\Models\Produit;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\Reception;
use App\Models\OrderProduct;
use App\Models\StockProduit;
use Illuminate\Http\Request;
use App\Models\DeliveryProduct;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends Repository
{

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function orderStore(Request $request) {
            $products = $request->input('products',[]);
            $quantity = $request->input('quantity',[]);
            $product_unit = $request->input('product_unit',[]);
            $unite_price = $request->input('unite_price',[]);
            $destination_id = $request->destination_id;
            $order_date = $request->order_date;
            $total_amount = $request->total_amount;
            $order_status = $request->order_status;
            $product_count = $request->product_count;


            $order = Order::create([
                'reference'=>  $this->referenceGenerator('Order'),
                'destination_id' => $destination_id,
                'total_amount' => $total_amount,
                'entite_id' => Auth::user()->entite_id,
                'added_by' => Auth::user()->id,
                'order_date' => $order_date,
                'order_status' => $order_status,
                'add_ip' => $this->getIp(),
                'add_date' => Carbon::now(),
                'total_item_order'=> $product_count
            ]);

            for ($count=0; $count < count($products) ; $count++) {

                OrderProduct::create(
                    [
                        'produit_id' => $products[$count],
                        'quantity'=> $quantity[$count],
                        'product_unit_id'=>  $product_unit[$count],
                        'unite_price' => $unite_price[$count],
                        'order_id' => $order->id,
                    ]
                );
            }
    }


    public function orderList() {

        $depot_id = Auth::user()->entite_id;

        $query = Order::where([
                    ['is_deleted', '=' ,0],
                    ['entite_id', '=', $depot_id]
                ])->with('entite','destination','auteur');

        return $query;
    }


    public function deleteOrderItem($id) {
        OrderProduct::find($id)->delete();
    }

    public function orderUpdate(Request $request, $reference)  {
        $products = $request->input('products',[]);
        $quantity = $request->input('quantity',[]);
        $unite_price = $request->input('unite_price',[]);
        $product_unit = $request->input('product_unit',[]);
        $destination_id = $request->destination_id;
        $order_date = $request->order_date;
        $order_status = $request->order_status;
        $total_amount = $request->total_amount;
        $product_count = $request->product_count;

        $order = $this->model->where('reference',$reference)->first();

        $order->update([
            'destination_id' => $destination_id,
            'order_date' => $order_date,
            'edit_ip' => $this->getIp(),
            'edited_by' => Auth::user()->id,
            'total_amount' => $total_amount,
            'edit_date' => Carbon::now(),
            'order_status' => $order_status,
            'total_item_order'=> $product_count
        ]);

        for ($count=0; $count < count($products) ; $count++) {

            $product = OrderProduct::where([
                ['produit_id', '=', $products[$count]],
                ['order_id', '=', $order->id],
            ])->first();

            if (is_null($product)) {
                OrderProduct::create(
                    [
                        'produit_id' => $products[$count],
                        'quantity'=> $quantity[$count],
                        'product_unit_id'=>  $product_unit[$count],
                        'unite_price' => $unite_price[$count],
                        'order_id' => $order->id
                    ]
                );
            } else {
                $product->update([
                    'quantity'=>$quantity[$count],
                ]);
            }
        }
    }

    public function orderReceivedList() {

        $storehouse_id = Auth::user()->entite_id;

        $query = Order::leftJoin('users','users.id','orders.added_by')
                        ->leftJoin('entites','entites.id','orders.entite_id')
                        ->where([
                        ['orders.is_deleted','=',0],
                        ['orders.destination_id','=', $storehouse_id],
                    ])
                    ->selectRaw('orders.*, CONCAT(users.first_name," ",users.last_name) as auteur, entites.name as entrepot');

        return $query;
    }

    public function orderView($reference) {

        $user_entite_id = Auth::user()->entite_id;

        $order = Order::where('reference', $reference)->firstOrFail();

        $orderProducts = OrderProduct::leftJoin('produits','produits.id','=','orders_products.produit_id')
                        ->leftJoin('unites','unites.id','=','produits.unites_id')
                        ->leftJoin('stock_products', function ($join) use($user_entite_id) {
                            $join->on('stock_products.produit_id', '=', 'produits.id')
                                ->where('stock_products.entite_id', '=', $user_entite_id);
                        })
                        ->where('orders_products.order_id', $order->id)
                        ->selectRaw('produits.nom_produit, unites.name, orders_products.quantity, produits.id as produit_id, orders_products.quantity_delivered, stock_products.quantite as quantite_stock, orders_products.id, orders_products.product_unit_id')
                        ->get();
        foreach ($orderProducts as $item)
        {
            $item->product_units=ProductUnit::where([['produit_id','=',$item->produit_id],['is_deleted','=',0],])->get();
        }

        return $data = [
            'order'=>$order,
            'orderProducts'=>$orderProducts,
        ];
    }

    public function orderDeliveryStore(Request $request) {

        $products = $request->input('products',[]);
        $accepted = $request->input('accepted',[]);
        $quantity = $request->input('quantity',[]);
        $product_unit = $request->input('product_unit',[]);
        $order_qantity = $request->input('order_qantity',[]);
        $delivery_preparation_date = $request->delivery_preparation_date;
        $note = $request->note;
        $order_id = $request->order_id;
        $delivery_status = $request->delivery_status;
        $delivery_date = $request->delivery_date;

        $order = $this->model->where('id', $order_id)->first();

        $delivery = Delivery::create([
            'reference'=>  $this->referenceGenerator('Delivery'),
            'note' => $note,
            'added_by' => Auth::user()->id,
            'order_id' => $order->id,
            'add_ip' => $this->getIp(),
            'add_date' => Carbon::now(),
            'delivery_status' =>  $delivery_status,
            'delivery_date' => $delivery_date,
            'entite_id' => $order->entite_id,
            'preparation_date'=> $delivery_preparation_date
        ]);

        for ($count=0; $count < count($accepted) ; $count++) {

            $product = Produit::where('id', $products[$count])->first();

            $productUnit = ProductUnit::where('id', $product_unit[$count])->first();

            if ($accepted[$count] == 1){

                $quantityStock = StockProduit::where([
                    ['produit_id', '=', $products[$count]],
                    ['entite_id', '=',  $order->destination_id],
                    ['unite_id', '=', $product->unites_id]
                    // ['unite_id', '=', $product_unit[$count]]
                ])->first();

                DeliveryProduct::create([
                    'produit_id' =>  $products[$count],
                    'quantity_delivered' => $quantity[$count],
                    'delivery_id' => $delivery->id,
                    'order_quantity' =>  $order_qantity[$count],
                    'product_unit_id' => $product_unit[$count],
                    'product_unit_quantity' => $productUnit->pcb,
                    'make_delivery' => 1
                ]);

                $quantityStock->decrement('quantite', ($quantity[$count] * $productUnit->pcb));

                if ($quantityStock->quantite < 0) {
                    $quantityStock->update(['quantite' => 0]);
                }
            }
        }

    }


    public function orderReceipt() {

        $entite_id = Auth::user()->entite_id;

        return Reception::selectRaw('receptions.reception_date, receptions.add_date, receptions.id, receptions.reference AS reception_ref,  orders.reference AS order_ref, CONCAT(users.first_name," ",users.last_name) as auteur')
                        ->leftJoin('users','users.id','=','receptions.added_by')
                        ->leftJoin('orders','orders.id','=','receptions.order_id')
                        ->where([
                            ['receptions.entite_id', '=', $entite_id],
                            ['receptions.is_deleted', '=', 0]
                        ])
                        ->whereNotNull('order_id');
    }


    public function OrderStoreHouse () {

        $destination_id = Auth::user()->entite_id;

        return Order::where([
                ['destination_id', '=', $destination_id],
                ['is_deleted', '=', 0],
                ['order_status', '<>', 0],
            ])
            ->with('auteur','entite')->withCount(['delivery',
                    'delivery AS delivery_pending'=> function($query){ $query->where('delivery_status', '=', 1);},
                    'delivery AS delivery_cancel'=> function($query){ $query->where('delivery_status', '=', 0);},
                    'delivery AS shipping_progress'=> function($query){ $query->where('delivery_status', '=', 2);},
                    /*'delivery AS delivery_validate'=> function($query){ $query->where('delivery_status', '=', 3);},*/
            ])->get();

    }


    public function OrderStoreHouseDelivery() {

        $depot_id = Auth::user()->entite_id;
        return Delivery::where([
                        ['orders.is_deleted','=', 0],
                        /*['orders.delivery_status','=', 2],*/
                        ['orders.destination_id','=', $depot_id]
                    ])
                    ->leftJoin('users','users.id','=','delivery.added_by')
                    ->leftJoin('orders','orders.id','=','delivery.order_id')
                    ->leftJoin('entites','entites.id','=','orders.entite_id')
                    ->selectRaw('orders.reference as order_reference, CONCAT(users.first_name," ",users.last_name) as auteur, entites.name as nom_entrepot, orders.add_date as date_commande, delivery.add_date as date_creation, delivery.reference as delivery_reference, delivery.delivery_date, delivery.delivery_status, delivery.id')
                    ->get();

    }

    public function order_view_by_reference($reference)
    {
        $order = Order::where('reference',$reference)->firstOrFail();

        $order_products = OrderProduct::where([['order_id','=',$order->id]])->get();

        foreach ($order_products as $item)
        {
            $item->product_units=ProductUnit::where([['produit_id','=',$item->produit_id],['is_deleted','=',0],])->get();
        }

        return $data = [
            '$order'=>$order,
            'order_products'=>$order_products,
        ];
    }

    public  function orderAcceptProcess(Request $request)
    {
        $order_id = $request->order_id;
        $note = $request->note;

        Order::where('id', $order_id)->update([
            'validate_date' => Carbon::now(),
            'validate_by' => Auth::user()->id,
            'validate_note'=> $note,
            'order_status' => 2
        ]);
    }

    public function orderCancelProcess(Request $request)
    {
        $order_id = $request->order_id;
        $note = $request->note;

        Order::where('id', $order_id)->update([
            'validate_date' => Carbon::now(),
            'validate_by' => Auth::user()->id,
            'validate_note' =>$note,
            'order_status' => 3
        ]);
    }

    public function senderOrderDelivery($id)
    {
        Delivery::where('id', $id)->update([
            'delivery_confirm_date' => Carbon::now(),
            'delivery_confirm_by' => Auth::user()->id,
            'delivery_status' => 2
        ]);
    }

    public function orderValidate($id)
    {
        Order::where('id', $id)->update([
            'validate_date' => Carbon::now(),
            'validate_by' => Auth::user()->id,
            'order_status' => 1
        ]);
    }

    public function orderReceiptStore(Request $request)
    {
        $date_reception = $request->date_reception;
        $commentaire = $request->commentaire;
        $quantity_received = $request->quantite;
        $unite_price = $request->unite_price;
        $invoice_reference = $request->invoice_reference;
        $total_amount = $request->total_amount;
        $products = $request->products;
        $mark_received = $request->mark_received;
        $order_id = $request->order_id;
        $product_unit = $request->product_unit;
        $quantite_commande = $request->quantite_commande;

        $order =  Order::where('id', $order_id)->first();

        $receipt = Reception::create([
            'reference'=>  $this->referenceGenerator('Reception'),
            'invoice_reference' => $invoice_reference,
            'reception_date' => $date_reception,
            'note' => $commentaire,
            'order_id' => $order->id,
            'total_receipt_price' => $total_amount,
            'added_by' => Auth::user()->id,
            'add_date' => Carbon::now(),
            'add_ip' => $this->getIp(),
            'entite_id'=> $order->entite_id
        ]);

        for ($count=0; $count < count($mark_received) ; $count++) {

            $productItem = OrderProduct::where('id', $products[$count])->first();

            if ($mark_received[$count] == 1) {

                ReceptionProcuct::create([
                    'quantity_received' => $quantity_received[$count],
                    'unit_price' => $unite_price[$count],
                    'produit_id' => $products[$count],
                    'receptions_id' => $receipt->id,
                    'product_unit_id'=>$product_unit[$count],
                    'quantity'=>$quantite_commande[$count]
                ]);

                $stock_product = StockProduit::where([
                    ['produit_id' ,'=', $products[$count]],
                    ['entite_id' ,'=',  $order->entite_id],
                    ['unite_id' ,'=',  $product_unit[$count]],
                ])->first();

                if (is_null($stock_product)) {
                    StockProduit::create([
                        'produit_id' =>  $products[$count],
                        'entite_id' => $order->entite_id,
                        'quantite' => $quantity_received[$count],
                        'unite_id' => $product_unit[$count]
                    ]);
                } else {
                    $stock_product->increment('quantite', $quantity_received[$count]);
                }
/*
                $productItem->update([
                    'product_receipt_status' => 1,
                    'quantity_delivered' => $quantity_received[$count]
                ]);*/
            }
        }
    }


    public function printOrderDelivery($delivery_reference)
    {
        $delivery = Delivery::where('reference', $delivery_reference)->firstOrFail();

        $order = Order::where('id', $delivery->order_id)->first();

        $deliveryProduct = DeliveryProduct::where('delivery_id', $delivery->id)->get();

        return $data = [
            'order'=>$order,
            'deliveryProduct'=>$deliveryProduct,
            'delivery'=>$delivery,
        ];


    }

    public function deliveryCancel(Request $request, $id)
    {

        $products = $request->input('products',[]);
        $product_unit = $request->input('product_unit',[]);
        $quantity= $request->input('quantity',[]);

        $delivery = Delivery::where('id', $id)->first();

        $order = Order::where('id', $delivery->order_id)->first();

        $delivery->update([
            'confirm_by'=> Auth::user()->id,
            'confirm_date' => Carbon::now(),
            'commentaire' => $request->note,
            'delivery_status'=>0
        ]);

        for ($count=0; $count < count($products) ; $count++) {
            $stock_product = StockProduit::where([
                ['produit_id' ,'=', $products[$count]],
                ['unite_id' ,'=', $product_unit[$count]],
                ['entite_id' ,'=',  $order->destination_id],
            ])->first();

            if (is_null($stock_product)) {
                StockProduit::create([
                    'produit_id' =>  $products[$count],
                    'entite_id' ,'=',  $order->destination_id,
                    'quantite' => $quantity[$count],
                    'unite_id' ,'=', $product_unit[$count],
                ]);

            } else {
                $stock_product->increment('quantite', $quantity[$count]);
            }
        }
    }

    public function deliveryAccepted($id)
    {
        $delivery = Delivery::find($id);

        $delivery->update([
            'confirm_by'=> Auth::user()->id,
            'confirm_date' => Carbon::now(),
            'delivery_status'=> 2
        ]);

    }

    public function orderDeliveryVew($reference)
    {
        $delivery = Delivery::where('reference', $reference)->firstOrFail();

        $order = Order::where('id', $delivery->order_id)->first();

        $deliveryProducts = DeliveryProduct::where('delivery_id', $delivery->id)->get();

        foreach ($deliveryProducts as $item)
        {
            $item->product_units=ProductUnit::where([['produit_id','=',$item->produit_id],['is_deleted','=',0],])->get();
        }

        return $data = [
            'order'=>$order,
            'deliveryProducts'=>$deliveryProducts,
            'delivery'=>$delivery,
        ];

    }

    public function orderReceiptVew($reference)
    {
       return Reception::where('reference', $reference)->firstOrFail();

    }

    public function closeOrderReceipt(mixed $id)
    {
        Order::where('id',$id)->update([
            'enclose_date'=>Carbon::now(),
            'enclose_by'=> Auth::user()->id,
            'order_status'=>4
        ]);
    }


}
