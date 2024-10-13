<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSousFamilleRequest;
use App\Repositories\Sous_familleRepository;
use Illuminate\Http\Request;

class SousFamilleController extends Controller
{
    private $sous_familleRepository;

    public function __construct(Sous_familleRepository $sous_familleRepository)
    {
        $this->sous_familleRepository = $sous_familleRepository;

        $this->middleware('permission:liste_sous_famille', ['only' => ['index']]);
        $this->middleware('permission:ajouter_sous_famille', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_sous_famille', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_sous_famille', ['only' => ['sous_famille_delete']]);

    }

    public function index()
    {

        $query = $this->sous_familleRepository->liste_sous_fammilles();

        if (request()->ajax()) {
            return datatables()->of($query->get())
            ->addColumn('action', 'pages.sous-familles._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        $familles = $this->sous_familleRepository->selectFamille();

        addJavascriptFile('shop/sous-familles/table.js');

        return view('pages.sous-familles.index', compact('familles'));


    }


    public function store(StoreSousFamilleRequest $request)
    {
        $resp = $this->sous_familleRepository->store($request);

        return response()->json($resp);

    }

    public function sous_famille_view(Request $request)
    {
        $id = $request->id;

        $resp = $this->sous_familleRepository->view($id);

        return response()->json($resp);
    }


    public function sous_famille_delete(Request $request)
    {
        $id = $request->id;

        $resp = $this->sous_familleRepository->delete($id);

        return response()->json($resp);
    }
}
