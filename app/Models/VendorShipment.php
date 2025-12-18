<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorShipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resi_pengiriman',
        'nama_vendor',
        'kontak_vendor',
        'jenis_item',
        'jumlah_item',
        'alamat_pengiriman',
        'tanggal_pengiriman',
        'catatan',
        'foto_resi',
        'status',
    ];

    protected $casts = [
        'tanggal_pengiriman' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}