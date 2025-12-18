<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_po',
        'judul_po',
        'tanggal_po',
        'rfs_date',
        'markom_branch_id',
        'jenis_item',
        'jenis_item_lainnya',
    ];

    protected $casts = [
        'tanggal_po' => 'date',
        'rfs_date' => 'date',
        'jenis_item' => 'array',
    ];

    /**
     * Get all items for this purchase order
     */
    public function items()
    {
        return $this->hasMany(POItem::class, 'purchase_order_id');
    }

    /**
     * Get the Markom Branch user assigned to this PO
     */
    public function markomBranch()
    {
        return $this->belongsTo(User::class, 'markom_branch_id');
    }
}