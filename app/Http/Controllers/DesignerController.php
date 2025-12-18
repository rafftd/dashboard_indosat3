<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\POSMRequest;
use Illuminate\Support\Facades\Auth;

class DesignerController extends Controller
{
    /**
     * Display designer dashboard with approval inbox
     */
    public function index(Request $request)
    {
        // Handle JSON requests for AJAX pagination
        if ($request->wantsJson()) {
            $type = $request->get('type', 'pending');
            
            if ($type === 'pending') {
                $pendingRequests = POSMRequest::with('user')
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                    
                return response()->json([
                    'success' => true,
                    'data' => $pendingRequests
                ]);
            } else if ($type === 'completed') {
                $completedRequests = POSMRequest::with(['user', 'approver'])
                    ->whereIn('status', ['approved', 'rejected'])
                    ->orderBy('approved_at', 'desc')
                    ->paginate(10);
                    
                return response()->json([
                    'success' => true,
                    'data' => $completedRequests
                ]);
            }
        }
        
        // Get pending POSM requests for approval
        $pendingRequests = POSMRequest::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'pending_page');

        // Get completed POSM requests (approved or rejected)
        $completedRequests = POSMRequest::with(['user', 'approver'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('approved_at', 'desc')
            ->paginate(10, ['*'], 'completed_page');

        // Calculate statistics
        $allRequests = POSMRequest::all();
        
        $stats = [
            'total_requests' => $allRequests->count(),
            'pending_approval' => $allRequests->where('status', 'pending')->count(),
            'urgent_requests' => $allRequests->where('status', 'pending')
                ->filter(function($request) {
                    if (!$request->deadline) return false;
                    $deadline = \Carbon\Carbon::parse($request->deadline);
                    $today = \Carbon\Carbon::now();
                    $daysLeft = $today->diffInDays($deadline, false);
                    return $daysLeft <= 3 && $daysLeft >= 0;
                })->count(),
            'approved_sla' => $allRequests->where('status', 'approved')
                ->filter(function($request) {
                    if (!$request->approved_at || !$request->created_at) return false;
                    $created = \Carbon\Carbon::parse($request->created_at);
                    $approved = \Carbon\Carbon::parse($request->approved_at);
                    $hours = $created->diffInHours($approved);
                    return $hours <= 24; // SLA < 24 jam
                })->count(),
            'on_process' => $allRequests->where('status', 'approved')
                ->where('production_status', 'start_produce')->count(),
        ];

        return view('designer', compact('pendingRequests', 'completedRequests', 'stats'));
    }

    /**
     * Get POSM request details
     */
    public function show($id)
    {
        $request = POSMRequest::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $request
        ]);
    }

    /**
     * Approve or reject POSM request
     */
    public function updateApproval(Request $request, $id)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string',
            'production_status' => 'required_if:action,approve|nullable|in:start_produce,completed',
        ]);

        $posmRequest = POSMRequest::findOrFail($id);

        if ($validated['action'] === 'approve') {
            $posmRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'production_status' => $validated['production_status'] ?? 'start_produce',
            ]);

            $statusText = $validated['production_status'] === 'completed' ? 'Selesai' : 'Start Produce';
            $message = "Permintaan berhasil disetujui dengan status \"{$statusText}\"!";
        } else {
            $posmRequest->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
            ]);

            $message = 'Permintaan POSM berhasil ditolak';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $posmRequest
        ]);
    }

    /**
     * Update production status
     */
    public function updateProductionStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'production_status' => 'required|in:start_produce,completed',
        ]);

        $posmRequest = POSMRequest::findOrFail($id);

        if ($posmRequest->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya permintaan yang sudah disetujui yang dapat diupdate status produksinya'
            ], 403);
        }

        $posmRequest->update([
            'production_status' => $validated['production_status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status produksi berhasil diupdate',
            'data' => $posmRequest
        ]);
    }

    /**
     * Display vendor shipments list
     */
    public function vendorShipments(Request $request)
    {
        $shipments = \App\Models\VendorShipment::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Handle JSON requests for AJAX
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $shipments
            ]);
        }

        return view('designer-vendor-shipments', compact('shipments'));
    }

    /**
     * Get vendor shipment details
     */
    public function getVendorShipmentDetail($id)
    {
        $shipment = \App\Models\VendorShipment::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $shipment
        ]);
    }
}
