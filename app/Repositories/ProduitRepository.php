<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Produit;
use App\Models\ProductUnit;
use Illuminate\Support\Str;
use App\Models\StockProduit;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProduitRequest;

class ProduitRepository extends Repository
{
    public function __construct(Produit $model=null)
    {
        $this->model = $model;
    }


    public function ListeProduits()
    {
        return DB::table('produits')
                ->leftJoin('users','users.id','=','produits.added_by')
                ->leftJoin('unites','unites.id','=','produits.unites_id')
                ->leftJoin('sous_familles','sous_familles.id','=','produits.sous_familles_id')
                ->leftJoin('categories','categories.id','=','produits.categories_id')
                ->leftJoin('familles','familles.id','=','sous_familles.familles_id')
                ->selectRaw('produits.*, unites.name AS unite, CONCAT(users.first_name," ",users.first_name) as created_by, familles.name AS famille, sous_familles.name AS sous_famille, categories.nom_categorie')
                ->get();
    }



    public function storeProduct(Request $request)
    {
        $nom_produit = $request->input('nom_produit');
        $sous_famille_id = $request->input('sous_famille_id');
        $categories_id = $request->input('categorie_id');
        $unites_id = $request->input('unite_id');
        $reference_produit = $request->input('reference_produit');
        $price = $request->input('price',[]);
        $produit_a_une_unite = $request->produit_a_une_unite;
        $unites = $request->input('unites',[]);
        $pcb = $request->input('pcb',[]);
        $price = $request->input('price',[]);
        $pcb_product = $request->input('pcb_product');


        $product =Produit::create([
            'nom_produit'=>Str::upper($nom_produit),
            'categories_id'=>$categories_id,
            'unites_id'=>$unites_id,
            'sous_familles_id'=>$sous_famille_id,
            'reference_produit'=>$reference_produit,
            'pcb_product'=>$pcb_product,
            'add_ip' => $this->getIp(),
            'added_by' => Auth::user()->id,
        ]);



        if($produit_a_une_unite==0){
            // ce circuits n'a pas d'horaires

        }else{
            for ($i=0;$i<count($unites);$i++){
                ProductUnit::create([
                    'produit_id' => $product->id,
                    'unite_id' => $unites[$i],
                    'pcb'=> $pcb[$i],
                    'price'=>$price[$i],
                    'add_ip' => $this->getIp(),
                    'added_by' => Auth::user()->id,
                ]);
            }
        }
    }


    public function updateProduct(Request $request, $id)
    {

        $product = Produit::find($id);

        $nom_produit = $request->input('nom_produit');
        $sous_famille_id = $request->input('sous_famille_id');
        $categories_id = $request->input('categorie_id');
        $unites_id = $request->input('unite_id');
        $reference_produit = $request->input('reference_produit');
        $produit_a_une_unite = $request->produit_a_une_unite;
        $unites = $request->input('unites',[]);
        $price = $request->input('price',[]);
        $pcb = $request->input('pcb',[]);
        $product_unit_id = $request->input('product_unit_id');
        $pcb_product = $request->input('pcb_product');


        $product->update([
            'nom_produit'=>Str::upper($nom_produit),
            'categories_id'=>$categories_id,
            'unites_id'=>$unites_id,
            'sous_familles_id'=>$sous_famille_id,
            'reference_produit'=>$reference_produit,
            'pcb_product'=>$pcb_product,
            'edit_ip' => $this->getIp(),
            'edited_by' => Auth::user()->id,
            'edit_date' => Carbon::now()
        ]);

        if($produit_a_une_unite==0){


        }else{

            for ($i=0;$i<count($unites);$i++){

                $productUnit = ProductUnit::where([
                    ['id', '=', $product_unit_id[$i]],
                ])->first();

                if (is_null($productUnit)) {

                    ProductUnit::create([
                        'produit_id' => $product->id,
                        'unite_id' => $unites[$i],
                        'pcb'=> $pcb[$i],
                        'price'=>$price[$i],
                        'add_ip' => $this->getIp(),
                        'added_by' => Auth::user()->id,
                    ]);

                } else {


                    $productUnit->update([
                        'pcb'=> $pcb[$i],
                        'unite_id' => $unites[$i],
                        'price'=>$price[$i],
                        'edit_ip' => $this->getIp(),
                        'edited_by' => Auth::user()->id,
                        'edit_date' => Carbon::now()
                    ]);
                }

                // $productAsUnit = ProductUnit::where([
                //     ['unite_id', '=', $unites[$i]],
                //     ['produit_id', '=', $product->id],
                //     ['is_deleted', '=', 0],
                // ])->first();

                // $productUnit = ProductUnit::where('id', $product_unit_id[$i])->first();


                // if (is_null($productAsUnit)) {

                //     ProductUnit::create([
                //         'produit_id' => $product->id,
                //         'unite_id' => $unites[$i],
                //         'pcb'=> $pcb[$i],
                //         'add_ip' => $this->getIp(),
                //         'added_by' => Auth::user()->id,
                //     ]);
                // } else {

                //     if ( $productUnit) {
                //         $productUnit->update([
                //             'pcb'=> $pcb[$i],
                //             'unite_id' => $unites[$i],
                //             'edit_ip' => $this->getIp(),
                //             'edited_by' => Auth::user()->id,
                //             'edit_date' => Carbon::now()
                //         ]);
                //     }

                // }
            }
        }
    }

    public function getProduct($id)
    {
        $data = Produit::where('id',$id)->firstOrFail();

        $data->productUnits = ProductUnit::where([['produit_id','=',$data->id],['is_deleted','=',0]])->get();

        return $data;
    }


    public function deleteUnitProduct($id)
    {
        $record = ProductUnit::find($id);

        $record->is_deleted = 1;
        $record->deleted_by = Auth::user()->id;
        $record->delete_ip = $this->getIp();
        $record->delete_date = Carbon::now();
        $record->save();
    }


    public function searchProductStockDepotStockage(Request $request)
    {
        $depot_id = Auth::user()->entite_id;

        $response = StockProduit::selectRaw('produits.id, produits.nom_produit')
            ->leftJoin('produits','produits.id','=','stock_products.produit_id')
            ->leftJoin('entites','entites.id','=','stock_products.entite_id')
            ->where('stock_products.entite_id', $depot_id);

        $response->where('produits.nom_produit', 'LIKE', "%{$request->input('q')}%");

        $data = $response->get();

        return response()->json($data);

    }


    public function productStokView()
    {
        $depot_id = Auth::user()->entite_id;

        $query = StockProduit::selectRaw('produits.id, produits.nom_produit, sous_familles.name AS sous_famille, familles.name AS famille, entites.name AS depot_stockage, unites.name AS product_unit, categories.nom_categorie, stock_products.quantite, stock_products.updated_at')
            ->leftJoin('produits','produits.id','=','stock_products.produit_id')
            // ->leftJoin('produits_unites','produits_unites.produit_id','=','produits.id')
            ->leftJoin('entites','entites.id','=','stock_products.entite_id')
            ->leftJoin('unites','unites.id','=','produits.unites_id')
            ->leftJoin('sous_familles','sous_familles.id','=','produits.sous_familles_id')
            ->leftJoin('categories','categories.id','=','produits.categories_id')
            ->leftJoin('familles','familles.id','=','sous_familles.familles_id')
            ->where('produits.is_deleted', 0);

     /*   $query = ProductUnit::selectRaw('produits.id, produits.nom_produit, sous_familles.name AS sous_famille, familles.name AS famille, entites.name AS depot_stockage, unites.name AS product_unit, categories.nom_categorie, stock_products.quantite, stock_products.updated_at')
            ->leftJoin('produits','produits.id','=','produits_unites.produit_id')
            ->leftJoin('stock_products','stock_products.produit_id','=','produits_unites.produit_id')
            ->leftJoin('entites','entites.id','=','stock_products.entite_id')
            ->leftJoin('unites','unites.id','=','produits_unites.unite_id')
            ->leftJoin('sous_familles','sous_familles.id','=','produits.sous_familles_id')
            ->leftJoin('categories','categories.id','=','produits.categories_id')
            ->leftJoin('familles','familles.id','=','sous_familles.familles_id')
            ->where('produits_unites.is_deleted', 0)
            ;*/

        if (!empty($depot_id)){
            $query->where('stock_products.entite_id', $depot_id);
        }

        return $query;

    }




}
