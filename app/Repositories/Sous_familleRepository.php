<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Sous_famille;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSousFamilleRequest;

/**
 * Class Sous_familleRepository.
 */
class Sous_familleRepository extends Repository
{
    public function __construct(Sous_famille $model)
    {
        $this->model = $model;
    }


    public function liste_sous_fammilles()
    {
        return Sous_famille::where('sous_familles.is_deleted',0)
                            ->leftJoin('familles','familles.id','=','sous_familles.familles_id')
                            ->leftJoin('users','users.id','=','sous_familles.added_by')
                            ->selectRaw('sous_familles.*, familles.name AS nom_famille, CONCAT(users.first_name," ",users.last_name) as created_by');

    }


    public function store(StoreSousFamilleRequest $request)
    {
        $record = Sous_famille::where('id', $request->sous_famille_id)->first();

        if(is_null($record)) {
            $record = Sous_famille::create([
                'name' => $request->nom_sous_famille,
                'familles_id'=> $request->famille_id,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp()
            ]);
        } else {
            $record->name = $request->nom_sous_famille;
            $record->familles_id = $request->famille_id;
            $record->edited_by = Auth::user()->id;
            $record->edit_ip = $this->getIp();
            $record->edit_date = Carbon::now();
            $record->update();
        }
    }


}
