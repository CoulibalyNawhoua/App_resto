<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Pvd_setting;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePvdSettingTimeRequest;

class Pvd_settingRepository extends Repository
{
    public function __construct(Pvd_setting $model)
    {
        $this->model = $model;
    }

    public function get_pvd_setting()
    {
        $user_depot_id = Auth::user()->depot_id;

        $depot_select_id = (!empty($_GET["depot_select_id"])) ? ($_GET["depot_select_id"]) : ('');

        if ($user_depot_id) {
            $query = Pvd_setting::leftJoin('jours','jours.id','=','pvd_setting.code_jour')
                        ->where('pvd_setting.depot_id', $user_depot_id)
                        ->selectRaw('pvd_setting.*,jours.libelle');
        }
        else {
            $query = Pvd_setting::leftJoin('jours','jours.id','=','pvd_setting.code_jour')
                        ->selectRaw('pvd_setting.*,jours.libelle');
        }



        if (!empty($depot_select_id)){
            $query->where('pvd_setting.depot_id', '=',$depot_select_id);
        }

       return $query;
    }

    public function pvd_setting_update(StorePvdSettingTimeRequest $request, $id)
    {
        Pvd_setting::where('id',$id)->update([
            'activate'=> $request->activate,
            'heure_debut'=>$request->heure_debut,
            'heure_fin'=> $request->heure_fin,
            'code_jour'=> $request->code_jour,
            'edit_ip' => $this->getIp(),
            'edited_by' => Auth::user()->id,
            'edit_date' => Carbon::now(),
        ]);
    }

    public function edit_pvd_setting_time($id)
    {
       return Pvd_setting::leftJoin('jours','jours.id','=','pvd_setting.code_jour')
                            ->where('pvd_setting.id', $id)
                            ->selectRaw('pvd_setting.*,jours.libelle')
                            ->first();
    }


    public function pvd_setting_time_status()
    {

        $depot_id = Auth::user()->depot_id;

        $time = Pvd_setting::where('is_deleted', 0)
                            ->where('code_jour', Carbon::now()->dayOfWeekIso)
                            ->where('depot_id', $depot_id)
                            ->select('heure_debut','heure_fin','activate')->first();

        $current_time = Carbon::now()->toTimeString();

        $time_start =  $time->heure_debut;

        $time_end = $time->heure_fin;


        if ($current_time >= $time_start &&  $current_time <=  $time_end && $time->activate === 1) {
            $status = 'valid';
        } else {
            $status = 'invalid';
        }

        return $status;

    }

}
