<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Unite;
use App\Models\Produit;
use App\Models\UnitGroup;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUniteRequest;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class UniteRepository extends Repository
{
    public function __construct(Unite $model)
    {
        $this->model = $model;
    }

    public function ListeUnites()
    {
        return Unite::where('unites.is_deleted',0)
            ->leftJoin('users','users.id','=','unites.added_by')
            ->leftJoin('groups_units','groups_units.id','=','unites.unit_group_id')
            ->selectRaw('unites.*, CONCAT(users.first_name," ",users.first_name) as created_by, groups_units.name AS unit_group');
    }


    public function store(StoreUniteRequest $request)
    {
        $unit = Unite::create([
            'name' => $request->name,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp()
        ]);

        $unit->groupsUnits()->sync($request->groups);
    }


     public function updateUnit(StoreUniteRequest $request, $id)
    {

        $unit = $this->model->find($id);

        $unit->name = $request->name;
        $unit->save();
        $unit->groupsUnits()->sync($request->groups);
    }




    // public function store(StoreUniteRequest $request)
    // {
    //     $record = Unite::where('id', $request->unite_id)->first();

    //     if(is_null($record)) {
    //         Unite::create([
    //             'name' => $request->nom_unite,
    //             'unit_group_id' => $request->unit_group_id,
    //             'added_by' => Auth::user()->id,
    //             'add_ip' => $this->getIp()
    //         ]);
    //     } else {
    //         $record->name = $request->nom_unite;
    //         $record->unit_group_id = $request->unit_group_id;
    //         $record->edited_by = Auth::user()->id;
    //         $record->edit_ip = $this->getIp();
    //         $record->edit_date = Carbon::now();
    //         $record->update();
    //     }
    // }

    public function selectProductSubUnit($productId)
    {
        $product = Produit::where('id',$productId)->first();


        $unite = DB::table('unit_group')
                    ->selectRaw('groups_units.id, groups_units.name')
                    ->leftJoin('groups_units','groups_units.id','=','unit_group.unit_group_id')
                    ->where('unite_id',$product->unites_id)->get();

        return $unite;

    }


    public function selectUnitGroupUnit($id)
    {
        return DB::table('unit_group')
                ->selectRaw('groups_units.id, groups_units.name')
                ->leftJoin('groups_units','groups_units.id','=','unit_group.unit_group_id')
                ->where('unite_id',$id)->get();

    }
}
