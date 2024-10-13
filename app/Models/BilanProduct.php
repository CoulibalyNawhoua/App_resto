<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BilanProduct extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='bilans_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'quantity',
        'before_quantity',
        'after_quantity',
        'produit_id',
        'unite_id',
        'product_unit_id',
        'operation_type',
        'bilan_id',
        'entite_id',
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


    public function site()
    {
        return $this->belongsTo(Entite::class,'entite_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Produit::class,'produit_id','id');
    }

    public function bilan()
    {
        return $this->belongsTo(Bilan::class,'bilan_id','id');
    }

    public function product_unit()
    {
        return $this->belongsTo(Unite::class,'product_unit_id','id');
    }

    public function productUnitUse()
    {
        return $this->belongsTo(UnitGroup::class,'unite_id','id');
    }
}
