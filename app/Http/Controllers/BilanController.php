<?php

namespace App\Http\Controllers;

use App\Exports\BilanExport;
use App\Models\Recette;
use App\Rules\ProductInStock;
use Illuminate\Http\Request;
use App\Repositories\BilanRepository;
use App\Rules\QuantityRule;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BilanController extends Controller
{

    private $bilanRepository;

    public function __construct(BilanRepository $bilanRepository)
    {
        $this->bilanRepository = $bilanRepository;

        $this->middleware('permission:liste_bilan', ['only' => ['BilanProduitRecette']]);
        $this->middleware('permission:ajouter_bilan', ['only' => ['BilanProduitRecetteCreate','BilanProduitRecetteStore']]);
        $this->middleware('permission:supprimer_bilan', ['only' => ['BilanProduitRecetteDelete']]);
        $this->middleware('permission:afficher_bilan', ['only' => ['BilanProduitRecetteView']]);

    }

    public function BilanProduitRecette()
    {
        $query = $this->bilanRepository->ListeBilanRecetteProduits();

        if (request()->ajax()) {
            return datatables()->of($query->get())
                ->addColumn('action', 'pages.bilans._action-menu')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }


        addJavascriptFile('shop/bilans/table.js');

        return view('pages.bilans.bilan-recette-produit');
    }

    public function BilanProduitRecetteCreate(Request $request)
    {

        $recettes = Recette::where('is_deleted',0)->get();


        addJavascriptFile('shop/bilans/add.js');

        return view('pages.bilans.bilan-recette-produit-create', compact('recettes'));
    }


    public function BilanProduitRecetteStore(Request $request)
    {
        if($request->ajax())
        {

            $error = Validator::make(
                $request->all(),[
                    'quantity.*'=> [new QuantityRule()],
                ]

            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->bilanRepository->BilanProduitRecetteStore($request);

            return response()->json($resp);
        }
    }


    public function BilanProduitRecetteDelete(Request $request)
    {
        $id = $request->id;

        $resp = $this->bilanRepository->delete($id);

        return response()->json($resp);
    }


    public function BilanProduitRecetteView($reference)
    {
        $data = $this->bilanRepository->BilanProduitRecetteView($reference);

        $bilan_recettes = $data['bilan_recettes'];

        $bilan = $data['bilan'];

        return view('pages.bilans.bilan-recette-produit-view', compact('bilan_recettes','bilan'));
    }


    public function exportBilanExcel($reference)
    {
        return Excel::download(new BilanExport($reference), 'bilan.xlsx');
    }

    public function BilanProduitRecetteValidate($reference)
    {
        $data = $this->bilanRepository->BilanProduitRecetteView($reference);

        $bilan_recettes = $data['bilan_recettes'];

        $bilan = $data['bilan'];


        addJavascriptFile('shop/bilans/validate.js');

        return view('pages.bilans.bilan-recette-produit-validate', compact('bilan_recettes','bilan'));
    }


    public function storeBilanProductValidate(Request $request)
    {

        if($request->ajax())
        {
            $error = Validator::make(
                $request->all(),[
                    'products.*'=> [new ProductInStock() ],
                ]
            );
            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }
            $resp = $this->bilanRepository->storeBilanProductValidate($request);
            
            return response()->json($resp);
        }



    }

}
