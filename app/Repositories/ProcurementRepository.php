<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Procurement;
use App\Models\ProcurementProduct;
use App\Models\ProductUnit;
use App\Models\Reception;
use App\Models\ReceptionProcuct;
use App\Models\StockProduit;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class ProcurementRepository extends Repository
{
    public function __construct(Procurement $model)
    {
        $this->model = $model;
    }

    public function purchaseStore(Request $request)
    {
        $products = $request->products;
        $fournisseur_id = $request->fournisseur;
        $quantite = $request->quantite ;
        $cout_product = $request->cout_product;
        $total_a_payer = $request->total_a_payer;
        $sousTotal = $request->sousTotal;
        $procurment_status = $request->procurment_status;
        $date_commande = $request->date_commande;
        $date_prevue_reception = $request->date_prevue_reception;
        $commentaire = $request->commentaire;
        $product_unit = $request->product_unit;
        $product_count = $request->product_count;
        $depot_stockage = $request->depot_stockage;



        $procurement = Procurement::create([
            'reference'=>  $this->referenceGenerator('Procurement'),
            'cost'=>  $total_a_payer,
            'fournisseur_id'=>  $fournisseur_id,
            'add_ip' => $this->getIp(),
            'added_by' => Auth::user()->id,
            'add_date' => Carbon::now(),
            /*'procurment_status' => $procurment_status,*/
            'entite_id'=>$depot_stockage,
            'commentaire' => $commentaire,
            'date_commande' => $date_commande,
            'date_prevue_reception' => $date_prevue_reception,
            'procurment_status'=>0,
            'total_produit' =>$product_count
        ]);

        for ($count=0; $count < count($products) ; $count++) {

            $procuctUnit = ProductUnit::where([
                ['produit_id','=',$products[$count]],
                ['id','=',$product_unit[$count]],
            ])->first();

            ProcurementProduct::create(
                [
                    'produit_id' => $products[$count],
                    'quantity'=>$quantite[$count],
                    'total_purchase_price' => $sousTotal[$count],
                    'purchase_price'=> $cout_product[$count],
                    'procurement_id' => $procurement->id,
                    'product_unit_id' =>  $product_unit[$count],
                    'unit_quantity' => $procuctUnit->pcb,
                    'added_by' => Auth::user()->id,
                    'add_date' => Carbon::now(),
                    'add_ip' => $this->getIp(),
                ]
            );
        }

    }


    public function purchaseUpdate(Request $request, $id)
    {
        $products = $request->products;
        $fournisseur_id = $request->fournisseur;
        $quantite = $request->quantite ;
        $cout_product = $request->cout_product;
        $total_a_payer = $request->total_a_payer;
        $sousTotal = $request->sousTotal;
       /* $procurment_status = $request->procurment_status;*/
        $date_commande = $request->date_commande;
        $date_prevue_reception = $request->date_prevue_reception;
        $commentaire = $request->commentaire;
        $delete_products = $request->input('delete_products', []);
        $product_unit = $request->product_unit;
        $product_count = $request->product_count;
        $depot_stockage = $request->depot_stockage;


        $procurement = $this->model->find($id);

        $procurement->update([
            'cost'=>  $total_a_payer,
            'fournisseur_id'=>  $fournisseur_id,
            'edit_ip' => $this->getIp(),
            'edited_by' => Auth::user()->id,
            'edit_date' => Carbon::now(),
           /* 'procurment_status' => $procurment_status,*/
            'commentaire' => $commentaire,
            'date_commande' => $date_commande,
            'date_prevue_reception' => $date_prevue_reception,
            'total_produit' =>$product_count,
            'entite_id'=>$depot_stockage,
        ]);

        for ($count=0; $count < count($products) ; $count++) {

            $product = ProcurementProduct::where([
                ['produit_id', '=', $products[$count]],
                ['is_deleted', '=', 0],
                ['procurement_id', '=', $procurement->id]
            ])->first();

            $procuctUnit = ProductUnit::where([
                ['produit_id','=',$products[$count]],
                ['id','=',$product_unit[$count]],
            ])->first();

            if (is_null($product)) {
                ProcurementProduct::create(
                    [
                        'produit_id' => $products[$count],
                        'quantity'=>$quantite[$count],
                        'total_purchase_price' => $sousTotal[$count],
                        'purchase_price'=> $cout_product[$count],
                        'procurement_id' => $procurement->id,
                        'product_unit_id' =>  $product_unit[$count],
                        'unit_quantity' => $procuctUnit->pcb,
                        'added_by' => Auth::user()->id,
                        'add_date' => Carbon::now(),
                        'add_ip' => $this->getIp(),
                    ]
                );
            } else {
               $product->update(
                    [
                        'produit_id' => $products[$count],
                        'quantity'=>$quantite[$count],
                        'total_purchase_price' => $sousTotal[$count],
                        'purchase_price'=> $cout_product[$count],
                        'product_unit_id' =>  $product_unit[$count],
                        'unit_quantity' => $procuctUnit->pcb,
                        'edited_by' => Auth::user()->id,
                        'edit_date' => Carbon::now(),
                        'edit_ip' => $this->getIp(),
                    ]
                );
            }
        }
    }


    public function purchasesList()
    {

        return Procurement::selectRaw('procurements.*, CONCAT(users.first_name," ",users.last_name) as auteur, CONCAT(fournisseurs.nom," ",fournisseurs.prenom) as fournisseur')
                ->leftJoin('users','users.id','procurements.added_by')
                ->leftJoin('fournisseurs','fournisseurs.id','procurements.fournisseur_id')
                ->where('procurements.is_deleted','=',0);

    }




    public function procurement_view($reference)
    {
        $procurement = Procurement::where('reference',$reference)->firstOrFail();

        $procurement_products = ProcurementProduct::where([['is_deleted','=',0], ['procurement_id','=',$procurement->id]])->get();

        foreach ($procurement_products as $item)
        {
            $item->product_units=ProductUnit::where([['produit_id','=',$item->produit_id],['is_deleted','=',0],])->get();
        }

        return $data = [
            'procurement'=>$procurement,
            'procurement_products'=>$procurement_products,
        ];
    }

    public function procurement_view_by_id($id)
    {
        $procurement = Procurement::where('id',$id)->firstOrFail();

        $procurement_products = ProcurementProduct::where([['is_deleted','=',0], ['procurement_id','=',$procurement->id]])->get();

        foreach ($procurement_products as $item)
        {
            $item->product_units=ProductUnit::where([['produit_id','=',$item->produit_id],['is_deleted','=',0],])->get();
        }

        return $data = [
            'procurement'=>$procurement,
            'procurement_products'=>$procurement_products,
        ];
    }



    public function deleteProcurementItem($id)
    {
        $record =  ProcurementProduct::where('id',$id)->delete();

        return $record;
    }

    public function acceptedProcurementProcess(mixed $id)
    {
        $data = $this->model->find($id);

        $data->update([
            'confirm_date'=>Carbon::now(),
            'confirm_by'=>Auth::user()->id,
            'confirm_note'=>'',
            'procurment_status'=>1
        ]);
    }

    public function rejectedProcurementProcess($id)
    {

        $data = $this->model->find($id);

        $data->update([
            'confirm_date'=>Carbon::now(),
            'confirm_by'=>Auth::user()->id,
            /*'confirm_note'=> $request->note,*/
            'procurment_status'=>3
        ]);
    }

    public function closedProcurementProcess(mixed $id)
    {
        $data = $this->model->find($id);

        $data->update([
            'closed_by'=> Auth::user()->id,
            'closed_date'=> Carbon::now(),
            'procurment_status'=>2
        ]);
    }

}
