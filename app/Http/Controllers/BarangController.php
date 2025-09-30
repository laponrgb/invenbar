<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; 

class BarangController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:manage barang', except: ['destroy']),
            new Middleware('permission:delete barang', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $barangs = Barang::with(['kategori', 'lokasi'])
            ->when($search, function ($query, $search) {
                $query->where('nama_barang', 'like', '%' . $search . '%')
                      ->orWhere('kode_barang', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('barang.index', compact('barangs', 'search'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();

        $barang = new Barang();

        return view('barang.create', compact('barang', 'kategori', 'lokasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang'          => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang'          => 'required|string|max:150',
            'kategori_id'          => 'required|exists:kategoris,id',
            'lokasi_id'            => 'required|exists:lokasis,id',
            'satuan'               => 'required|string|max:20',
            'jumlah_baik'          => 'required|integer|min:0',
            'jumlah_rusak_ringan'  => 'required|integer|min:0',
            'jumlah_rusak_berat'   => 'required|integer|min:0',
            'tanggal_pengadaan'    => 'required|date',
            'gambar'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['jumlah'] = 
            ($validated['jumlah_baik'] ?? 0) +
            ($validated['jumlah_rusak_ringan'] ?? 0) +
            ($validated['jumlah_rusak_berat'] ?? 0);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store(null, 'gambar-barang');
        }

        Barang::create($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi']);

        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $lokasi   = Lokasi::all();

        return view('barang.edit', compact('barang', 'kategori', 'lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang'          => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'          => 'required|string|max:150',
            'kategori_id'          => 'required|exists:kategoris,id',
            'lokasi_id'            => 'required|exists:lokasis,id',
            'satuan'               => 'required|string|max:20',
            'jumlah_baik'          => 'required|integer|min:0',
            'jumlah_rusak_ringan'  => 'required|integer|min:0',
            'jumlah_rusak_berat'   => 'required|integer|min:0',
            'tanggal_pengadaan'    => 'required|date',
            'gambar'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['jumlah'] = 
            ($validated['jumlah_baik'] ?? 0) +
            ($validated['jumlah_rusak_ringan'] ?? 0) +
            ($validated['jumlah_rusak_berat'] ?? 0);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('gambar-barang')->delete($barang->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store(null, 'gambar-barang');
        }

        $barang->update($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            Storage::disk('gambar-barang')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }
    
    public function cetakLaporan()
    {
        $barangs = Barang::with(['kategori', 'lokasi'])->get();

        $data = [
            'title' => 'Laporan Data Barang Inventaris',
            'date' => date('d F Y'),
            'barangs' => $barangs,
        ];

        $pdf = Pdf::loadView('barang.laporan', $data);

        return $pdf->stream('laporan-inventaris-barang.pdf');
    }
}
