<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\UnitGroup;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class UnitGroupRepository extends Repository
{
    public function __construct(UnitGroup $model=null)
    {
        $this->model = $model;
    }

    public function unitGroupList() {

        return UnitGroup::all();
    }



    public function store(Request $request) {

        $record = UnitGroup::where('id', $request->unit_group_id)->first();

        if (is_null($record)) {
            UnitGroup::create([
                'name'=> $request->name,
                'added_by' => Auth::user()->id,
                'add_ip' => $this->getIp()
            ]);
        } else {
           $record->name = $request->name;
            $record->edited_by = Auth::user()->id;
            $record->edit_ip = $this->getIp();
            $record->edit_date = Carbon::now();
            $record->update();
        }
    }

}
