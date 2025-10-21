<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LokasiController extends Controller implements HasMiddleware
{
    /**
     * Middleware untuk kontrol akses berdasarkan role & permission.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view lokasi', only: ['index', 'show']),
            new Middleware('permission:manage lokasi', except: ['index', 'show']),
        ];
    }

    /**
     * Menampilkan daftar lokasi dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? null;

        $lokasis = Lokasi::with('ketua') // ✅ eager load untuk mencegah N+1 query
            ->when($search, function ($query, $search) {
                $query->where('nama_lokasi', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('lokasi.index', compact('lokasis'));
    }

    /**
     * Menampilkan form tambah lokasi.
     */
    public function create()
    {
        $lokasi = new Lokasi();
        $users = User::orderBy('name')->get(); // ✅ untuk dropdown ketua
        return view('lokasi.create', compact('lokasi', 'users'));
    }

    /**
     * Menyimpan lokasi baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100|unique:lokasis,nama_lokasi',
            'ketua_id' => 'nullable|exists:users,id',
        ]);

        Lokasi::create($validated);

        return redirect()
            ->route('lokasi.index')
            ->with('success', 'Lokasi baru berhasil ditambahkan.');
    }

    /**
     * Halaman show tidak digunakan.
     */
    public function show(Lokasi $lokasi)
    {
        abort(404);
    }

    /**
     * Menampilkan form edit lokasi.
     */
    public function edit(Lokasi $lokasi)
    {
        $users = User::orderBy('name')->get(); // ✅ agar dropdown ketua muncul juga di edit
        return view('lokasi.edit', compact('lokasi', 'users'));
    }

    /**
     * Update lokasi di database.
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100|unique:lokasis,nama_lokasi,' . $lokasi->id,
            'ketua_id' => 'nullable|exists:users,id',
        ]);

        $lokasi->update($validated);

        return redirect()
            ->route('lokasi.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Hapus lokasi jika tidak memiliki relasi barang.
     */
    public function destroy(Lokasi $lokasi)
    {
        if ($lokasi->barang()->exists()) {
            return redirect()
                ->route('lokasi.index')
                ->with('error', 'Lokasi tidak dapat dihapus karena masih memiliki barang terkait.');
        }

        $lokasi->delete();

        return redirect()
            ->route('lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}
