<?php

namespace App\Http\Controllers;

use App\Repositories\ProcurementRepository;
use App\Repositories\ReceptionProduitRepository;
use App\Rules\QuantityReceivedProcurementValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class ReceptionController extends Controller
{
    private $receptionProduitRepository;
    private $procurementRepository;

    public function __construct(ReceptionProduitRepository $receptionProduitRepository, ProcurementRepository $procurementRepository)
    {
        $this->receptionProduitRepository = $receptionProduitRepository;
        $this->procurementRepository = $procurementRepository;

        $this->middleware('permission:liste_reception_achat', ['only' => ['procurementReceiptIndex']]);
        $this->middleware('permission:ajouter_reception_achat', ['only' => ['procurementReceiptCreate','procurementReceiptStore']]);

    }

    function procurementReceiptIndex() {

        $query = $this->receptionProduitRepository->purchasesReceiptList();

        if (request()->ajax()) {
            return datatables()->of($query)
                ->addColumn('action', 'pages.procurements._receipt-action-menu')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        addJavascriptFile('shop/procurments/procurement-receipt.js');

        return view('pages.procurements.procurment-provider-receipt');
    }


    public  function procurementReceiptPrint($id)
    {

        $reception = $this->receptionProduitRepository->printReceiptProcurement($id);

        $path_print = public_path('shop/media/logos/distriforce.png');
        $type_print= pathinfo($path_print, PATHINFO_EXTENSION);
        $data_print = file_get_contents($path_print);
        $img  = 'data:image/' . $type_print . ';base64,' . base64_encode($data_print);


        $datas = [
            'image'=>$img,
            'reception'=>$reception
        ];


        $pdf = PDF::loadView('pages.procurements.procurement-print-receipt', $datas);

        return $pdf->stream('print-receipt.pdf');

    }

    public function receiptProductDelete(Request $request)
    {
        $id = $request->id;

        $resp = $this->receptionProduitRepository->receiptProductDelete($id);

        return response()->json($resp);
    }


    public function procurmentsProvidersReceiptView($reference)
    {

        $data = $this->receptionProduitRepository->ReceiptProductView($reference);

        $procurement = $data['procurement'];

        $reception = $data['reception'];

        return view('pages.procurements.procurment-provider-receipt-view', compact('procurement','reception'));
    }

    public function procurementReceiptCreate($id)
    {
        $fournisseurs = $this->receptionProduitRepository->selectFournisseur();

        $depot_stockages  = $this->receptionProduitRepository->selectDepotPrincipal();

        $data = $this->procurementRepository->procurement_view_by_id($id);

        $procurment = $data['procurement'];

        $procurement_products = $data['procurement_products'];


        $products = $this->receptionProduitRepository->selectProduct();

        addJavascriptFile('shop/procurments/procurment-receipt-add.js');



        return view('pages.procurements.procurment-provider-receipt-create', compact('fournisseurs','depot_stockages','procurment', 'products', 'procurement_products'));
    }


    public function procurementReceiptEdit($id)
    {
        $fournisseurs = $this->receptionProduitRepository->selectFournisseur();

        $depot_stockages  = $this->receptionProduitRepository->selectDepotPrincipal();

        $data = $this->receptionProduitRepository->ProcurementReceptionView($id);

        $procurment = $data['procurement'];

        $reception = $data['reception'];

        $products = $this->procurmentRepository->selectProduct();

        addJavascriptFile('shop/procurments/procurment-receipt-edit.js');

        return view('pages.procurements.procurment-provider-receipt-edit', compact('fournisseurs','depot_stockages','procurment', 'products', 'reception'));
    }


    function procurementReceiptStore(Request $request) {
        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'veuillez cocher la case correspondant aux produits reçus.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                    'quantity_received.*'=>[new QuantityReceivedProcurementValidation()]
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->receptionProduitRepository->storeProcurementReceipt($request);

            return response()->json($resp);
        }
    }

    public function procurementReceiptUpdate(request $request, $id)
    {
        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'veuillez cocher la case correspondant aux produits reçus.',
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

            $resp = $this->receptionProduitRepository->saveReceiptUpdate($request, $id);

            return response()->json($resp);
        }
    }


    public  function cancelReceiptProcess(Request $request)
    {
        $id = $request->id;

        $resp = $this->receptionProduitRepository->cancelReceiptProcess($id);

        return response()->json($resp);

    }
}
