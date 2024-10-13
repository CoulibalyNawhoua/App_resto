<?php

namespace App\Http\Controllers;

use App\Repositories\ConversionRepository;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    private $conversionRepository;

    public function __construct(ConversionRepository $conversionRepository)
    {
        $this->conversionRepository = $conversionRepository;

    }

    public function conversionIndex()
    {
        $query = $this->conversionRepository->ListeConversions();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.conversions._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        $unites = $this->conversionRepository->selectUnit();

        addJavascriptFile('shop/conversions/table.js');
        return view('pages.conversions.index', compact('unites'));
    }


    public function conversionStore(Request $request)
    {
        $resp = $this->conversionRepository->StoreConversion($request);

        return response()->json($resp);
    }


    public function selectUnitArrived(Request $request) {

        $id = $request->unite_id;

        $resp = $this->conversionRepository->selectUnitArrived($id);

        return response()->json($resp);
    }

    public function conversionView(Request $request) {


        $id = $request->id;

        $resp = $this->conversionRepository->view($id);

        return response()->json($resp);
    }


    public function conversionDelete(Request $request)
    {

        $id = $request->id;

        $resp = $this->conversionRepository->conversionDelete($id);

        return response()->json($resp);
    }
}
