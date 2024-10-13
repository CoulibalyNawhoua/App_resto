<?php

namespace App\Repositories;

use App\Models\Fournisseur;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFournisseurRequest;
use Carbon\Carbon;

class FournisseurRepository extends Repository
{
    public function __construct(Fournisseur $model)
    {
        $this->model = $model;
    }


    public function liste_fornisseurs()
    {

        $query = Fournisseur::where('fournisseurs.is_deleted',0)
                ->leftJoin('users','users.id','=','fournisseurs.added_by');

        return $query->selectRaw('fournisseurs.*, CONCAT(users.first_name," ",users.last_name) as created_by')->get();
    }

    public function store(StoreFournisseurRequest $request)
    {
        $record = Fournisseur::where('id', $request->fournisseur_id)->first();


        if(is_null($record)) {
            $record = Fournisseur::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'phone' => $request->telephone,
                'address' => $request->localisation,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp(),
            ]);
        } else {
            $record->nom = $request->nom;
            $record->prenom = $request->prenom;
            $record->phone = $request->telephone;
            $record->address = $request->localisation;
            $record->edited_by = Auth::user()->id;
            $record->edit_date = Carbon::now();
            $record->edit_ip = $this->getIp();
            $record->update();
        }
    }
}
