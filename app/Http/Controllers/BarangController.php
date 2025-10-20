<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\SumberDana;
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
        $kategori_id = $request->kategori_id;
        $sumberdana_id = $request->sumberdana_id;
        $kondisi = $request->kondisi;

        $barangs = Barang::with(['kategori', 'lokasi', 'sumberdana'])
            ->when($search, function ($query, $search) {
                $query->where('nama_barang', 'like', "%$search%")
                      ->orWhere('kode_barang', 'like', "%$search%");
            })
            ->when($kategori_id, function ($query, $kategori_id) {
                $query->where('kategori_id', $kategori_id);
            })
            ->when($sumberdana_id, function ($query, $sumberdana_id) {
                $query->where('sumberdana_id', $sumberdana_id);
            })
            ->when($kondisi, function ($query, $kondisi) {
                switch ($kondisi) {
                    case 'baik':
                        $query->where('jumlah_baik', '>', 0);
                        break;
                    case 'rusak_ringan':
                        $query->where('jumlah_rusak_ringan', '>', 0);
                        break;
                    case 'rusak_berat':
                        $query->where('jumlah_rusak_berat', '>', 0);
                        break;
                    case 'kosong':
                        $query->where('jumlah_baik', 0)
                              ->where('jumlah_rusak_ringan', 0)
                              ->where('jumlah_rusak_berat', 0);
                        break;
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Get filter options
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $sumberdanas = SumberDana::orderBy('nama_sumberdana')->get();

        return view('barang.index', compact('barangs', 'search', 'kategori_id', 'sumberdana_id', 'kondisi', 'kategoris', 'sumberdanas'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();
        $sumberdana = SumberDana::all();
        $barang = new Barang();

        return view('barang.create', compact('barang', 'kategori', 'lokasi', 'sumberdana'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang'          => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang'          => 'required|string|max:150',
            'kategori_id'          => 'required|exists:kategoris,id',
            'lokasi_id'            => 'required|exists:lokasis,id',
            'sumberdana_id'        => 'required|exists:sumberdanas,id',
            'satuan'               => 'required|string|max:20',
            'jumlah_baik'          => 'required|integer|min:0',
            'jumlah_rusak_ringan'  => 'required|integer|min:0',
            'jumlah_rusak_berat'   => 'required|integer|min:0',
            'tanggal_pengadaan'    => 'required|date',
            'gambar'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hitung total jumlah
        $validated['jumlah'] =
            ($validated['jumlah_baik'] ?? 0) +
            ($validated['jumlah_rusak_ringan'] ?? 0) +
            ($validated['jumlah_rusak_berat'] ?? 0);

        // Upload gambar (jika ada)
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('', 'gambar-barang');
        }

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi', 'sumberdana']);
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();
        $sumberdana = SumberDana::all();

        return view('barang.edit', compact('barang', 'kategori', 'lokasi', 'sumberdana'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang'          => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'          => 'required|string|max:150',
            'kategori_id'          => 'required|exists:kategoris,id',
            'lokasi_id'            => 'required|exists:lokasis,id',
            'sumberdana_id'        => 'required|exists:sumberdanas,id',
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
            // Hapus gambar lama
            if ($barang->gambar) {
                Storage::disk('gambar-barang')->delete($barang->gambar);
            }
            // Simpan gambar baru
            $validated['gambar'] = $request->file('gambar')->store('', 'gambar-barang');
        }

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            Storage::disk('gambar-barang')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }

    public function cetakLaporan()
    {
        $barangs = Barang::with(['kategori', 'lokasi', 'sumberdana'])->get();

        $data = [
            'title' => 'Laporan Data Barang Inventaris',
            'date'  => date('d F Y'),
            'barangs' => $barangs,
        ];

        $pdf = Pdf::loadView('barang.laporan', $data);
        return $pdf->stream('laporan-inventaris-barang.pdf');
    }
}
