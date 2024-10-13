<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduitRequest;
use App\Models\Produit;
use App\Models\StockProduit;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{


    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;

        $this->middleware('permission:liste_produit', ['only' => ['index']]);
        $this->middleware('permission:ajouter_produit', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_produit', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_produit', ['only' => ['produit_delete']]);
        $this->middleware('permission:consultation_stock_depot_stockage', ['only' => ['products_stock_status']]);

    }


    public function index()
    {


        $query = $this->produitRepository->ListeProduits();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.produits._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }



        // $sous_familles = $this->produitRepository->selectSousFamille();

        // $unites = $this->produitRepository->selectUnit();

        // $categories = $this->produitRepository->selectCategorie();

        addJavascriptFile('shop/produits/table.js');

        return view('pages.produits.index');
    }


    public function produit_view(Request $request)
    {
        $id = $request->id;

        $resp = $this->produitRepository->view($id);

        return response()->json($resp);
    }



    public function produit_delete(Request $request)
    {
        $id = $request->id;

        $resp = $this->produitRepository->delete($id);

        return response()->json($resp);
    }



    public function store(Request $request)
    {
        if($request->ajax())
        {
            $messages = [
                'produit_a_une_unite.gt' => 'Veuillez creér vos unités de gestion de stock.',
                'unite_id.gt' => 'Veuillez Choisir l\'unité de stockage du produit.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'produit_a_une_unite' => ['gt:0'],
                    'nom_produit' => ['required'],
                    // 'sous_famille_id' => ['required'],
                    'categorie_id' => ['required'],
                    'unite_id' => ['required'],
                    'unites.*' => ['required'],
                    'price.*'=> ['numeric','min:0'],
                    'pcb.*'=> ['numeric','min:0']

                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->produitRepository->storeProduct($request);

            return response()->json($resp);
        }

        return response()->json('ajax not found query');

    }



    public function get_single_product(Request $request)
    {
        $id = $request->product_id;

        $resp = $this->produitRepository->get_single_product($id);

        return response()->json($resp);
    }



    public function create()
    {

        $sous_familles = $this->produitRepository->selectSousFamille();

        $unites = $this->produitRepository->selectUnit();


        $categories = $this->produitRepository->selectCategorie();

        addJavascriptFile('shop/produits/add.js');


        return view('pages.produits.create', compact('sous_familles','unites','categories'));
    }



    public function show(string $id)
    {
        //
    }



    public function edit(string $id)
    {
        $product = $this->produitRepository->getProduct($id);


        $sous_familles = $this->produitRepository->selectSousFamille();

        $unites = $this->produitRepository->selectUnit();

        $categories = $this->produitRepository->selectCategorie();

        addJavascriptFile('shop/produits/edit.js');

        return view('pages.produits.edit', compact('product','sous_familles','unites','categories'));
    }



    public function update(Request $request, string $id)
    {

        if($request->ajax())
        {
            $messages = [
                'produit_a_une_unite.gt' => 'Veuillez creér vos unités de gestion de stock.',
                'unite_id.gt' => 'Veuillez Choisir l\'unité de stockage du produit.',
            ];

            $error = Validator::make(
                $request->all(),[
                    'produit_a_une_unite' => ['gt:0'],
                    'nom_produit' => ['required'],
                    // 'sous_famille_id' => ['required'],
                    'categorie_id' => ['required'],
                    'unite_id' => ['required'],
                    'unites.*' => ['required'],
                    'price.*'=> ['numeric','min:0'],
                    'pcb.*'=> ['numeric','min:0']

                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->produitRepository->updateProduct($request, $id);

            return response()->json($resp);
        }

        return response()->json('ajax not found query');



    }
    public function destroy(string $id)
    {
        //
    }

    public function delete_unit_product(Request $request)
    {
        $id = $request->id;

        $resp = $this->produitRepository->deleteUnitProduct($id);

        return response()->json($resp);
    }


    public function unit_product_select(Request $request)
    {
        $product_id = $request->product_id;

        $resp = $this->produitRepository->getProductUnit($product_id);

        return response()->json($resp);

    }


    public function charge_product_destination_select(Request $request)
    {
        $code = $request->departement_code;

        $resp = $this->produitRepository->selectProduct();

        return response()->json($resp);
    }

    public  function search_product_stock_depot(Request $request)
    {
        $depot_id = Auth::user()->entite_id;

        $response = Produit::selectRaw('produits.id, produits.nom_produit')
            ->leftJoin('stock_products','stock_products.produit_id','=','produits.id')
            ->leftJoin('entites','entites.id','=','stock_products.entite_id')
            ->where('produits.is_deleted', 0)
            ->where('stock_products.entite_id', $depot_id);

        $response->where('produits.nom_produit', 'LIKE', "%{$request->input('q')}%");

        $data = $response->get();

        return response()->json($data);
    }

    public function get_single_product_depot(Request $request)
    {
        $id =$request->product_id;

        $product = $this->produitRepository->singleProductDepot($id);

        return response()->json($product, 200);
    }


    public function products_stock_status()
    {
        $query = $this->produitRepository->productStokView();


        if (request()->ajax()) {
            return datatables()->of($query->get())
                ->addIndexColumn()
                ->make(true);
        }

        addJavascriptFile('shop/produits/product-etat-stock.js');
        return view('pages.produits.product_stock');
    }


    public function produit_select(Request $request)
    {
        $product = $this->produitRepository->selectProduitSemiFini();

        return response()->json($product, 200);
    }


    public function search_product_semi_fini(Request $request)
    {
        $response = Produit::selectRaw('produits.id, produits.nom_produit')
            ->leftJoin('categories','categories.id','=','produits.categories_id')
            ->where('categories.code_categorie','=','002');

        $response->where('produits.nom_produit', 'LIKE', "%{$request->input('q')}%");

        $data = $response->get();

        return response()->json($data);
    }

    public function search_product_matiere_premiere(Request $request)
    {
        $depot_id = Auth::user()->entite_id;

        $response = Produit::selectRaw('produits.id, produits.nom_produit')
            ->leftJoin('stock_products','stock_products.produit_id','=','produits.id')
            ->leftJoin('categories','categories.id','=','produits.categories_id')
            ->leftJoin('entites','entites.id','=','stock_products.entite_id')
            ->where('categories.code_categorie', '=', '001')
            ->where('stock_products.entite_id', $depot_id);

        $response->where('produits.nom_produit', 'LIKE', "%{$request->input('q')}%");

        $data = $response->get();

        return response()->json($data);
    }
}
