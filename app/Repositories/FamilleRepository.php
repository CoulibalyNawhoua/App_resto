<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Famille_produit;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFamilleRequest;
use App\Models\Famille;

/**
 * Class FamilleRepository.
 */
class FamilleRepository extends Repository
{
    public function __construct(Famille $model)
    {
        $this->model = $model;
    }

    public function ListeFamilles()
    {
        return Famille::where('is_deleted',0)
            ->leftJoin('users','users.id','=','familles.added_by')
            ->selectRaw('familles.*, CONCAT(users.first_name," ",users.first_name) as created_by');
    }



    public function store(StoreFamilleRequest $request)
    {
        $record = Famille::where('id', $request->famille_id)->first();

        if(is_null($record)) {
            $famille = Famille::create([
                'name' => $request->nom_famille,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp()
            ]);
        } else {
            $record->name = $request->nom_famille;
            $record->edited_by = Auth::user()->id;
            $record->edit_ip = $this->getIp();
            $record->edit_date = Carbon::now();
            $record->update();
        }
    }

}
