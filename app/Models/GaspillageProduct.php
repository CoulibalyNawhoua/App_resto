<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GaspillageProduct extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='gaspillages_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'before_quantity',
        'after_quantity',
        'produit_id',
        'gaspillage_id',
        'quantity',
        'quantity_after_conversion',
        'motif_gaspillage_id',
        'entite_id',
        'gaspillage_unit_id',
        'product_unit_id',
        'product_unit_quantity',
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
}
