<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Kategori;
use App\Models\Lokasi;

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
        'kode_barang'       => 'required|string|max:50|unique:barangs,kode_barang',
        'nama_barang'       => 'required|string|max:150',
        'kategori_id'       => 'required|exists:kategoris,id',
        'lokasi_id'         => 'required|exists:lokasis,id',
        'jumlah'            => 'required|integer|min:0',
        'satuan'            => 'required|string|max:20',
        'kondisi'           => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        'tanggal_pengadaan' => 'required|date',
        'gambar'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        //
    }
}
