<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POItem extends Model
{
    use HasFactory;

    protected $table = 'po_items';

    protected $fillable = [
        'purchase_order_id',
        'judul_po',
        'quantity',
        'harga',
        'keterangan',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'harga' => 'integer',
    ];

    /**
     * Get the purchase order that owns this item
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    /**
     * Get formatted price
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Get total price (quantity * harga)
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->harga;
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}