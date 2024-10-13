<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='fournisseurs';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'nom',
        'phone',
        'prenom',
        'address',
        'commantaire',
        'statut',
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
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }

}
