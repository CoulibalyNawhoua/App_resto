<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheTechnique extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='fiches_techniques';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'commentaire',
        'quantity',
        'produit_id',
        'recette_id',
        'unite_id',
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
        'depot_id',
        'groupe_unite_id'
    ];


    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }

    public function groupeUnite()
    {
         return $this->belongsTo(UnitGroup::class, 'groupe_unite_id', 'id');
    }

    public function recette()
    {
        return $this->belongsTo(Recette::class, 'recette_id', 'id');
    }
}
