<?php

namespace App\Http\Controllers;

use App\Rules\QuantityEnteredRules;
use App\Rules\QuantityReceivedValidation;
use App\Rules\QuantityValidate;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Rules\CheckProductQuantite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;

class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;

        $this->middleware('permission:liste_commande', ['only' => ['orderIndex']]);
        $this->middleware('permission:ajouter_commande', ['only' => ['orderCreate','orderStore']]);
        $this->middleware('permission:modifier_commande', ['only' => ['orderEdit','orderUpdate']]);
        $this->middleware('permission:liste_reception_commande', ['only' => ['orderReceiptIndex']]);
        $this->middleware('permission:creer_bon_livraison_commande', ['only' => ['orderDeliveryCreate','orderDeliveryStore']]);

        $this->middleware('permission:commande_departement_production', ['only' => ['orderProductionCreate']]);
        $this->middleware('permission:commande_departement_central', ['only' => ['orderCentralCreate']]);

        //gestion des commande en provenant des autre dépot
        $this->middleware('permission:liste_commande_depot_stockage', ['only' => ['orderStorehouseIndex']]);
        $this->middleware('permission:liste_bon_livraison_commande', ['only' => ['orderStorehouseDelivery']]);

        //gestion reception commande
        $this->middleware('permission:ajouter_reception_commande', ['only' => ['orderReceiptCreate']]);

    }

    public function orderIndex() {

        $query = $this->orderRepository->orderList();

        if (request()->ajax()) {
            return datatables()->of($query->get())
            ->addColumn('action', 'pages.orders._order-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/orders/order-table.js');

        return view('pages.orders.order-index');
    }

    // public function orderCreate()  {

    //     $destinations = $this->orderRepository->selectDepotForOrder();

    //     $categories = $this->orderRepository->selectCategorie();

    //     addJavascriptFile('shop/orders/order-create.js');

    //     return view('pages.orders.order-create', compact('categories', 'destinations'));
    // }

    public function orderStore(Request $request) {

        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été fourni.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->orderRepository->orderStore($request);

            return response()->json($resp);
        }
    }

    public function orderEdit($reference) {


        $data = $this->orderRepository->order_view_by_reference($reference);

        $order =$data['$order'];

        $order_products =$data['order_products'];

        $destination_code = $order->destination->departement->code_depart;

        $depot_stockage_code = $order->entite->departement->code_depart;


        if($destination_code == 'DP-001'){

            $destinations = $this->orderRepository->selectDepartementCentralAchat();

            if($depot_stockage_code == 'DP-003'){

                $dataProduct = $this->orderRepository->selectProduitFini();

            }

            if($depot_stockage_code == 'DP-002'){

                $dataProduct = $this->orderRepository->selectMatierePremiere();

            }
        }

        if ($destination_code == 'DP-002'){

            $destinations = $this->orderRepository->selectDepartementProductionentral();

            if($depot_stockage_code == 'DP-003'){

                $dataProduct = $this->orderRepository->selectProduitSemiFini();

            }
        }

        addJavascriptFile('shop/orders/order-edit.js');

        return view('pages.orders.order-edit', compact('dataProduct', 'destinations', 'order', 'order_products'));
    }

    public function deleteOrderItem(Request $request) {

        $id = $request->id;

        $resp = $this->orderRepository->deleteOrderItem($id);
        return response()->json($resp);

    }

    public function orderDelete(Request $request)
    {
        $id = $request->id;

        $resp = $this->orderRepository->delete($id);
        return response()->json($resp);
    }


    public function orderUpdate(Request $request, $reference) {

        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été fourni.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->orderRepository->orderUpdate($request, $reference);

            return response()->json($resp);
        }

    }


    public function orderDeliveryCreate($reference) {

        $data = $this->orderRepository->orderView($reference);

        $orderProducts = $data['orderProducts'];

        $order = $data['order'];


        $entrepots = $this->orderRepository->selectDepots();


        addJavascriptFile('shop/orders/order-delivery-create.js');

        return view('pages.orders.order-delivery-create', compact('orderProducts', 'order','entrepots'));
    }


    public function orderDeliveryStore(Request $request) {

        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été cochet.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                    'products.*'=> [new CheckProductQuantite],
                    /*'quantity.*'=> [new QuantityValidate],*/
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->orderRepository->orderDeliveryStore($request);

            return response()->json($resp);
        }


        return response()->json('ajax not found query');

    }


    public function orderPrint($reference)  {


        $order = $this->orderRepository->modelByReference($reference);

        $path_print = public_path('shop/media/logos/distriforce.png');
        $type_print= pathinfo($path_print, PATHINFO_EXTENSION);
        $data_print = file_get_contents($path_print);
        $img  = 'data:image/' . $type_print . ';base64,' . base64_encode($data_print);

        $datas = [
            'order' => $order,
            'image'=>$img,
        ];

        $pdf = PDF::loadView('pages.orders.order-print', $datas);

        return $pdf->stream('invoice.pdf');

    }

    public function orderReceiptIndex() {

        $query = $this->orderRepository->orderReceipt();

        if (request()->ajax()) {
            return datatables()->of($query->get())
            ->addColumn('action', 'pages.orders._order-receipt-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        addJavascriptFile('shop/orders/orders-receipt.js');

        return view('pages.orders.order-receipt');
    }


    //liste des commande ds depots vue par les receveur de commande
    public function orderStorehouseIndex() {

        $query = $this->orderRepository->OrderStoreHouse();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.orders._order-storehouse-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        addJavascriptFile('shop/orders/order-storehouse.js');

        return view('pages.orders.order-storehouse');
    }


    //liste des bon de livraison
    public function orderStorehouseDelivery() {

        $query = $this->orderRepository->OrderStoreHouseDelivery();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.orders._order-delivery-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/orders/order-delivery.js');

        return view('pages.orders.order-delivery');
    }


    public function orderProductionCreate()
    {
        $products = $this->orderRepository->selectProduitSemiFini();

        $destinations = $this->orderRepository->selectDepartementProductionentral();

        addJavascriptFile('shop/orders/order-create.js');

        return view('pages.orders.order-production-create', compact('products','destinations'));
    }


    public function orderCentralCreate()
    {
        $code_depart = Auth::user()->entite->departement->code_depart;

        if($code_depart == 'DP-003'){
            $dataProduct = $this->orderRepository->selectProduitFini();
        }elseif ($code_depart == 'DP-002'){

            $dataProduct = $this->orderRepository->selectMatierePremiere();
        }
        else{
            $dataProduct = '';
        }
        $products = $dataProduct;

        $destinations = $this->orderRepository->selectDepartementCentralAchat();

        addJavascriptFile('shop/orders/order-create.js');

        return view('pages.orders.order-central-create', compact('products','destinations'));
    }

    public function orderAcceptProcess(Request $request)
    {

        $resp = $this->orderRepository->orderAcceptProcess($request);

        return response()->json($resp);
    }

    public function orderCancelProcess(Request $request)
    {

        $resp = $this->orderRepository->orderCancelProcess($request);

        return response()->json($resp);
    }

    public function orderValidate(Request $request)
    {
        $id = $request->id;

        $resp = $this->orderRepository->orderValidate($id);

        return response()->json($resp);
    }

    public function orderReceiptCreate($reference)
    {
        $data = $this->orderRepository->order_view_by_reference($reference);

        $order =$data['$order'];

        $order_products =$data['order_products'];

        addJavascriptFile('shop/orders/receipt-add.js');

        return view('pages.orders.receipt-order-create', compact('order','order_products'));
    }

    public function orderReceiptStore(Request $request)
    {
        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été cochet.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count' => ['gt:0'],
                    'quantite.*' => [new QuantityReceivedValidation()],
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->orderRepository->orderReceiptStore($request);

            return response()->json($resp);
        }

        return response()->json('ajax not found query');
    }

    public function senderOrderDelivery(Request $request)
    {

        $id = $request->id;
        $resp = $this->orderRepository->senderOrderDelivery($id);

        return response()->json($resp);

    }

    public function orderDeliveryPrint($delivery_reference)
    {
        $data = $this->orderRepository->printOrderDelivery($delivery_reference);

        $path_print = public_path('shop/media/logos/distriforce.png');
        $type_print= pathinfo($path_print, PATHINFO_EXTENSION);
        $data_print = file_get_contents($path_print);
        $img  = 'data:image/' . $type_print . ';base64,' . base64_encode($data_print);

        $datas = [
            'order' => $data['order'],
            'image'=> $img,
            'delivery'=> $data['delivery'],
            'deliveryProduct' => $data['deliveryProduct']
        ];


        $pdf = PDF::loadView('pages.orders.delivery-print', $datas);

        return $pdf->stream('bon-livraison.pdf');

    }

    public function deliveryCancel(Request $request, $id)
    {
        $resp = $this->orderRepository->deliveryCancel($request, $id);

        return response()->json($resp);
    }

    public function deliveryAccepted(Request $request)
    {
        $id = $request->id;

        $resp = $this->orderRepository->deliveryAccepted($id);

        return response()->json($resp);
    }

    public function orderDeliveryView($reference)
    {
        $data = $this->orderRepository->orderDeliveryVew($reference);

        $order = $data['order'];
        $delivery = $data['delivery'];
        $deliveryProducts = $data['deliveryProducts'];

        addJavascriptFile('shop/orders/order-view.js');

        return view('pages.orders.order-delivery-view', compact('order', 'deliveryProducts','delivery'));
    }

    public function closeOrderReceipt(Request $request)
    {
        $id = $request->id;

        $resp = $this->orderRepository->closeOrderReceipt($id);

        return response()->json($resp);

    }

    public function orderStorehouseView($reference)
    {
        $order = $this->orderRepository->modelByReference($reference);

        return view('pages.orders.order-view', compact('order'));
    }

    public function orderReceiptView($reference)
    {
        $reception = $this->orderRepository->orderReceiptVew($reference);

        $path_print = public_path('shop/media/logos/distriforce.png');
        $type_print= pathinfo($path_print, PATHINFO_EXTENSION);
        $data_print = file_get_contents($path_print);
        $img  = 'data:image/' . $type_print . ';base64,' . base64_encode($data_print);

        $datas = [
            'image'=> $img,
            'reception'=> $reception,
        ];

        $pdf = PDF::loadView('pages.orders.order-receipt-print', $datas);

        return $pdf->stream('bon-reception.pdf');
    }



}
