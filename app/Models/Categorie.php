<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='categories';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'nom_categorie',
        'sous_famille_id',
        'code_categorie',
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

    public function produits() {

        return $this->hasMany(Produit::class,'categories_id','id');
    }

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }
}
