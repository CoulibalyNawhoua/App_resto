<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='produits';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'nom_produit',
        'categories_id',
        'unites_id',
        'reference_produit',
        'sous_familles_id',
        'pcb_product',
        'prix_achat',
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

    public function unite()
    {
        return $this->belongsTo(Unite::class, 'unites_id', 'id');
    }

    public function stock()
    {
       return $this->belongsTo(Produit::class, 'produit_id','id');
    }

    public function productUnit()
    {
        return $this->hasMany(productUnit::class, 'produit_id', 'id');
    }

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }
}
