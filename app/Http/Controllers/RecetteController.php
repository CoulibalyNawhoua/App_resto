<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\RecetteRepository;
use Illuminate\Support\Facades\Validator;

class RecetteController extends Controller
{
    private $recetteRepository;

    public function __construct(RecetteRepository $recetteRepository)
    {
        $this->recetteRepository = $recetteRepository;

        $this->middleware('permission:liste_recette', ['only' => ['recetteIndex']]);
        $this->middleware('permission:ajouter_recette', ['only' => ['recetteCreate','recetteStore']]);
        $this->middleware('permission:modifier_recette', ['only' => ['recetteEdit','recetteUpdate']]);
        $this->middleware('permission:supprimer_recette', ['only' => ['recetteDelete']]);
    }

    public function recetteIndex()
    {

        $query = $this->recetteRepository->ListeRecettes();

        if (request()->ajax()) {
            return datatables()->of($query->get())
                ->addColumn('action', 'pages.recettes._action-menu')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }


        addJavascriptFile('shop/recettes/table.js');
        return view('pages.recettes.index');
    }

    public function recetteCreate()
    {

        addJavascriptFile('shop/recettes/add.js');

        return view('pages.recettes.create');
    }

    public function recetteStore(Request $request)
    {
        if($request->ajax())
        {

            $error = Validator::make(
                $request->all(),[
                    'libelle'=> ['required'],
                    'unites.*'=> ['required'],
                    'produits.*'=> ['required'],
                ]

            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->recetteRepository->recetteStore($request);

            return response()->json($resp);
        }
    }

    public function recetteUpdate(Request $request, $id)
    {
        if($request->ajax())
        {

            $error = Validator::make(
                $request->all(),[
                    'libelle'=> ['required'],
                    'unites.*'=> ['required'],
                    'produits.*'=> ['required'],
                ]

            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->recetteRepository->recetteUpdate($request, $id);

            return response()->json($resp);
        }
    }

    public function recetteEdit($id)
    {
        $unites = $this->recetteRepository->selectUnit();

        $produits = $this->recetteRepository->selectProduitSemiFini();

        $recette = $this->recetteRepository->recetteView($id);

        addJavascriptFile('shop/recettes/edit.js');

        return view('pages.recettes.edit', compact('unites','produits','recette'));
    }

    public function ficheItemDelete(Request $request)
    {
        $id = $request->id;

        $resp = $this->recetteRepository->ficheItemDelete($id);

        return response()->json($resp);

    }


    public function recetteDelete(Request $request)
    {
        $id = $request->id;
        $resp = $this->recetteRepository->delete($id);
        return response()->json($resp);

    }


    public function recetteSearch(Request $request)
    {

        $SearchResult = [];

        if ($request->has('q')) {

            $query = $request->q;

            $SearchResult = DB::table('recettes')->select('name','id')
                                ->where('name', 'LIKE', '%'. $query. '%')
                                ->get();
        }

        return response()->json($SearchResult);
    }
}
