<?php

namespace App\Http\Controllers;

use App\Exports\ExportFourniseur;
use App\Http\Requests\StoreFournisseurRequest;
use App\Repositories\FournisseurRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FournisseurController extends Controller
{
    private $fournisseursRepository;

    public function __construct(FournisseurRepository $fournisseursRepository)
    {
        $this->fournisseursRepository = $fournisseursRepository;

        $this->middleware('permission:liste_fournisseur', ['only' => ['index']]);
        $this->middleware('permission:ajouter_fournisseur', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_fournisseur', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_fournisseur', ['only' => ['fournisseur_delete']]);

    }

    public function index()
    {

        $query = $this->fournisseursRepository->liste_fornisseurs();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.fournisseurs._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/fournisseurs/table.js');

        return view('pages.fournisseurs.index');
    }



    public function store(StoreFournisseurRequest $request)
    {
        $fournisseur = $this->fournisseursRepository->store($request);

        return response()->json($fournisseur);
    }



    public function fournisseur_view(Request $request)
    {

        $id = $request->id;
        $fournisseur = $this->fournisseursRepository->view($id);
        return response()->json($fournisseur, 200);

    }

    public function fournisseur_delete(Request $request)
    {
        $elt = $request->id;

        $fournisseur = $this->fournisseursRepository->delete($elt);

        return response()->json($fournisseur);
    }

    public function exportFournisseurExcel()
    {
        return Excel::download(new ExportFourniseur(), 'fournisseur.xlsx');
    }

}
