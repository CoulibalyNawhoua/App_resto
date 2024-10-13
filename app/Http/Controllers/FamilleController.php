<?php

namespace App\Http\Controllers;

use App\Exports\ExportFamille;
use App\Http\Requests\StoreFamilleRequest;
use App\Repositories\FamilleRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FamilleController extends Controller
{

    private $familleRepository;

    public function __construct(FamilleRepository $familleRepository)
    {
        $this->familleRepository = $familleRepository;

        $this->middleware('permission:liste_famille', ['only' => ['index']]);
        $this->middleware('permission:ajouter_famille', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_famille', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_famille', ['only' => ['famille_delete']]);

    }

    public function index()
    {
        $query = $this->familleRepository->ListeFamilles();

        if (request()->ajax()) {
            return datatables()->of($query->get())
            ->addColumn('action', 'pages.familles._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        addJavascriptFile('shop/familles/table.js');
        return view('pages.familles.index');
    }


    public function store(StoreFamilleRequest $request)
    {
        $resp = $this->familleRepository->store($request);

        return response()->json($resp);

    }


    public function famille_view(Request $request)
    {
        $id = $request->id;

        $resp = $this->familleRepository->view($id);

        return response()->json($resp);
    }


    public function famille_delete(Request $request)
    {
        $id = $request->id;

        $resp = $this->familleRepository->delete($id);

        return response()->json($resp);
    }

    public function exportFamilleExcel()
    {
        return Excel::download(new ExportFamille(), 'familles.xlsx');
    }
}
