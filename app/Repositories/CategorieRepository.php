<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Categorie;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategorieRequest;

class CategorieRepository extends Repository
{
    public function __construct(Categorie $model)
    {
        $this->model = $model;
    }

    public function ListeCategories()
    {
        return Categorie::where('is_deleted',0)
            ->leftJoin('users','users.id','=','categories.added_by')
            ->selectRaw('categories.*, CONCAT(users.first_name," ",users.first_name) as created_by');
    }



    public function store(StoreCategorieRequest $request)
    {
        $record = Categorie::where('id', $request->categorie_id)->first();

        if(is_null($record)) {
            Categorie::create([
                'nom_categorie' => $request->nom_categorie,
                'sous_famille_id' => $request->sous_famille_id,
                'code_categorie'=>$request->code_categorie,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp()
            ]);
        } else {
            $record->nom_categorie = $request->nom_categorie;
            $record->sous_famille_id = $request->sous_famille_id;
            $record->code_categorie = $request->code_categorie;
            $record->edited_by = Auth::user()->id;
            $record->edit_ip = $this->getIp();
            $record->edit_date = Carbon::now();
            $record->update();
        }
    }
}
