<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ModifGaspillageRepository;

class ModifGaspillageController extends Controller
{
    private $modifGaspillageRepository;

    public function __construct(ModifGaspillageRepository $modifGaspillageRepository)
    {
        $this->modifGaspillageRepository=$modifGaspillageRepository;

        $this->middleware('permission:liste_motif_gaspillage', ['only' => ['motifGaspillageIndex']]);
        $this->middleware('permission:supprimer_motif_gaspillage', ['only' => ['motifGaspillageDelete']]);
    }


    public function motifGaspillageIndex()
    {

        $query = $this->modifGaspillageRepository->motifGaspillageList();

        if (request()->ajax()) {
            return datatables()->of($query)
                ->addColumn('action', 'pages.motifs-gaspillages._action-menu')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        addJavascriptFile('shop/gaspillages/motif-gaspillage.js');

        return view('pages.motifs-gaspillages.index');
    }


    public function motifGaspillageStore(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required',
        ]);

        $resp = $this->modifGaspillageRepository->motifGaspillageStore($request);

        return response()->json($resp);

    }



    public function motifGaspillageView(Request $request)
    {
        $id = $request->id;

        $resp = $this->modifGaspillageRepository->view($id);

        return response()->json($resp);
    }


    public function motifGaspillageDelete(Request $request)
    {

        $id = $request->id;

        $resp = $this->modifGaspillageRepository->delete($id);

        return response()->json($resp);
    }

    public function selectionnerMotifGaspillage(Request $request)
    {
        $resp = $this->modifGaspillageRepository->selectionnerMotifGaspillage();

        return response()->json($resp);
    }

    // public  function operationTypeAjustement()
    // {
    //     $resp = $this->modifGaspillageRepository->operationAjustementStockSelect();

    //     return response()->json($resp);
    // }

    // public function operationTypeEntryStock()
    // {
    //     $resp = $this->modifGaspillageRepository->operationTypeEntryStockSelect();

    //     return response()->json($resp);
    // }


    // public function operationTypeOutputStock()
    // {
    //     $resp = $this->modifGaspillageRepository->operationTypeOutputStockSelect();

    //     return response()->json($resp);
    // }


}
