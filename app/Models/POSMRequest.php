<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSMRequest extends Model
{
    use HasFactory;

    protected $table = 'posm_requests';

    protected $fillable = [
        'user_id',
        'request_number',
        'branch',
        'requester_name',
        'requester_phone',
        'contact_number',
        'deadline',
        'location_address',
        'shipping_address',
        'location_type',
        'purpose',
        'posm_type',
        'quantity',
        'custom_size',
        'additional_link',
        'spreadsheet_link',
        'design_link',
        'mandatory_elements',
        'installation_date',
        'duration_days',
        'items',
        'special_notes',
        'notes',
        'attachments',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'production_status',
        'production_started_at',
        'production_completed_at',
    ];

    protected $casts = [
        'items' => 'array',
        'attachments' => 'array',
        'installation_date' => 'date',
        'deadline' => 'date',
        'approved_at' => 'datetime',
        'production_started_at' => 'datetime',
        'production_completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the POSM request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the approver user
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved requests
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected requests
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope for completed requests
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get status badge CSS class
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => ucfirst($this->status),
        };
    }
}
