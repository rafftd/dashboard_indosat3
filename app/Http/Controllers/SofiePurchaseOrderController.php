<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\POItem;
use App\Models\MatproReceipt;
use App\Models\VendorShipment;
use Illuminate\Support\Facades\DB;

class SofiePurchaseOrderController extends Controller
{
    /**
     * Display a listing of purchase orders
     */
    public function index(Request $request)
    {
        $purchaseOrders = PurchaseOrder::with('items')->latest()->get();
        
        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $purchaseOrders
            ]);
        }
        
        return view('admin', compact('purchaseOrders'));
    }

    /**
     * Store a newly created purchase order
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_po' => 'required|string|unique:purchase_orders,nomor_po',
            'judul_po' => 'required|string',
            'tanggal_po' => 'required|date',
            'rfs_date' => 'nullable|date',
            'jenis_item' => 'required|array|min:1',
            'jenis_item.*' => 'string|in:baliho,poster,pamflet,other',
            'jenis_item_lainnya' => 'required_if:jenis_item.*,other|nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create Purchase Order
            $purchaseOrder = PurchaseOrder::create([
                'nomor_po' => $request->nomor_po,
                'judul_po' => $request->judul_po,
                'tanggal_po' => $request->tanggal_po,
                'rfs_date' => $request->rfs_date,
                'jenis_item' => $request->jenis_item,
                'jenis_item_lainnya' => in_array('other', $request->jenis_item) ? $request->jenis_item_lainnya : null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil dibuat!',
                'data' => $purchaseOrder
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Purchase Order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified purchase order
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items');
        
        return response()->json([
            'success' => true,
            'data' => $purchaseOrder,
            'items' => $purchaseOrder->items
        ]);
    }

    /**
     * Update the specified purchase order
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'nomor_po' => 'required|string|unique:purchase_orders,nomor_po,' . $purchaseOrder->id,
            'judul_po' => 'required|string',
            'tanggal_po' => 'required|date',
            'rfs_date' => 'nullable|date',
            'jenis_item' => 'required|array|min:1',
            'jenis_item.*' => 'string|in:baliho,poster,pamflet,other',
            'jenis_item_lainnya' => 'required_if:jenis_item.*,other|nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update Purchase Order
            $purchaseOrder->update([
                'nomor_po' => $request->nomor_po,
                'judul_po' => $request->judul_po,
                'tanggal_po' => $request->tanggal_po,
                'rfs_date' => $request->rfs_date,
                'jenis_item' => $request->jenis_item,
                'jenis_item_lainnya' => in_array('other', $request->jenis_item) ? $request->jenis_item_lainnya : null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil diupdate!',
                'data' => $purchaseOrder
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate Purchase Order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified purchase order
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        try {
            $purchaseOrder->delete();
            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Purchase Order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all matpro receipts
     */
    public function getMatproReceipts()
    {
        $receipts = MatproReceipt::with('user')
            ->latest()
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $receipts
        ]);
    }

    /**
     * Get all vendor shipments
     */
    public function getVendorShipments()
    {
        $shipments = VendorShipment::with('user')
            ->latest()
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $shipments
        ]);
    }
}

