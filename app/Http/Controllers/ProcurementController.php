<?php

namespace App\Http\Controllers;

use App\Repositories\ProcurementRepository;
use App\Repositories\ReceptionProduitRepository;
use App\Rules\QuantityReceivedProcurementValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class ProcurementController extends Controller
{

    private $procurmentRepository;
    private $receptionProduitRepository;

    public function __construct(
        ProcurementRepository $procurmentRepository,

    )

    {
        $this->procurmentRepository = $procurmentRepository;

        $this->middleware('permission:liste_achat', ['only' => ['procurementIndex']]);
        $this->middleware('permission:ajouter_achat', ['only' => ['procurementCreate','procurementStore']]);
        $this->middleware('permission:modifier_achat', ['only' => ['procurementEdit','procurementUpdate']]);
        // $this->middleware('permission:afficher_achat', ['only' => ['procurementsView']]);
        $this->middleware('permission:supprimer_achat', ['only' => ['procurementsDelete']]);





    }



    public function procurementIndex()
    {
        $query = $this->procurmentRepository->purchasesList();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.procurements._procurement-action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/procurments/procurement-table.js');

        return view('pages.procurements.procurment-provider-index');
    }


    public function procurementCreate(Request $request)
    {

        $products = $this->procurmentRepository->selectProduct();

        $fournisseurs = $this->procurmentRepository->selectFournisseur();

        $depot_stockages  = $this->procurmentRepository->selectDepotPrincipal();

        addJavascriptFile('shop/procurments/procurment-add.js');

        return view('pages.procurements.procurment-provider-create', compact('products', 'fournisseurs', 'depot_stockages'));
    }


    public function procurementStore(Request $request)
    {

        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été fourni.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                    'depot_stockage'=>  ['required'],
                    'fournisseur'=> ['required']
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }
            $resp = $this->procurmentRepository->purchaseStore($request);

            return response()->json($resp);
        }


    }

    public function procurementEdit($reference)
    {
        $data = $this->procurmentRepository->procurement_view($reference);

        $products = $this->procurmentRepository->selectProduct();

        $fournisseurs = $this->procurmentRepository->selectFournisseur();

        $depot_stockages  = $this->procurmentRepository->selectDepotPrincipal();

        $procurment =$data['procurement'];

        $procurement_products =$data['procurement_products'];



        addJavascriptFile('shop/procurments/procurment-edit.js');


        return view('pages.procurements.procurment-provider-edit', compact('procurment', 'products','fournisseurs','procurement_products','depot_stockages'));
    }


    public function procurementUpdate(Request $request, $id)
    {

        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été fourni.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                    'depot_stockage'=>['required'],
                    'fournisseur'=> ['required']
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->procurmentRepository->purchaseUpdate($request, $id);
            return response()->json($resp);
        }
    }






    public function delete_procurement_item(Request $request) {
        $id = $request->id;

        $resp = $this->procurmentRepository->deleteProcurementItem($id);

        return response()->json($resp);

    }

    public function procurementsView($id)
    {
        $data = $this->procurmentRepository->procurement_view_by_id($id);


        $path_print = public_path('shop/media/logos/distriforce.png');
        $type_print= pathinfo($path_print, PATHINFO_EXTENSION);
        $data_print = file_get_contents($path_print);
        $img  = 'data:image/' . $type_print . ';base64,' . base64_encode($data_print);


        $procurement = $data['procurement'];
        $procurement_products = $data['procurement_products'];

        $datas = [
            'procurement' => $procurement,
            'image'=>$img,
            'procurement_products' => $procurement_products
        ];

        $pdf = PDF::loadView('pages.procurements.procurement-detail', $datas);

        return $pdf->stream('invoice-fr.pdf');
    }





    public function acceptedProcurementProcess(Request $request)
    {
        $id = $request->id;

        $resp = $this->procurmentRepository->acceptedProcurementProcess($id);

        return response()->json($resp);
    }


    public function rejectedProcurementProcess(Request $request)
    {
        $id = $request->id;

        $resp = $this->procurmentRepository->rejectedProcurementProcess($id);

        return response()->json($resp);
    }


    public  function procurementView($reference)
    {
        $data = $this->procurmentRepository->procurement_view($reference);

        $procurment =$data['procurement'];

        $procurement_products =$data['procurement_products'];


        addJavascriptFile('shop/procurments/procurement-view.js');


        return view('pages.procurements.procurment-provider-view', compact('procurment', 'procurement_products'));
    }


    public function closedProcurementProcess(Request $request)
    {
        $id = $request->id;

        $resp = $this->procurmentRepository->closedProcurementProcess($id);

        return response()->json($resp);

    }




}
