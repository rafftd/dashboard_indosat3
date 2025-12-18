<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorShipment;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VendorShipmentController extends Controller
{
    public function index()
    {
        return view('vendor');
    }

    public function getData()
    {
        $shipments = VendorShipment::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $shipments
        ]);
    }

    public function show($id)
    {
        $shipment = VendorShipment::findOrFail($id);
        
        // Add authorization check
        if ($shipment->user_id !== auth()->id()) {
            abort(403);
        }

        return response()->json([
            'success' => true,
            'data' => $shipment
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_vendor' => 'required|string|max:255',
                'resi_pengiriman' => 'required|string|max:255',
                'jenis_item' => 'required|string|max:255',
                'jumlah_item' => 'required|string|max:255',
                'alamat_pengiriman' => 'required|string',
                'tanggal_pengiriman' => 'required|date',
                'catatan' => 'nullable|string',
                'foto_resi' => 'required|file|image|max:5120', // Max 5MB
            ]);

            // Handle foto_resi upload
            $fotoResiPath = null;
            if ($request->hasFile('foto_resi')) {
                $file = $request->file('foto_resi');
                $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                
                // Store in public disk under vendor-resi folder
                $file->storeAs('vendor-resi', $fileName, 'public');
                $fotoResiPath = $fileName; // Simpan hanya nama file, bukan full path
            }

            $shipment = VendorShipment::create([
                'user_id' => auth()->id(),
                'resi_pengiriman' => $request->resi_pengiriman,
                'nama_vendor' => $request->nama_vendor,
                'kontak_vendor' => null,
                'jenis_item' => $request->jenis_item,
                'jumlah_item' => $request->jumlah_item,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
                'catatan' => $request->catatan,
                'foto_resi' => $fotoResiPath,
                'status' => 'Dalam Proses',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pengiriman berhasil disimpan!',
                'data' => $shipment,
                'resi' => $request->resi_pengiriman
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function print($id)
    {
        $shipment = VendorShipment::findOrFail($id);
        
        // Add authorization check
        if ($shipment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('vendor.print', compact('shipment'));
    }
}