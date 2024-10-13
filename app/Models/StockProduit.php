<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockProduit extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='stock_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'created_at',
        'updated_at',
        'entite_id',
        'quantite',
        'produit_id',
        'unite_id',
        'entite_id',
        'faible_quantite',
        'alerte_stock_activee'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class,'produit_id', 'id');
    }
}
