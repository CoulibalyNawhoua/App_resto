<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUniteRequest;
use App\Repositories\UniteRepository;
use Illuminate\Http\Request;

class UniteController extends Controller
{
    private $uniteRepository;

    public function __construct(UniteRepository $uniteRepository)
    {
        $this->uniteRepository = $uniteRepository;

        $this->middleware('permission:liste_unite', ['only' => ['index']]);
        $this->middleware('permission:ajouter_unite', ['only' => ['create','store']]);
        $this->middleware('permission:modifier_unite', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer_unite', ['only' => ['unite_delete']]);


    }

    public function index()
    {


        $query = $this->uniteRepository->ListeUnites();

        if (request()->ajax()) {
            return datatables()->of($query->get())
            ->addColumn('action', 'pages.unites._action-menu')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }


        $unitGroups = $this->uniteRepository->selectUnitGroup();


        addJavascriptFile('shop/unites/table.js');

        return view('pages.unites.index', compact('unitGroups'));
    }


    public function create()
    {
        $unitGroups = $this->uniteRepository->selectUnitGroup();

        return view('pages.unites._create', compact('unitGroups'));

    }

    public function store(StoreUniteRequest $request)
    {
        $resp = $this->uniteRepository->store($request);

        return redirect()->route('unites.index');

        // return response()->json($resp);

    }


    public function edit($id)
    {
        $unite = $this->uniteRepository->view($id);

        $unitGroups = $this->uniteRepository->selectUnitGroup();

        return view('pages.unites._edit', compact('unite', 'unitGroups'));
    }


    public function update(StoreUniteRequest $request, $id)
    {
        $resp = $this->uniteRepository->updateUnit($request, $id);

        return redirect()->route('unites.index');
    }

    public function unite_view(Request $request)
    {
        $id = $request->id;

        $resp = $this->uniteRepository->view($id);

        return response()->json($resp);
    }


    public function unite_delete(Request $request)
    {
        $id = $request->id;

        $resp = $this->uniteRepository->delete($id);

        return response()->json($resp);
    }

    public function unit_select()
    {
        $resp = $this->uniteRepository->selectUnit();

        return response()->json($resp);
    }


    public function unit_group_select_product(Request $request)
    {
        $productId = $request->productId;

        $resp = $this->uniteRepository->selectProductSubUnit($productId);

        return response()->json($resp);

    }


    public function selectUnitGroupUnit(Request $request)
    {
        $id = $request->id;

        $resp = $this->uniteRepository->selectUnitGroupUnit($id);

        return response()->json($resp);

    }
}
