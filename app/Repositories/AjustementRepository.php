<?php

namespace App\Repositories;

use App\Models\Produit;
use App\Models\Ajustement;
use App\Models\Conversion;
use App\Models\StockProduit;
use Illuminate\Http\Request;
use App\Models\TypeAjustement;
use App\Models\AjustementProduit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AjustementRepository extends Repository
{
   public function __construct(AjustementProduit $model)
   {
        $this->model = $model;
   }


  public function storeAjustement(Request $request)
  {

        $products = $request->input('products',[]);
        $unite = $request->input('unite',[]);
        $type_ajustement = $request->input('type_ajustement',[]);
        $quantite = $request->input('quantite',[]);
        $user = Auth::user();

        $ajustement = Ajustement::create([
            'entite_id'=> $user->entite_id,
            'added_by' => $user->id,
            'add_ip' => $this->getIp(),
            'reference' => $this->referenceGenerator('Ajustement')
        ]);


        for ($count=0; $count < count($products) ; $count++) {

            // $product_stk = StockProduit::where([
            //     ['entite_id','=',$depot_id],
            //     ['produit_id','=',$products[$count]],
            //     ['unite_id','=', $unite[$count]]
            // ])->first();

            $productStock = StockProduit::where('id', $products[$count])->first();

            $typeAjustement = TypeAjustement::where('id', $type_ajustement[$count])->first();


            $conversion = Conversion::where('unite_depart_id','=', $productStock->unite_id)
                                    ->where('unite_arrivee_id','=', $unite[$count])
                                    ->first();


            if ($typeAjustement->code === 'add') {
                $quantity_after_conversion = $conversion->value * $quantite[$count];
                $quantity = $quantite[$count];

            }elseif($typeAjustement->code === 'sub'){
                $quantity_after_conversion = -($conversion->value * $quantite[$count]);
                $quantity = -$quantite[$count];
            }

           $data['produit_id'] = $productStock->produit_id;
           $data['quantity'] = $quantity;
           $data['type_ajustement_id'] = $type_ajustement[$count];
           $data['product_unit_id'] = $productStock->unite_id;
           $data['ajustement_unit_id'] = $unite[$count];
           $data['before_quantity']  = $productStock->quantite;
           $data['after_quantity']  = $productStock->quantite +($quantity_after_conversion);
           $data['quantity_after_conversion'] = $quantity_after_conversion;
           $data['ajustement_id'] = $ajustement->id;
           $data['entite_id'] = $user->entite_id;
           $data['added_by'] = Auth::user()->id;
           $data['types'] = $typeAjustement->code;
           $data['add_ip'] = $this->getIp();
           $data['product_stock_id'] = $productStock->id;

            AjustementProduit::create($data);


            if ($typeAjustement->code === 'add') {
                $productStock->update([
                    'quantite' =>  $productStock->quantite + $quantity_after_conversion
                ]);

            }elseif($typeAjustement->code === 'sub'){
                $productStock->update([
                    'quantite' =>  $productStock->quantite + $quantity_after_conversion
                ]);

                if ($productStock->quantite < 0) {

                    $productStock->update([
                        'quantite' => 0
                    ]);
                }
            }

        }
  }



  public  function adjustmentProductList()
  {

    $query = AjustementProduit::where('ajustements_products.is_deleted',0)
            ->leftJoin('users','users.id','=','ajustements_products.added_by')
            ->leftJoin('ajustements','ajustements.id','=','ajustements_products.ajustement_id')
            ->leftJoin('entites','entites.id','=','ajustements_products.entite_id')
            ->leftJoin('produits','produits.id','=','ajustements_products.produit_id')
            ->leftJoin('groups_units','groups_units.id', '=','ajustements_products.ajustement_unit_id')
            ->leftJoin('unites','unites.id', '=','ajustements_products.product_unit_id')
            ->leftJoin('types_ajustements','types_ajustements.id', '=','ajustements_products.type_ajustement_id')

            ->selectRaw('ajustements_products.*, CONCAT(users.first_name," ",users.last_name) as auteur, entites.name AS depot_stockage, produits.nom_produit, unites.name AS product_unit, types_ajustements.libelle AS operation, groups_units.name AS unite_ajustement, ajustements.reference');

            if(Auth::user()->entite_id){
                $query->where('ajustements_products.entite_id', Auth::user()->entite_id);
            }

    return $query;
  }




  public function typeAjustementSelect()
  {
    return DB::table('types_ajustements')->where('id','<>',3)->selectRaw('id, libelle')->get();
  }

    public function ajustementDelete()
    {
    }


    public function stockInitializationStore(Request $request)
    {
        $products = $request->input('products',[]);
        $unite = $request->input('unite',[]);
        $quantite = $request->input('quantite',[]);
        $user = Auth::user();

        $ajustement = Ajustement::create([
            'entite_id'=> $user->entite_id,
            'added_by' => $user->id,
            'add_ip' => $this->getIp(),
            'reference' => $this->referenceGenerator('Ajustement')
        ]);

        for ($count=0; $count < count($products) ; $count++) {

            $product = Produit::where('id',$products[$count])->first();

            $conversion = Conversion::where('unite_depart_id','=', $product->unites_id)
                                    ->where('unite_arrivee_id','=', $unite[$count])
                                    ->first();

            $data['produit_id'] = $product->id;
            $data['quantity'] = $quantite[$count];
            $data['type_ajustement_id'] = 3;
            $data['product_unit_id'] = $product->unites_id;
            $data['ajustement_unit_id'] = $unite[$count];
            $data['before_quantity']  = 0;
            $data['after_quantity']  = $conversion->value * $quantite[$count];
            $data['quantity_after_conversion'] = $conversion->value * $quantite[$count];
            $data['ajustement_id'] = $ajustement->id;
            $data['entite_id'] = $user->entite_id;
            $data['added_by'] = $user->id;
            $data['types'] = 'init';
            $data['add_ip'] = $this->getIp();
 
            AjustementProduit::create($data);

            StockProduit::create([
                'produit_id' =>  $product->id,
                'entite_id' => $user->entite_id,
                'quantite' => $conversion->value * $quantite[$count],
                'unite_id' => $product->unites_id
            ]);
        }
    }
}
