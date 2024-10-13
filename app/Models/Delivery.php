<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='delivery';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'delivery_status',
        'order_id',
        'note',
        'delivery_date',
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
        'entite_id',
        'delete_date',
        'delivery_confirm_by',
        'delivery_confirm_date',
        'delivery_confirm_by',
        'delivery_date',
        'commentaire',
        'preparation_date'
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id','id');
    }

    public function depotStockage()
    {
        return $this->belongsTo(Entite::class, 'entite_id','id');
    }

    public function deliveryProduct()
    {
        return $this->belongsTo(DeliveryProduct::class, 'delivery_id','id');
    }
}
