<?php

namespace App\Http\Controllers;

use App\Repositories\DepartementRepository;
use Illuminate\Http\Request;

class DepartementController extends Controller
{

    private $departementRepository;

    public function __construct(DepartementRepository $departementRepository)
    {
        $this->departementRepository = $departementRepository;

        $this->middleware('permission:liste_departement', ['only' => ['index']]);
        $this->middleware('permission:ajouter_departement', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_departement', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_fournisseur', ['only' => ['supprimer_departement']]);

    }

    public function index()
    {
        $query = $this->departementRepository->ListeDepartements();


        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.departements._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/departements/table.js');

        return view('pages.departements.index');
    }

    public function store(Request $request)
    {
        $resp = $this->departementRepository->store($request);

        return response()->json($resp);

    }


    public function departement_view(Request $request)
    {
        $id = $request->id;

        $resp = $this->departementRepository->view($id);

        return response()->json($resp);
    }


    public function departement_delete(Request $request)
    {
        $id = $request->id;

        $resp = $this->departementRepository->delete($id);

        return response()->json($resp);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
