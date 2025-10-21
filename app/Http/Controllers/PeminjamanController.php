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

    public function index(Request $request)
    {
        $query = Peminjaman::with('details.barang');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_peminjam', 'like', "%{$searchTerm}%")
                  ->orWhere('kode_peminjaman', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_pinjam')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal_pinjam);
        }

        if ($request->filled('tanggal_kembali')) {
            $query->whereDate('tanggal_kembali', $request->tanggal_kembali);
        }

        if ($request->filled('lokasi_id')) {
            $query->whereHas('details.barang', function ($q) use ($request) {
                $q->where('lokasi_id', $request->lokasi_id);
            });
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();
        $barangs = Barang::with('lokasi')->orderBy('nama_barang')->get();

        return view('peminjaman.index', compact('peminjamans', 'barangs'));
    }

    public function create()
    {
        $barangs = Barang::with('lokasi')->where('jumlah_baik', '>', 0)->get();
        return view('peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'telepon_peminjam' => 'required|string|max:20',
            'email_peminjam' => 'nullable|email',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => [
                'nullable', 'date', 'after_or_equal:tanggal_pinjam',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value) {
                        $maxDate = date('Y-m-d', strtotime($request->tanggal_pinjam . ' +7 days'));
                        if ($value > $maxDate) {
                            $fail('Tanggal pengembalian tidak boleh lebih dari 7 hari dari tanggal peminjaman.');
                        }
                    }
                },
            ],
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            // validasi alamat
            'alamat_peminjam' => 'nullable|string|max:255',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'rt' => 'nullable|numeric|min:0',
            'rw' => 'nullable|numeric|min:0',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'catatan_alamat' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $this->generateKodePeminjaman(),
                'nama_peminjam' => $request->nama_peminjam,
                'telepon_peminjam' => $request->telepon_peminjam,
                'email_peminjam' => $request->email_peminjam,
                'dusun' => $request->dusun,
                'desa' => $request->desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kecamatan' => $request->kecamatan,
                'kabupaten' => $request->kabupaten,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'catatan_alamat' => $request->catatan_alamat,
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
        $peminjaman->load('details.barang');

        $reserved = [];
        foreach ($peminjaman->details as $detail) {
            $reserved[$detail->barang_id] = ($reserved[$detail->barang_id] ?? 0) + $detail->jumlah;
        }

        $barangs = Barang::with('lokasi')->orderBy('nama_barang')->get();

        foreach ($barangs as $barang) {
            $borrowed = $reserved[$barang->id] ?? 0;
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
            'tanggal_kembali' => [
                'nullable', 'date', 'after_or_equal:tanggal_pinjam',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value) {
                        $maxDate = date('Y-m-d', strtotime($request->tanggal_pinjam . ' +7 days'));
                        if ($value > $maxDate) {
                            $fail('Tanggal pengembalian tidak boleh lebih dari 7 hari dari tanggal peminjaman.');
                        }
                    }
                },
            ],
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            // validasi alamat
            'alamat_peminjam' => 'nullable|string|max:255',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'rt' => 'nullable|numeric|min:0',
            'rw' => 'nullable|numeric|min:0',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'catatan_alamat' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $peminjaman) {
            // Update data utama (termasuk alamat)
            $peminjaman->update($request->only([
                'nama_peminjam',
                'telepon_peminjam',
                'email_peminjam',
                'alamat_peminjam',
                'dusun',
                'desa',
                'rt',
                'rw',
                'kecamatan',
                'kabupaten',
                'provinsi',
                'kode_pos',
                'catatan_alamat',
                'tanggal_pinjam',
                'tanggal_kembali',
            ]) + ['status' => 'Dipinjam']);

            // Sinkronisasi stok barang
            $oldDetails = $peminjaman->details()->get()->keyBy('barang_id');
            $newQtyMap = [];
            foreach ($request->barang_id as $i => $barangId) {
                $id = (int) $barangId;
                $qty = (int) $request->jumlah[$i];
                if ($qty <= 0) continue;
                if (!isset($newQtyMap[$id])) $newQtyMap[$id] = 0;
                $newQtyMap[$id] += $qty;
            }

            $oldIds = $oldDetails->keys()->all();
            $newIds = array_keys($newQtyMap);
            $allIds = array_unique(array_merge($oldIds, $newIds));

            foreach ($allIds as $barangId) {
                $barang = Barang::find($barangId);
                if (!$barang) continue;

                $oldQty = $oldDetails[$barangId]->jumlah ?? 0;
                $newQty = $newQtyMap[$barangId] ?? 0;
                $diff = $newQty - $oldQty;

                if ($diff > 0) {
                    if ($barang->jumlah_baik < $diff) {
                        throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi.");
                    }
                    $barang->decrement('jumlah_baik', $diff);
                } elseif ($diff < 0) {
                    $barang->increment('jumlah_baik', -$diff);
                }
            }

            $peminjaman->details()->delete();
            foreach ($newQtyMap as $barangId => $qty) {
                $peminjaman->details()->create([
                    'barang_id' => $barangId,
                    'jumlah' => $qty,
                ]);
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
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
            'tanggal_kembali' => now()->format('Y-m-d'),
        ]);

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function extendForm(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Dipinjam') {
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman tidak dapat diperpanjang.');
        }

        return view('peminjaman.extend', compact('peminjaman'));
    }

    public function extend(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Dipinjam') {
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman tidak dapat diperpanjang.');
        }

        $request->validate([
            'tanggal_kembali' => [
                'required', 'date', 'after_or_equal:' . $peminjaman->tanggal_pinjam,
                function ($attribute, $value, $fail) use ($peminjaman) {
                    if ($value) {
                        $maxDate = date('Y-m-d', strtotime($peminjaman->tanggal_pinjam . ' +7 days'));
                        if ($value > $maxDate) {
                            $fail('Tanggal pengembalian tidak boleh lebih dari 7 hari dari tanggal peminjaman.');
                        }
                    }
                },
            ],
        ]);

        $peminjaman->update(['tanggal_kembali' => $request->tanggal_kembali]);

        return redirect()->route('peminjaman.index')->with('success', 'Tanggal kembali berhasil diperpanjang.');
    }
}
