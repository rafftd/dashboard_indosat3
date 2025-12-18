<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatproReceipt extends Model
{
    use HasFactory;

    protected $table = 'matpro_receipts';

    protected $fillable = [
        'user_id',
        'nama_penerima',
        'branch',
        'matpro',
        'tanggal_diterima',
        'bukti_file',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'tanggal_diterima' => 'date',
    ];

    /**
     * Get the user that owns the receipt
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
