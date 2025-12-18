<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\POSMRequest;
use App\Models\MatproReceipt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class POSMRequestController extends Controller
{
    /**
     * Display a listing of POSM requests
     */
    public function index(Request $request)
    {
        $requests = POSMRequest::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $requests
            ]);
        }
            
        return view('posmindex', compact('requests'));
    }

    /**
     * Show the form for creating a new POSM request
     */
    public function create()
    {
        return view('markombranch');
    }

    /**
     * Store a newly created POSM request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch' => 'required|string|max:255',
            'requester_name' => 'required|string|max:255',
            'requester_phone' => 'required|string|max:20',
            'deadline' => 'required|date',
            'shipping_address' => 'required|string',
            'purpose' => 'required|string',
            'posm_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'custom_size' => 'nullable|string',
            'spreadsheet_link' => 'nullable|url',
            'design_link' => 'nullable|url',
            'mandatory_elements' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Create POSM Request
        $posmRequest = POSMRequest::create([
            'user_id' => Auth::id(),
            'request_number' => 'POSM-' . date('Ymd') . '-' . str_pad(POSMRequest::count() + 1, 4, '0', STR_PAD_LEFT),
            'branch' => $validated['branch'],
            'requester_name' => $validated['requester_name'],
            'contact_number' => $validated['requester_phone'], // Required field
            'requester_phone' => $validated['requester_phone'],
            'deadline' => $validated['deadline'],
            'location_address' => $validated['shipping_address'], // Map to location_address
            'shipping_address' => $validated['shipping_address'],
            'location_type' => 'indoor', // Default value since not in form
            'installation_date' => $validated['deadline'], // Use deadline as installation_date
            'duration_days' => 1, // Default value
            'items' => json_encode([]), // Empty array as default
            'purpose' => $validated['purpose'],
            'posm_type' => $validated['posm_type'],
            'quantity' => $validated['quantity'],
            'custom_size' => $validated['custom_size'] ?? null,
            'spreadsheet_link' => $validated['spreadsheet_link'] ?? null,
            'design_link' => $validated['design_link'] ?? null,
            'mandatory_elements' => $validated['mandatory_elements'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan POSM berhasil dibuat',
            'data' => $posmRequest
        ]);
    }

    /**
     * Display the specified POSM request
     */
    public function show($id)
    {
        $request = POSMRequest::where('user_id', Auth::id())
            ->findOrFail($id);
            
        return response()->json([
            'success' => true,
            'data' => $request
        ]);
    }

    /**
     * Update the specified POSM request
     */
    public function update(Request $request, $id)
    {
        $posmRequest = POSMRequest::where('user_id', Auth::id())
            ->findOrFail($id);

        // Only allow updates if status is pending
        if ($posmRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengubah permintaan yang sudah diproses'
            ], 403);
        }

        $validated = $request->validate([
            'branch' => 'required|string|max:255',
            'requester_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'location_address' => 'required|string',
            'location_type' => 'required|in:indoor,outdoor,booth,event',
            'installation_date' => 'required|date',
            'duration_days' => 'required|integer|min:1',
            'items' => 'required|array|min:1',
            'special_notes' => 'nullable|string',
        ]);

        $posmRequest->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan POSM berhasil diperbarui',
            'data' => $posmRequest
        ]);
    }

    /**
     * Remove the specified POSM request
     */
    public function destroy($id)
    {
        $posmRequest = POSMRequest::where('user_id', Auth::id())
            ->findOrFail($id);

        // Only allow deletion if status is pending
        if ($posmRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus permintaan yang sudah diproses'
            ], 403);
        }

        // Delete attachments from storage
        if ($posmRequest->attachments) {
            foreach ($posmRequest->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $posmRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan POSM berhasil dihapus'
        ]);
    }

    /**
     * Show upload form for matpro receipt
     */
    public function showUploadForm()
    {
        // Get PurchaseOrders assigned to current user (if markom_branch)
        $purchaseOrders = collect();
        $currentUserId = Auth::id();
        
        if (Auth::user()->isMarkomBranch()) {
            $purchaseOrders = \App\Models\PurchaseOrder::where('markom_branch_id', $currentUserId)
                ->whereNotNull('markom_branch_id')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('upload-matpro', compact('purchaseOrders', 'currentUserId'));
    }

    /**
     * Store matpro receipt
     */
    public function storeReceipt(Request $request)
    {
        $validated = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'matpro' => 'required|string|max:255',
            'tanggal_diterima' => 'required|date',
            'bukti_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Upload file
        $filePath = null;
        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filePath = $file->store('matpro-receipts', 'public');
        }

        // Create receipt
        $receipt = MatproReceipt::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'nama_penerima' => $validated['nama_penerima'],
            'branch' => $validated['branch'],
            'matpro' => $validated['matpro'],
            'tanggal_diterima' => $validated['tanggal_diterima'],
            'bukti_file' => $filePath,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti penerimaan berhasil disimpan',
            'data' => $receipt
        ]);
    }

    /**
     * Delete matpro receipt
     */
    public function deleteReceipt($id)
    {
        try {
            $receipt = MatproReceipt::findOrFail($id);
            
            // Delete file from storage if exists
            if ($receipt->bukti_file && Storage::disk('public')->exists($receipt->bukti_file)) {
                Storage::disk('public')->delete($receipt->bukti_file);
            }
            
            $receipt->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Bukti penerimaan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus bukti penerimaan: ' . $e->getMessage()
            ], 500);
        }
    }
}
