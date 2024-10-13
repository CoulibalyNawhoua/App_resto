<?php

namespace App\Repositories;


use App\Models\Produit;
use App\Models\Conversion;
use App\Models\Gaspillage;
use App\Models\GaspillageProduct;
use App\Models\StockProduit;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GaspillageRepository extends Repository
{
    public function __construct(Gaspillage $model)
    {
        $this->model = $model;
    }


    public function squanderingList()
    {
        $depot_id = Auth::user()->entite_id;

        $query = DB::table('gaspillages_products')
                ->leftJoin('gaspillages_motifs','gaspillages_motifs.id','=','gaspillages_products.motif_gaspillage_id')
                ->leftJoin('gaspillages','gaspillages.id','=','gaspillages_products.gaspillage_id')
                ->leftJoin('users', 'users.id','=','gaspillages_products.added_by')
                ->leftJoin('entites','entites.id', '=','gaspillages_products.entite_id')
                ->leftJoin('unites','unites.id', '=','gaspillages_products.product_unit_id')
                ->leftJoin('produits','produits.id', '=','gaspillages_products.produit_id')
                ->leftJoin('groups_units','groups_units.id', '=','gaspillages_products.gaspillage_unit_id')
                ->selectRaw('gaspillages_products.*, CONCAT(users.first_name," ",users.last_name) as auteur, entites.name AS depot_stockage, produits.nom_produit, unites.name AS product_unit, groups_units.name AS unite_gaspillage, gaspillages.reference, gaspillages_motifs.libelle AS motif_gaspillage');

        if (!empty($depot)){
            $query->where('gaspillages_products.entite_id', $depot_id);
        }

        return $query;


    }


    public function squanderingStore(Request $request)
    {

        $products = $request->input('products',[]);
        $unite = $request->input('unite',[]);
        $motif_gaspillage = $request->input('motif_gaspillage',[]);
        $quantite = $request->input('quantite',[]);
        $user = Auth::user();

        $gaspillage = Gaspillage::create([
            'entite_id'=> $user->entite_id,
            'added_by' => $user->id,
            'add_ip' => $this->getIp(),
            'reference' => $this->referenceGenerator('Gaspillage')
        ]);

        for ($count=0; $count < count($products) ; $count++) {

            $productStock = StockProduit::where('id', $products[$count])->first();

            $conversion =    Conversion::where('unite_depart_id','=', $productStock->unite_id)
                            ->where('unite_arrivee_id','=', $unite[$count])
                            ->first();

            $data['produit_id'] = $productStock->produit_id;
            $data['quantity'] = $quantite[$count];
            $data['motif_gaspillage_id'] = $motif_gaspillage[$count];
            $data['product_unit_id'] = $productStock->unite_id;
            $data['gaspillage_unit_id'] = $unite[$count];
            $data['before_quantity']  = $productStock->quantite;
            $data['after_quantity']  = $productStock->quantite - ($conversion->value * $quantite[$count]);
            $data['quantity_after_conversion'] = $conversion->value * $quantite[$count];
            $data['gaspillage_id'] = $gaspillage->id;
            $data['entite_id'] = $user->entite_id;
            $data['added_by'] = Auth::user()->id;
            $data['add_ip'] = $this->getIp();
            $data['product_stock_id'] = $productStock->id;

            GaspillageProduct::create($data);

            $productStock->update([
                'quantite' => $productStock->quantite - $conversion->value * $quantite[$count]
            ]);

            if ($productStock->quantite < 0) {

                $productStock->update([
                    'quantite' => 0
                ]);
            }
        }
    }


}
