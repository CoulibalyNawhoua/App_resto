<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reception extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='receptions';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
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
        'total_receipt_price',
        'tax_value',
        'value',
        'delivery_date',
        'invoice_reference',
        'note',
        'entite_id',
        'reception_date',
        'procurements_id',
        'order_id',
        'receipt_status'
    ];

    public function produitReceptions()
    {
        return $this->hasMany(ReceptionProcuct::class, 'receptions_id', 'id');
    }

    public function procurement()
    {
        return $this->belongsTo(Procurement::class, 'procurements_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }
}
