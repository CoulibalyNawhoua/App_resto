<?php

namespace App\Repositories;

use App\Models\Unite;
use App\Models\Conversion;
use Illuminate\Http\Request;
use App\Repositories\Repository;

class ConversionRepository extends Repository
{
    public function __construct(Conversion $model)
    {
        $this->model = $model;
    }


    public function ListeConversions() {

        return Conversion::with('unite_depart','unite_arrivee');
    }

    public function selectUnitArrived($id) {

        return Unite::where('id','!=',$id)->where('is_deleted',0)->get();
    }


    public function StoreConversion(Request $request) {

        $record = Conversion::where('id', $request->conversion_id)->first();

        if (is_null($record)) {
            Conversion::create([
                'unite_depart_id'=> $request->unite_depart_id,
                'unite_arrivee_id'=> $request->unite_arrive_id,
                // 'operation'=> $request->operation,
                'value'=> $request->value,
            ]);
        } else {
            $record->unite_depart_id = $request->unite_depart_id;
            $record->unite_arrivee_id = $request->unite_arrive_id;
            // $record->operation = $request->operation;
            $record->value = $request->operation;
        }
    }

    public function conversionDelete($id)
    {
        $this->model->find($id)->delete();
    }
}
