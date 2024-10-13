<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieRequest;
use App\Repositories\CategorieRepository;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;

        $this->middleware('permission:liste_categorie_produit', ['only' => ['index']]);
        $this->middleware('permission:ajouter_categorie_produit', ['only' => ['store']]);
        $this->middleware('permission:modifier_categorie_produit', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_categorie_produit', ['only' => ['categorie_delete']]);

    }

    public function index()
    {

        $query = $this->categorieRepository->ListeCategories();

        if (request()->ajax()) {
            return datatables()->of($query->get())
            ->addColumn('action', 'pages.categories._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        $sous_familles = $this->categorieRepository->selectSousFamille();

        addJavascriptFile('shop/categories/table.js');

        return view('pages.categories.index', compact('sous_familles'));
    }


    public function store(StoreCategorieRequest $request)
    {
        $resp = $this->categorieRepository->store($request);

        return response()->json($resp);

    }

    public function categorie_view(Request $request)
    {
        $id = $request->id;

        $resp = $this->categorieRepository->view($id);

        return response()->json($resp);
    }


    public function categorie_delete(Request $request)
    {
        $id = $request->id;

        $resp = $this->categorieRepository->delete($id);

        return response()->json($resp);
    }
}
