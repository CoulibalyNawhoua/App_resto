<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Bilan;
use App\Models\Produit;
use App\Models\Conversion;
use App\Models\BilanProduct;
use App\Models\BilanRecette;
use App\Models\StockProduit;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class BilanRepository extends Repository
{
    public function __construct(Bilan $model)
   {
        $this->model = $model;
   }

   public function BilanProduitRecetteStore(Request $request)
   {
        $recettes = $request->input('recettes',[]);

        $quantity = $request->input('quantity',[]);

        $bilan = Bilan::create([
            'reference'=>  $this->generateUniqueCode(),
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp(),
            'add_date' => Carbon::now(),
            'entite_id' => Auth::user()->entite_id,
        ]);

        for ($count=0; $count < count($recettes) ; $count++) {

            BilanRecette::create([
                'recette_id' =>  $recettes[$count],
                'quantity' => $quantity[$count],
                'bilan_id' => $bilan->id,
            ]);
        }
   }

   public function generateUniqueCode()
   {
       do {
           $code = random_int(100000, 999999);
       } while (Bilan::where("reference", "=", $code)->first());

       return $code;
   }


   public function ListeBilanRecetteProduits()
   {
     return $this->model->where('is_deleted',0)->with('auteur');
   }


   public function BilanProduitRecetteView($reference)
   {

    $bilan = $this->model->where('reference', $reference)->firstOrFail();

    $bilan_recettes = BilanRecette::where('bilan_id', $bilan->id)->get();

    $data =[
        'bilan'=>$bilan,
        'bilan_recettes'=>$bilan_recettes
    ];

     return $data;

   }

   public function storeBilanProductValidate(Request $request)
   {

        $products = $request->input('products',[]);
        $unites = $request->input('unites',[]);
        $quantite = $request->input('quantite',[]);
        $quantiteTotal = $request->input('quantiteTotal',[]);
        $bilan_id = $request->input('bilan_id',[]);

        $bilan = Bilan::where('id',$bilan_id)->first();

        $array = [];

        for ($i=0; $i < count($products) ; $i++) {

            $product = Produit::where('id', $products[$i])->first();

            $conversion = Conversion::where('unite_depart_id',$product->unites_id)
                            ->where('unite_arrivee_id', $unites[$i])
                            ->get();

            $productStck = StockProduit::where('produit_id',$product->id)
                            ->where('unite_id',$product->unites_id)
                            ->where('entite_id', $bilan->entite_id)
                            ->first();

            if (!empty($productStck)) {

                BilanProduct::create([
                    'bilan_id'=> $bilan->id,
                    'operation_type'=> 'bilan',
                    'produit_id' => $productStck->produit_id,
                    'quantity'=> $quantiteTotal * $conversion->value,
                    'before_quantity'=> $productStck->quantite,
                    'after_quantity'=> $productStck->quantite - ($quantiteTotal * $conversion->value),
                    'entite_id'=> $bilan->entite_id,
                    'product_unit_id'=> $product->unites_id,
                    'added_by' => Auth::user()->id,
                    'add_ip' => $this->getIp(),
                    'add_date' => Carbon::now(),
                    'unite_id'=> $unites[$i]
                ]);

                $productStck->decrement('quantite', ($quantiteTotal * $conversion->value));

                if ($productStck->quantite < 0){
                    $productStck->update([
                        'quantite'=>0
                    ]);
                }
            }
        }

        $bilan->update([
            'status'=>1
        ]);
   }
}
