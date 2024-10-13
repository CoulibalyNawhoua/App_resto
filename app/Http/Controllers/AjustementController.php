<?php

namespace App\Http\Controllers;

use App\Models\Entite;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\CheckIfProduitNotStock;
use Illuminate\Support\Facades\Validator;
use App\Repositories\AjustementRepository;
use App\Rules\QuantityStockAjustementValidation;

class AjustementController extends Controller
{
    private $ajustementStockRepository;

    public function __construct(AjustementRepository $ajustementStockRepository)
    {
        $this->ajustementStockRepository = $ajustementStockRepository;

        $this->middleware('permission:liste_ajustement', ['only' => ['productAjustementIndex']]);
        $this->middleware('permission:ajouter_ajustement', ['only' => ['productAjustementCreate','ajustementStore','stockInitialization']]);
        $this->middleware('permission:supprimer_ajustement', ['only' => ['ajustementDelete']]);
        $this->middleware('permission:saisir_entre_stock', ['only' => ['productEntryStock']]);
        $this->middleware('permission:saisir_entre_stock', ['only' => ['productOutputStock']]);
    }


    public function productAjustementIndex()
    {
        $query = $this->ajustementStockRepository->adjustmentProductList();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.ajustements._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/ajustements/table.js');

        return view('pages.ajustements.index');
    }


   public function productAjustementCreate()
   {

       addJavascriptFile('shop/typeahead/bloodhound.js');
       addJavascriptFile('shop/typeahead/typeahead.bundle.js');
       addJavascriptFile('shop/typeahead/typeahead.jquery.js');
       addJavascriptFile('shop/ajustements/add.js');
       addCssFile('shop/typeahead/main.css');

        return view('pages.ajustements.create');
   }


   public function ajustementStore(Request $request)
   {

        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été fourni.',
                'type_ajustement.*.required' => 'Le champ opération à la ligne :position est obligatoire.',
                'unite.*.required' => 'Le champ unité à la ligne :position est obligatoire.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                    'unite.*' =>['required'],
                    'type_ajustement.*' =>['required'],
                    'quantite.*' =>[ new QuantityStockAjustementValidation()],
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->ajustementStockRepository->storeAjustement($request);

            return response()->json('ok');
        }
   }


    public function ajustementDelete(Request $request)
    {
        $id = $request->id;

        $resp = $this->ajustementStockRepository->ajustementDelete($id);

        return response()->json($resp);
   }


   public function typeAjustementSelect()
   {
        $resp = $this->ajustementStockRepository->typeAjustementSelect();

        return response()->json($resp);
   }


    public function stockInitialization()
    {
        $user = Auth::user();

        $site = Entite::where('id', $user->entite_id)->first();

        if ($site->departement->code_depart == "DP-002") {
            
            $products = $this->productProduction();

        }

        if ($site->departement->code_depart == "DP-003") {
            
            $products = $this->productAgence();

        }

        if ($site->departement->code_depart == "DP-001") {
            
            $products = $this->productCentral();

        }

        addJavascriptFile('shop/ajustements/init-stock.js');

        return view('pages.ajustements.stock-initialization', compact('products'));
    }

    public function stockInitializationStore(Request $request)
    {
        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été fourni.',
                'quantite.*.required' => 'Le champ quantité à la ligne :position est obligatoire.',
                'unite.*.required' => 'Le champ unité à la ligne :position est obligatoire.',
                'quantite.*.numeric' => 'Le champ quantité à la ligne :position est n\'est pas valide.',
                'quantite.*.min' => 'Le champ quantité à la ligne :position est n\'est pas valide.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'product_count'=> ['gt:0'],
                    'unite.*' =>['required'],
                    'quantite.*' =>['required','numeric','min:0.1'],
                    'products.*' =>[new CheckIfProduitNotStock]
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->ajustementStockRepository->stockInitializationStore($request);

            return response()->json('ok');
        }
    }

    function productProduction() {
        
        return  Produit::selectRaw('produits.id, produits.nom_produit')
                        ->leftJoin('categories','categories.id','=','produits.categories_id')
                        ->where('produits.is_deleted','=', 0)
                        ->where('categories.code_categorie','=','001')
                        ->Orwhere('categories.code_categorie','=','002')
                        ->get();
    }


    function productCentral() {
        
        return  Produit::selectRaw('produits.id, produits.nom_produit')
                        ->leftJoin('categories','categories.id','=','produits.categories_id')
                        ->where('produits.is_deleted','=', 0)
                        ->where('categories.code_categorie','=','001')
                        ->Orwhere('categories.code_categorie','=','003')
                        ->get();
    }

    function productAgence() {
        
        return  Produit::selectRaw('produits.id, produits.nom_produit')
                    ->leftJoin('categories','categories.id','=','produits.categories_id')
                    ->where('produits.is_deleted','=', 0)
                    ->where('categories.code_categorie','=','003')
                    ->Orwhere('categories.code_categorie','=','002')
                    ->get();
    }



}
