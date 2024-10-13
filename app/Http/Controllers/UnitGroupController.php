<?php

namespace App\Http\Controllers;

use App\Repositories\UnitGroupRepository;
use Illuminate\Http\Request;

class UnitGroupController extends Controller
{
    private $unitGroupRepository;

    public function __construct(UnitGroupRepository $unitGroupRepository)
    {
        $this->unitGroupRepository = $unitGroupRepository;

    }

    public function groupUnitIndex()
    {
        $query = $this->unitGroupRepository->unitGroupList();

        if (request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.unit-group._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        addJavascriptFile('shop/unit-group/table.js');

        return view('pages.unit-group.index');
    }


    public function unitGroupStore(Request $request)
    {
        $resp = $this->unitGroupRepository->store($request);

        return response()->json($resp);
    }


    public function unitGroupView(Request $request) {


        $id = $request->id;

        $resp = $this->unitGroupRepository->view($id);

        return response()->json($resp);
    }


    public function unitGroupDelete(Request $request)
    {

        $id = $request->id;

        $resp = $this->unitGroupRepository->delete($id);

        return response()->json($resp);
    }

    public function unitGroupselect(Request $request)
    {
        $resp = $this->unitGroupRepository->selectUnitGroup();

        return response()->json($resp);
    }
}
