<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Famille extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='familles';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'code_famille',
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
        'depot_id'
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }
}
