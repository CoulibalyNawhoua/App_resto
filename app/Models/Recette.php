<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='recettes';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'prix_unitaire',
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
        'depot_id'
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function fichesTechniques()
    {
        return $this->hasMany(FicheTechnique::class, 'recette_id','id');
    }
}
