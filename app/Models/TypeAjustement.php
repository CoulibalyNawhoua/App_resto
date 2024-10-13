<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAjustement extends Model
{
    use HasFactory;

    use SpatieLogsActivity;

    protected $table='types_ajustements';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'libelle',
        'code',
        'created_at',
        'updated_at',

    ];
}
