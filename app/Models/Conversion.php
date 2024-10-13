<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversion extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='conversions';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'unite_depart_id',
        'unite_arrivee_id',
        'operation',
        'value',
        'created_at',
        'updated_at',
    ];


    public function unite_depart()
    {
        return $this->belongsTo(Unite::class,'unite_depart_id','id');
    }

    public function unite_arrivee()
    {
        return $this->belongsTo(UnitGroup::class,'unite_arrivee_id','id');
    }
}
