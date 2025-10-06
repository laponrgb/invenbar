<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('details.barang')->latest()->paginate(10);
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $barangs = Barang::where('jumlah_baik', '>', 0)->get();
        return view('peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'telepon_peminjam' => 'required|string|max:20',
            'email_peminjam' => 'nullable|email',
            'tanggal_pinjam' => 'required|date',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'nama_peminjam' => $request->nama_peminjam,
                'telepon_peminjam' => $request->telepon_peminjam,
                'email_peminjam' => $request->email_peminjam,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'status' => 'Dipinjam',
            ]);

            foreach ($request->barang_id as $i => $barangId) {
                $jumlah = (int) $request->jumlah[$i];
                $barang = Barang::find($barangId);

                if ($barang && $barang->jumlah_baik >= $jumlah) {
                    $barang->decrement('jumlah_baik', $jumlah);
                    PeminjamanDetail::create([
                        'peminjaman_id' => $peminjaman->id,
                        'barang_id' => $barangId,
                        'jumlah' => $jumlah,
                    ]);
                } else {
                    throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi.");
                }
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        // Kembalikan stok sementara agar stok real terbaca di form
        foreach ($peminjaman->details as $detail) {
            $barang = $detail->barang;
            if ($barang) {
                $barang->jumlah_baik += $detail->jumlah;
                $barang->save();
            }
        }

        $peminjaman->load('details.barang');
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('peminjaman.edit', compact('peminjaman', 'barangs'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'telepon_peminjam' => 'required|string|max:20',
            'email_peminjam' => 'nullable|email',
            'tanggal_pinjam' => 'required|date',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $peminjaman) {
            // 🔹 1. Kembalikan stok lama
            foreach ($peminjaman->details as $detail) {
                $barang = $detail->barang;
                if ($barang) {
                    $barang->increment('jumlah_baik', $detail->jumlah);
                }
            }

            // 🔹 2. Hapus semua detail lama
            $peminjaman->details()->delete();

            // 🔹 3. Update data utama
            $peminjaman->update($request->only([
                'nama_peminjam',
                'telepon_peminjam',
                'email_peminjam',
                'tanggal_pinjam',
            ]));

            // 🔹 4. Kurangi stok untuk detail baru
            foreach ($request->barang_id as $i => $barangId) {
                $jumlah = (int) $request->jumlah[$i];
                $barang = Barang::find($barangId);

                if (!$barang) continue;

                if ($barang->jumlah_baik < $jumlah) {
                    throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi (tersisa {$barang->jumlah_baik}).");
                }

                $barang->decrement('jumlah_baik', $jumlah);

                $peminjaman->details()->create([
                    'barang_id' => $barangId,
                    'jumlah' => $jumlah,
                ]);
            }
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui dan stok disinkronisasi.');
    }

    public function return(Peminjaman $peminjaman)
    {
        foreach ($peminjaman->details as $detail) {
            $barang = $detail->barang;
            $barang->increment('jumlah_baik', $detail->jumlah);
        }

        $peminjaman->update(['status' => 'Dikembalikan']);
        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function undoReturn(Peminjaman $peminjaman)
    {
        foreach ($peminjaman->details as $detail) {
            $barang = $detail->barang;
            if ($barang->jumlah_baik >= $detail->jumlah) {
                $barang->decrement('jumlah_baik', $detail->jumlah);
            }
        }

        $peminjaman->update(['status' => 'Dipinjam']);
        return back()->with('success', 'Pengembalian barang dibatalkan.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
