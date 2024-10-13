<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementProduct extends Model
{
    use HasFactory;
    use SpatieLogsActivity;


    protected $table='procurements_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'produit_id',
        'quantity',
        'purchase_price',
        'total_purchase_price',
        'quantity_received',
        'fournisseur_id',
        'procurement_id',
        'product_receipt_status',
        'reference',
        'created_at',
        'updated_at',
        'add_date',
        'added_by',
        'add_ip',
        'edited_by',
        'edit_date',
        'edit_ip',
        'is_deleted',
        'deleted_by',
        'delete_ip',
        'delete_date',
        'product_unit_id',
        'unit_quantity',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class,'produit_id','id');
    }

    public function product_unit()
    {
        return $this->belongsTo(ProductUnit::class,'product_unit_id','id');
    }
}
