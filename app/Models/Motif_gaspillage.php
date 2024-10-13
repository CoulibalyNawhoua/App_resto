<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Motif_gaspillage extends Model
{
    use HasFactory;

    use SpatieLogsActivity;

    protected $table='gaspillages_motifs';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'libelle',
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

    // public function typeOperation()
    // {
    //     return $this->belongsTo(TypeOperation::class, 'type_operation_id','id');
    // }
}
