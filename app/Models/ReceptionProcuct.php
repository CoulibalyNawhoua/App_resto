<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReceptionProcuct extends Model
{
    use HasFactory;

    use SpatieLogsActivity;

    protected $table='receptions_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
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
        'quantity',
        'quantity_received',
        'unit_price',
        'sub_total',
        'receptions_id',
        'produit_id',
        'procurement_product_id',
        'product_unit_id',
        'order_product_id',
        'unit_quantity'
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
