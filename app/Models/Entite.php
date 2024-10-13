<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entite extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='entites';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'departement_id',
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
        'use_depot_principal',
        'code_depot',
        'adresse_depot',
        'ville_depot',
        'telephone_depot'
    ];


    public function departement() {

        return $this->belongsTo(Departement::class, 'departement_id', 'id');

    }

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }
}
