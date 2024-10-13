<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Entite;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class EntiteRepository extends Repository
{
    public function __construct(Entite $model)
    {
        $this->model = $model;
    }

    public function ListeEntites()
    {
        return Entite::where('entites.is_deleted',0)
            ->leftJoin('users','users.id','=','entites.added_by')
            ->leftJoin('departements','departements.id','=','entites.departement_id')
            ->selectRaw('entites.*, CONCAT(users.first_name," ",users.first_name) as created_by, departements.nom_departement');
    }

    public function store_data(Request $request)
    {

        if ($request->has('use_depot_principal')){
            $use_depot_principal =1;
        }else{
            $use_depot_principal=0;
        }

        if($request->has('use_depot_principal')){
            $ancienne_depot_principal = Entite::where('use_depot_principal', 1)->first();

            if ($ancienne_depot_principal) {
                $ancienne_depot_principal->update([
                    'use_depot_principal'=> 0,
                    'edit_ip' => $this->getIp(),
                    'edited_by' => Auth::user()->id,
                    'edit_date' => Carbon::now(),
                ]);

                Entite::create([
                    'name' => $request->nom_entite,
                    'telephone_depot'=>$request->telephone_depot,
                    'ville_depot'=>$request->ville_depot,
                    'adresse_depot'=>$request->adresse_depot,
                    'code_depot'=>$request->code_depot,
                    'use_depot_principal'=> $use_depot_principal,
                    'departement_id'=> $request->departement_id,
                    'added_by' => Auth::user()->id,
                    'add_ip' => $this->getIp()
                ]);
            }
            else {
                Entite::create([
                    'name' => $request->nom_entite,
                    'use_depot_principal'=> $use_depot_principal,
                    'telephone_depot'=>$request->telephone_depot,
                    'ville_depot'=>$request->ville_depot,
                    'adresse_depot'=>$request->adresse_depot,
                    'code_depot'=>$request->code_depot,
                    'departement_id'=> $request->departement_id,
                    'added_by' => Auth::user()->id,
                    'add_ip' => $this->getIp()
                ]);
            }
        }

        else {
            Entite::create([
                'name' => $request->nom_entite,
                'use_depot_principal'=> $use_depot_principal,
                'telephone_depot'=>$request->telephone_depot,
                'ville_depot'=>$request->ville_depot,
                'adresse_depot'=>$request->adresse_depot,
                'code_depot'=>$request->code_depot,
                'departement_id'=> $request->departement_id,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp()
            ]);
        }
    }


    public function update_data(Request $request,$id)
    {
        if ($request->has('use_depot_principal')){
            $use_depot_principal =1;
        }else{
            $use_depot_principal=0;
        }

        if($request->has('use_depot_principal')){

            $ancienne_depot_principal = Entite::where('use_depot_principal', 1)->first();

            if ($ancienne_depot_principal) {

                $ancienne_depot_principal->update([
                    'use_depot_principal'=> 0,
                    'edit_ip' => $this->getIp(),
                    'edited_by' => Auth::user()->id,
                    'edit_date' => Carbon::now(),
                ]);
            }
            else {
                Entite::where('id',$id)->update([
                    'use_depot_principal'=> $use_depot_principal,
                    'name'=> $request->nom_entite,
                    'telephone_depot'=>$request->telephone_depot,
                    'ville_depot'=>$request->ville_depot,
                    'adresse_depot'=>$request->adresse_depot,
                    'code_depot'=>$request->code_depot,
                    'departement_id'=> $request->departement_id,
                    'edit_ip' => $this->getIp(),
                    'edited_by' => Auth::user()->id,
                    'edit_date' => Carbon::now(),
                ]);
            }

        }
        {
            Entite::where('id',$id)->update([
                'use_depot_principal'=> $use_depot_principal,
                'name'=> $request->nom_entite,
                'telephone_depot'=>$request->telephone_depot,
                'ville_depot'=>$request->ville_depot,
                'adresse_depot'=>$request->adresse_depot,
                'code_depot'=>$request->code_depot,
                'departement_id'=> $request->departement_id,
                'edit_ip' => $this->getIp(),
                'edited_by' => Auth::user()->id,
                'edit_date' => Carbon::now(),
            ]);;
        }
    }
}
