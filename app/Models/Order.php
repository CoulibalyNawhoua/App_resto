<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='orders';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'delivery_status',
        'total_amount',
        'entite_id',
        'destination_id',
        'order_date',
        'order_status',
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
        'validate_date',
        'validate_by',
        'validate_note',
        'confirm_date',
        'confirm_by',
        'confirm_note',
        'enclose_date',
        'enclose_by',
        'total_item_order'
    ];


    public function entite()
    {
        return $this->belongsTo(Entite::class, 'entite_id', 'id');
    }

    public function destination()
    {
        return $this->belongsTo(Entite::class, 'destination_id', 'id');
    }

    public function auteur()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id','id');
    }

    public function delivery()
    {
      return $this->hasMany(Delivery::class, 'order_id','id');
    }

    public function closeBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
