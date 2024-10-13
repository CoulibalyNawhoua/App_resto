<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\ProductUnit;
use Carbon\Carbon;
use App\Models\Reception;
use App\Models\Procurement;
use App\Models\StockProduit;
use Illuminate\Http\Request;
use App\Models\ReceptionProcuct;
use App\Repositories\Repository;
use App\Models\ProcurementProduct;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;



class ReceptionProduitRepository extends Repository
{
    public function __construct(Reception $model)
    {
        $this->model = $model;
    }

    public function purchasesReceiptList()
    {

        return Reception::selectRaw('receptions.reception_date, receptions.add_date, receptions.id, receptions.reference AS reception_ref, receptions.total_receipt_price, procurements.reference AS procurement_ref, CONCAT(users.first_name," ",users.last_name) as auteur, CONCAT(fournisseurs.nom," ",fournisseurs.prenom) as fournisseur, receptions.procurements_id, receptions.receipt_status')
            ->leftJoin('users','users.id','receptions.added_by')
            ->leftJoin('procurements','procurements.id','receptions.procurements_id')
            ->leftJoin('fournisseurs','fournisseurs.id','procurements.fournisseur_id')
            ->whereNotNull('procurements_id')
            ->where('receptions.is_deleted',0);

    }

    public function storeProcurementReceipt(Request $request) {

        $depot_stockage_id = $request->depot_stockage;
        $date_reception = $request->date_reception;
        $commentaire = $request->commentaire;
        $quantity_received = $request->quantity_received;
        $quantity= $request->quantity;
        $purchase_price = $request->purchase_price;
        $total_purchase_price = $request->total_purchase_price;
        $invoice_reference = $request->invoice_reference;
        $total_receipt_price = $request->total_receipt_price;
        $products = $request->products;
        $mark_received = $request->mark_received;
        $procurement_id = $request->procurement_id;
        $product_unit = $request->product_unit;
        $product_count = $request->product_count;

        $procurement =  Procurement::where('id', $procurement_id)->firstOrFail();

        /*$procurement->update([
            'procurment_status' => 2
        ]);*/

        $receipt = Reception::create([
            'reference'=>  $this->referenceGenerator('Reception'),
            'invoice_reference' => $invoice_reference,
            'reception_date' => $date_reception,
            'note' => $commentaire,
            'procurements_id' => $procurement->id,
            'total_receipt_price' => $total_receipt_price,
            'added_by' => Auth::user()->id,
            'add_date' => Carbon::now(),
            'add_ip' => $this->getIp(),
            'entite_id' => $depot_stockage_id,
        ]);

        for ($count=0; $count < count($mark_received) ; $count++) {

            $explode = explode('|',$products[$count]);

            $product_id = $explode[0];

            $procurementProduct_id = $explode[1];


            $product =  Produit::where('id', $product_id)->first();


            $productUnit = ProductUnit::where('id',  $product_unit[$count])->first();

            if ($mark_received[$count] == 1) {

                ReceptionProcuct::create([
                    'quantity_received' => $quantity_received[$count],
                    'quantity' => $quantity[$count],
                    'unit_price' => $purchase_price[$count],
                    'produit_id' => $product->id,
                    'receptions_id' => $receipt->id,
                    'procurement_product_id' => $procurementProduct_id,
                    'unit_quantity' => $productUnit->pcb,
                    'product_unit_id'=> $product_unit[$count]
                ]);

                $find_stock_product = StockProduit::where([
                    ['produit_id' ,'=', $product->id],
                    ['entite_id' ,'=',  $depot_stockage_id],
                    ['unite_id', '=', $product->unites_id]
                ])->first();

                if (is_null($find_stock_product)) {
                    StockProduit::create([
                        'produit_id' =>  $product->id,
                        'entite_id' => $depot_stockage_id,
                        'quantite' => ($quantity_received[$count] * $productUnit->pcb),
                        'unite_id' => $product->unites_id
                    ]);
                } else {
                    $find_stock_product->increment('quantite', ($quantity_received[$count] * $productUnit->pcb));
                }
                ProcurementProduct::where('id', $procurementProduct_id)->update([
                    'quantity_received' => $quantity_received[$count]
                ]);
            }
        }
    }


/*    public function saveReceiptUpdate(Request $request, $id)
    {
        $depot_stockage_id = $request->depot_stockage_id;
        $date_reception = $request->date_reception;
        $commentaire = $request->commentaire;
        $quantity_received = $request->quantity_received;
        $purchase_price = $request->purchase_price;
        $total_purchase_price = $request->total_purchase_price;
        $invoice_reference = $request->invoice_reference;
        $total_receipt_price = $request->total_receipt_price;
        $products = $request->products;
        $mark_received = $request->mark_received;

        $reception = $this->model->find($id);

        $reception->update([
            'invoice_reference' => $invoice_reference,
            'reception_date' => $date_reception,
            'note' => $commentaire,
            'total_receipt_price' => $total_receipt_price,
            'edited_by' => Auth::user()->id,
            'edit_date' => Carbon::now(),
            'edit_ip' => $this->getIp(),
            'entite_id' => $depot_stockage_id,
        ]);

        for ($count=0; $count < count($mark_received) ; $count++) {

            $product = explode('|',$products[$count]);

            $product_id = $product[0];

            $procurementProduct_id = $product[1];




            if ($mark_received[$count] == 1) {

               $productReception = ReceptionProcuct::where([
                   ['procurement_product_id','=',$procurementProduct_id],
                   ['produit_id','=',$product_id]
               ])->first();

                if (is_null($productReception)) {

                    $qtsk = StockProduit::where([
                        ['produit_id' ,'=', $product_id],
                        ['entite_id' ,'=',  $depot_stockage_id],
                    ])->first();

                    if(is_null($qtsk)){
                        StockProduit::create([
                            'produit_id' =>  $product_id,
                            'entite_id' => $depot_stockage_id,
                            'quantite' => $quantity_received[$count]
                        ]);
                    }else{
                        $qtsk->increment('quantite', $quantity_received[$count]);
                    }

                } else {
                    ReceptionProcuct::create([
                        'quantity_received' => $quantity_received[$count],
                        'unit_price' => $purchase_price[$count],
                        'produit_id' => $product_id,
                        'receptions_id' => $reception->id,
                        'procurement_product_id' => $procurementProduct_id
                    ]);

                    StockProduit::create([
                        'produit_id' =>  $product_id,
                        'entite_id' => $depot_stockage_id,
                        'quantite' => $quantity_received[$count]
                    ]);
                }

                $productItem = ProcurementProduct::where('id', $procurementProduct_id)->first();

                $productItem->increment('quantity_received', $quantity_received[$count]);

                $productItem->update(['product_receipt_status' => 1]);
            }

        }


    }*/


    public function ProcurementReceptionView($id)
    {
        $reception = $this->model->find($id);

        $procurement = Procurement::where('id', $reception->procurements_id)->first();

        $data = [
            'reception' => $reception,
            'procurement' => $procurement
        ];

        return $data;
    }


    public function printReceiptProcurement($id)
    {
        $reception = $this->model->findOrFail($id);

        return $reception;


    }

    public function receiptProductDelete($id)
    {
        $reception = $this->model->find($id);

        $reception->update([
            'is_deleted'=>1,
            'delete_ip'=>$this->getIp(),
            'deleted_by'=> Auth::user()->id,
            'delete_date'=> Carbon::now(),
        ]);

        $receptionProduct = ReceptionProcuct::where('receptions_id', $reception->id)->get();

        foreach ($receptionProduct as $item) {

            $qteProduct = StockProduit::where([
                ['produit_id' ,'=', $item->produit_id],
                ['entite_id' ,'=',  $reception->entite_id],
                ['unite_id', '=',$item->product_unit_id]
            ])->first();

            $qteProduct->decrement('quantite', $item->quantity_received);

            if ($qteProduct->quantite < 0){
                $qteProduct->update([
                    'quantite'=>0
                ]);
            }
        }
    }

    public function ReceiptProductView($reference)
    {
        $reception = $this->model->where('reference', $reference)->firstOrFail();

        $procurement = Procurement::where('id', $reception->procurements_id)->firstOrFail();

        $data = [
            'reception' => $reception,
            'procurement' => $procurement
        ];

        return $data;
    }

    public function cancelReceiptProcess(mixed $id)
    {

        $reception = $this->model->find($id);

        $receptionProduct = ReceptionProcuct::where('receptions_id', $reception->id)->get();

        foreach ($receptionProduct as $item) {

            $qteProduct = StockProduit::where([
                ['produit_id' ,'=', $item->produit_id],
                ['entite_id' ,'=',  $reception->entite_id],
                ['unite_id', '=',$item->product_unit_id]
            ])->first();

            $qteProduct->decrement('quantite', $item->quantity_received);

            if ($qteProduct->quantite < 0){
                $qteProduct->update([
                    'quantite'=>0
                ]);
            }
        }

        $reception->update([
            'receipt_status'=>0
        ]);

       /* $reception = $this->model->find($id);

        if (!empty($reception->procurements_id)){

            $procurement = Procurement::where('id', $reception->procurements_id)->first();

            $receptionProduct = $reception->produitReceptions();

            foreach ($receptionProduct as $item) {

                $qteStock = StockProduit::where([
                        ['produit_id' ,'=', $item->produit_id],
                        ['entite_id' ,'=',  $procurement->entite_id],
                        ['unite_id', '=',$item->product_unit_id]
                    ])->first();

                $qteStock->decrement('quantite', $item->quantity_received);

                if($qteStock->quantite < 0){
                    $qteStock->update([
                        'quantite'=>0
                    ]);
                }
            }
        }
        elseif (!empty($reception->order_id)){

            $order = Order::where('id', $reception->order_id)->first();

            $orderProduct = $order->orderProducts();

            foreach ($orderProduct as $item) {

                $qteStock = StockProduit::where([
                    ['produit_id' ,'=', $item->produit_id],
                    ['entite_id' ,'=',  $order->entite_id],
                    ['unite_id', '=',$item->product_unit_id]
                ])->first();

                $qteStock->decrement('quantite', $item->quantity_received);
                if($qteStock->quantite < 0){
                    $qteStock->update([
                        'quantite'=>0
                    ]);
                }
            }
        }
        else{
            ///////////
        }*/
    }
}
