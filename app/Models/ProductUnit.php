<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductUnit extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='produits_unites';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'produit_id',
        'unite_id',
        'pcb',
        'price',
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
    ];

    public function unite()
    {
        return $this->belongsTo(Unite::class, 'unite_id', 'id');
    }
}
