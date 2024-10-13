<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryProduct extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='delivery_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'produit_id',
        'quantity_delivered',
        'product_unit_quantity',
        'product_unit_id',
        'order_item_id',
        'order_quantity',
        'make_delivery',
        'created_at',
        'updated_at',
        'delivery_id'
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
