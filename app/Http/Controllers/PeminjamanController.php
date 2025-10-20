<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    private function generateKodePeminjaman()
    {
        do {
            $kode = date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Peminjaman::where('kode_peminjaman', $kode)->exists());
        
        return $kode;
    }
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
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $this->generateKodePeminjaman(),
                'nama_peminjam' => $request->nama_peminjam,
                'telepon_peminjam' => $request->telepon_peminjam,
                'email_peminjam' => $request->email_peminjam,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
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
                    $nama = $barang ? $barang->nama_barang : 'ID:'.$barangId;
                    throw new \Exception("Stok barang '{$nama}' tidak mencukupi.");
                }
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        // Jangan ubah DB di sini. Hanya tambahkan properti "available" pada setiap barang
        $peminjaman->load('details.barang');

        // kumpulkan reserve per barang pada peminjaman ini
        $reserved = [];
        foreach ($peminjaman->details as $detail) {
            $reserved[$detail->barang_id] = ($reserved[$detail->barang_id] ?? 0) + $detail->jumlah;
        }

        $barangs = Barang::orderBy('nama_barang')->get();

        // tambahkan properti available (tidak disimpan ke DB)
        foreach ($barangs as $barang) {
            $borrowed = $reserved[$barang->id] ?? 0;
            // jumlah_baik di DB sudah dikurangi untuk peminjaman ini,
            // jadi untuk tujuan form kita tambahkan kembali jumlah yang dipinjam oleh peminjaman ini saja
            $barang->available = $barang->jumlah_baik + $borrowed;
        }

        return view('peminjaman.edit', compact('peminjaman', 'barangs'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'telepon_peminjam' => 'required|string|max:20',
            'email_peminjam' => 'nullable|email',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $peminjaman) {
            // 1) Buat map jumlah baru (jumlah per barang). Jika ada duplicate row untuk barang yg sama, jumlah dijumlahkan.
            $newQtyMap = [];
            foreach ($request->barang_id as $i => $barangId) {
                $id = (int) $barangId;
                $qty = (int) $request->jumlah[$i];
                if ($qty <= 0) continue;
                if (!isset($newQtyMap[$id])) $newQtyMap[$id] = 0;
                $newQtyMap[$id] += $qty;
            }

            // 2) Ambil detail lama dan keyBy barang_id
            $oldDetails = $peminjaman->details()->get()->keyBy('barang_id');

            // 3) Hitung semua id yang perlu di-handle (union old + new)
            $oldIds = $oldDetails->keys()->all();
            $newIds = array_keys($newQtyMap);
            $allIds = array_values(array_unique(array_merge($oldIds, $newIds)));

            // 4) Sesuaikan stok berdasarkan selisih (new - old)
            foreach ($allIds as $barangId) {
                $barang = Barang::find($barangId);
                if (!$barang) continue;

                $oldQty = isset($oldDetails[$barangId]) ? (int) $oldDetails[$barangId]->jumlah : 0;
                $newQty = isset($newQtyMap[$barangId]) ? (int) $newQtyMap[$barangId] : 0;

                $diff = $newQty - $oldQty;

                if ($diff > 0) {
                    // perlu mengurangi stok sebesar $diff
                    if ($barang->jumlah_baik < $diff) {
                        throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi (tersisa {$barang->jumlah_baik}).");
                    }
                    $barang->decrement('jumlah_baik', $diff);
                } elseif ($diff < 0) {
                    // perlu menambah stok sebesar -$diff (mengembalikan sisa)
                    $barang->increment('jumlah_baik', -$diff);
                }
                // jika diff == 0 → tidak perlu ubah stok
            }

            // 5) Update data peminjaman
            $peminjaman->update($request->only([
                'nama_peminjam',
                'telepon_peminjam',
                'email_peminjam',
                'tanggal_pinjam',
                'tanggal_kembali',
            ]));

            // 6) Reset detail dan masukkan detail baru sesuai $newQtyMap
            $peminjaman->details()->delete();
            foreach ($newQtyMap as $barangId => $qty) {
                $peminjaman->details()->create([
                    'barang_id' => $barangId,
                    'jumlah' => $qty,
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
            if ($barang) {
                $barang->increment('jumlah_baik', $detail->jumlah);
            }
        }

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now()->format('Y-m-d')
        ]);
        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function undoReturn(Peminjaman $peminjaman)
    {
        foreach ($peminjaman->details as $detail) {
            $barang = $detail->barang;
            if ($barang && $barang->jumlah_baik >= $detail->jumlah) {
                $barang->decrement('jumlah_baik', $detail->jumlah);
            }
        }

        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_kembali' => null
        ]);
        return back()->with('success', 'Pengembalian barang dibatalkan.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
