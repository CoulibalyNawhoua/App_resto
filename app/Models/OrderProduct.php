<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='orders_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'produit_id',
        'quantity',
        'unite_price',
        'product_unit_id',
        'order_id',
        'created_at',
        'updated_at',
        'quantity_received',
        'product_receipt_status'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id','id');
    }

    public function product_unit()
    {
        return $this->belongsTo(ProductUnit::class,'product_unit_id','id');
    }
}
