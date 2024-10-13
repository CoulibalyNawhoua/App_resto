<?php

namespace App\Http\Controllers;

use App\Repositories\GaspillageRepository;
use App\Rules\QuantityStockAjustementValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GaspillageController extends Controller
{
    private $gaspillageRepository;

    public function __construct(GaspillageRepository $gaspillageRepository)
    {
        $this->gaspillageRepository=$gaspillageRepository;

        $this->middleware('permission:liste_gaspillage', ['only' => ['squanderingIndex']]);
        $this->middleware('permission:ajouter_gaspillage', ['only' => ['squanderingCreate','squanderingStore']]);
    }


    public function squanderingIndex()
    {
        $query = $this->gaspillageRepository->squanderingList();

        if (request()->ajax()) {
            return datatables()->of($query)
                ->addColumn('action', 'pages.gaspillages._action-menu')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        addJavascriptFile('shop/gaspillages/table.js');
        return view('pages.gaspillages.index');
    }


    public function squanderingCreate()
    {
        addJavascriptFile('shop/typeahead/bloodhound.js');
        addJavascriptFile('shop/typeahead/typeahead.bundle.js');
        addJavascriptFile('shop/typeahead/typeahead.jquery.js');
        addJavascriptFile('shop/gaspillages/add.js');
        addCssFile('shop/typeahead/main.css');

        return view('pages.gaspillages.create');
    }


    public function squanderingStore(Request $request)
    {
        if($request->ajax())
        {
            $messages = [
                'product_count.gt' => 'Impossible de procéder aucun produit n\'a été cochet.',
                'motif_gaspillage.*.required' => 'Le champ motif gaspillage à la ligne :position est obligatoire.',
                'unite.*.required' => 'Le champ unité à la ligne :position est obligatoire.',
                'quantite.*.required' => 'Le champ quantité à la ligne :position est obligatoire.',
                'quantite.*.numeric' => 'Le champ quantité à la ligne :position n\'est pas valide.',
                'quantite.*.gt' => 'Le champ quantité à la ligne :position n\'est pas valide.',
            ];
            $error = Validator::make(
                $request->all(),[
                    'product_count' => ['gt:0'],
                    'unite.*' =>['required'],
                    'motif_gaspillage.*' =>['required'],
                    'quantite.*' =>['required','numeric', 'gt:0', new QuantityStockAjustementValidation()],
                ]
                , $messages
            );

            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $resp = $this->gaspillageRepository->squanderingStore($request);

            return response()->json($resp);
        }


        return response()->json('ajax not found query');

    }



}
