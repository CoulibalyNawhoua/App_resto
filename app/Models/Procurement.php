<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Procurement extends Model
{
    use HasFactory;
    use SpatieLogsActivity;

    protected $table='procurements';
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
        'delete_ip',
        'delete_date',
        'delivery_status',
        'payment_status',
        'receipt_status',
        'cost',
        'tax_value',
        'value',
        'delivery_date',
        'invoice_reference',
        'fournisseur_id',
        'entite_id',
        'commentaire',
        'date_commande',
        'date_prevue_reception',
        'procurment_status',
        'confirm_date',
        'confirm_by',
        'confirm_note',
        'total_produit',
        'closed_by',
        'closed_date'
    ];

    public function procurementProduits()
    {
        return $this->hasMany(ProcurementProduct::class, 'procurement_id', 'id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class,'fournisseur_id','id');
    }

    public function auteur()
    {
        return $this->belongsTo(User::class,'added_by','id');
    }

    public function depotStockage()
    {
        return $this->belongsTo(Entite::class,'entite_id','id');
    }

}
