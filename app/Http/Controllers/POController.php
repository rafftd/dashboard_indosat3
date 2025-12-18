<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class POController extends Controller
{
    /**
     * Display a listing of purchase orders
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::orderBy('created_at', 'desc')->get();
        
        // Add calculated fields
        $purchaseOrders->map(function($po) {
            // Calculate days difference
            $rfsDate = Carbon::parse($po->rfs_date);
            $today = Carbon::now();
            $daysDiff = $today->diffInDays($rfsDate, false);
            
            // Determine status and label
            if ($daysDiff < 0) {
                $po->status = 'urgent';
                $po->days_label = 'H' . abs($daysDiff);
            } else {
                $po->status = 'normal';
                $po->days_label = 'H-' . $daysDiff;
            }
            
            // Check if has answer (customize based on your logic)
            $po->has_answer = rand(0, 1); // Example: random for demo
            
            return $po;
        });
        
        return view('po.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new purchase order
     */
    public function create()
    {
        return view('po.create-po');
    }

    /**
     * Store a newly created purchase order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_po' => 'required|string|max:255|unique:purchase_orders',
            'tanggal_po' => 'required|date',
            'rfs_date' => 'nullable|date',
            'jenis_item' => 'required|string',
            'jenis_item_lainnya' => 'nullable|string|required_if:jenis_item,Others',
            'judul_po' => 'nullable|array',
            'quantity' => 'nullable|array',
            'harga' => 'nullable|array',
            'keterangan' => 'nullable|array',
        ]);

        // Process jenis_item
        if ($validated['jenis_item'] === 'Others') {
            $validated['jenis_item'] = $validated['jenis_item_lainnya'];
        }

        // Create main PO record
        $po = PurchaseOrder::create([
            'nomor_po' => $validated['nomor_po'],
            'tanggal_po' => $validated['tanggal_po'],
            'rfs_date' => $validated['rfs_date'],
            'jenis_item' => $validated['jenis_item'],
        ]);

        // Store dynamic columns if exists
        if (!empty($validated['judul_po'])) {
            foreach ($validated['judul_po'] as $index => $judul) {
                if (!empty($judul)) {
                    $po->items()->create([
                        'judul_po' => $judul,
                        'quantity' => $validated['quantity'][$index] ?? 0,
                        'harga' => $this->cleanCurrency($validated['harga'][$index] ?? 0),
                        'keterangan' => $validated['keterangan'][$index] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('po.index')
            ->with('success', 'Purchase Order berhasil dibuat!');
    }

    /**
     * Display the specified purchase order
     */
    public function show($id)
    {
        $po = PurchaseOrder::with('items')->findOrFail($id);
        return view('po.show', compact('po'));
    }

    /**
     * Remove the specified purchase order
     */
    public function destroy($id)
    {
        try {
            $po = PurchaseOrder::findOrFail($id);
            $po->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Purchase Order'
            ], 500);
        }
    }

    /**
     * Get answer for specific PO
     */
    public function getAnswer($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        
        // Your logic to get answer
        return response()->json([
            'answer' => 'Sample answer for PO ' . $po->nomor_po
        ]);
    }

    /**
     * Clean currency format (Rp 1.000.000 -> 1000000)
     */
    private function cleanCurrency($value)
    {
        return (int) preg_replace('/[^0-9]/', '', $value);
    }
}