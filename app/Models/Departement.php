<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='departements';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'nom_departement',
        'code_depart',
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

    public function entite() {

        return $this->hasOne(Entite::class, 'departement_id', 'id');

    }
}
