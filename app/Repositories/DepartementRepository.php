<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepartementRepository extends Repository
{
    public function __construct(Departement $model)
    {
        $this->model = $model;
    }


    public function ListeDepartements()
    {
        return DB::table('departements')->where('is_deleted',0)
            ->leftJoin('users','users.id','=','departements.added_by')
            ->selectRaw('departements.*, CONCAT(users.first_name," ",users.first_name) as created_by');
    }

    public function store(Request $request)
    {
        $record = Departement::where('id', $request->departement_id)->first();

        if(is_null($record)) {
            Departement::create([
                'nom_departement' => $request->nom_departement,
                'code_depart'=> $request->code_departement,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp()
            ]);
        } else {
            $record->nom_departement = $request->nom_departement;
            $record->code_depart = $request->code_departement;
            $record->edited_by = Auth::user()->id;
            $record->edit_ip = $this->getIp();
            $record->edit_date = Carbon::now();
            $record->update();
        }
    }
}
