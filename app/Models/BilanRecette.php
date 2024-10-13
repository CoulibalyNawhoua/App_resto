<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BilanRecette extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='bilans_recettes';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'recette_id',
        'quantity',
        'etat',
        'bilan_id',
        'created_at',
        'updated_at',
        'add_date',
        'added_by',
        'add_ip',
        'edited_by',
        'edit_date',
        'edit_ip',
        'is_deleted',
        'delete_ip',
        'delete_date',
    ];

    public function recette()
    {
        return $this->belongsTo(Recette::class,'recette_id' , 'id');
    }

}
