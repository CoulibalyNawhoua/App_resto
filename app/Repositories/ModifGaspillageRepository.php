<?php

namespace App\Repositories;

use App\Models\Motif_gaspillage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModifGaspillageRepository extends Repository
{
    public function __construct(Motif_gaspillage $model)
    {
        $this->model = $model;
    }

    public function motifGaspillageStore(Request $request)
    {
        $record = Motif_gaspillage::where('id', $request->motif_gaspillage_id)->first();

        if(is_null($record)) {
            Motif_gaspillage::create([
                'libelle' => $request->libelle,
                /*'action_stock_id' => $request->action_stock_id,*/
                // 'type_operation_id' => $request->type_operation_id,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp()
            ]);
        } else {
            $record->libelle = $request->libelle;
           /* $record->action_stock_id = $request->action_stock_id;*/
            // $record->type_operation_id = $request->type_operation_id;
            $record->edited_by = Auth::user()->id;
            $record->edit_ip = $this->getIp();
            $record->edit_date = Carbon::now();
            $record->update();
        }
    }



    public function motifGaspillageList()
    {
        return Motif_gaspillage::where('gaspillages_motifs.is_deleted',0)
            ->leftJoin('users','users.id','=','gaspillages_motifs.added_by')
            // ->leftJoin('actions_stocks','actions_stocks.id','=','operations.action_stock_id')
            // ->leftJoin('types_operations','types_operations.id','=','operations.type_operation_id')
            ->selectRaw('gaspillages_motifs.*, CONCAT(users.first_name," ",users.first_name) as auteur');
    }




}
