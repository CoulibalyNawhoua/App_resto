<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjustementProduit extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='ajustements_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'before_quantity',
        'produit_id',
        'quantity',
        'gap',
        'ajustement_id',
        'after_quantity',
        'ajustement_unit_id',
        'product_unit_id',
        'product_unit_quantity',
        'type_ajustement_id',
        'quantity_after_conversion',
        'types',
        'product_stock_id',
        'add_date',
        'added_by',
        'add_ip',
        'created_at',
        'updated_at',
        'edited_by',
        'edit_date',
        'edit_ip',
        'is_deleted',
        'deleted_by',
        'delete_ip',
        'delete_date',
        'entite_id'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }
}
