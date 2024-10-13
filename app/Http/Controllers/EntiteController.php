<?php

namespace App\Http\Controllers;

use App\Repositories\EntiteRepository;
use Illuminate\Http\Request;

class EntiteController extends Controller
{
    private $entiteRepository;

    public function __construct(EntiteRepository $entiteRepository)
    {
        $this->entiteRepository = $entiteRepository;

        $this->middleware('permission:liste_depot_stockage', ['only' => ['index']]);
        $this->middleware('permission:ajouter_depot_stockage', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_depot_stockage', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_depot_stockage', ['only' => ['entite_delete']]);


    }

    public function index()
    {

        $query = $this->entiteRepository->ListeEntites();


        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.entites._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        $departements =  $this->entiteRepository->selectDepartement();

        addJavascriptFile('shop/entites/table.js');
        return view('pages.entites.index', compact('departements'));
    }


    public function store(Request $request)
    {
        $resp = $this->entiteRepository->store_data($request);

        return response()->json($resp);

    }


    public function entite_view(Request $request)
    {
        $id = $request->id;

        $resp = $this->entiteRepository->view($id);

        return response()->json($resp);
    }


    public function entite_delete(Request $request)
    {
        $id = $request->id;

        $resp = $this->entiteRepository->delete($id);

        return response()->json($resp);
    }


    public function create()
    {
        addJavascriptFile('shop/entites/add.js');

        $departements =  $this->entiteRepository->selectDepartement();

        return view('pages.entites._create', compact('departements'));
    }



    public function edit(string $id)
    {
        $entite = $this->entiteRepository->edit($id);

        $departements =  $this->entiteRepository->selectDepartement();

        addJavascriptFile('shop/entites/update.js');

        return view('pages.entites._edit', compact('entite', 'departements'));
    }

    public function update(Request $request, string $id)
    {
        $resp = $this->entiteRepository->update_data($request, $id);

        return response()->json($resp);
    }


}
