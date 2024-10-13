<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bilan extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='bilans';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
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
        'status',
        'unite_id',
        'groupe_unite_id'
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }


    public function bilan_products()
    {
        return $this->belongsTo(BilanProduct::class,'bilan_id','id');
    }
}
