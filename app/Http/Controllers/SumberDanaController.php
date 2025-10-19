<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SumberDanaController extends Controller implements HasMiddleware
{
    /**
     * Middleware untuk kontrol akses berdasarkan role & permission.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view sumberdana', only: ['index', 'show']),
            new Middleware('permission:manage sumberdana', except: ['index', 'show']),
        ];
    }

    /**
     * Menampilkan daftar sumber dana dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $sumberdanas = SumberDana::when($search, function ($query, $search) {
                $query->where('nama_sumberdana', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('sumberdana.index', compact('sumberdanas'));
    }

    /**
     * Menampilkan form tambah sumber dana.
     */
    public function create()
    {
        $sumberdana = new SumberDana();
        return view('sumberdana.create', compact('sumberdana'));
    }

    /**
     * Menyimpan sumber dana baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sumberdana' => 'required|string|max:100|unique:sumberdanas,nama_sumberdana',
        ]);

        SumberDana::create($validated);

        return redirect()
            ->route('sumberdana.index')
            ->with('success', 'Sumber Dana baru berhasil ditambahkan.');
    }

    /**
     * Halaman show tidak digunakan.
     */
    public function show(SumberDana $sumberdana)
    {
        abort(404);
    }

    /**
     * Menampilkan form edit sumber dana.
     */
    public function edit(SumberDana $sumberdana)
    {
        return view('sumberdana.edit', compact('sumberdana'));
    }

    /**
     * Update sumber dana di database.
     */
    public function update(Request $request, SumberDana $sumberdana)
    {
        $validated = $request->validate([
            'nama_sumberdana' => 'required|string|max:100|unique:sumberdanas,nama_sumberdana,' . $sumberdana->id,
        ]);

        $sumberdana->update($validated);

        return redirect()
            ->route('sumberdana.index')
            ->with('success', 'Sumber Dana berhasil diperbarui.');
    }

    /**
     * Hapus sumber dana jika tidak memiliki relasi barang.
     */
    public function destroy(SumberDana $sumberdana)
    {
        if ($sumberdana->barang()->exists()) {
            return redirect()
                ->route('sumberdana.index')
                ->with('error', 'Sumber Dana tidak dapat dihapus karena masih memiliki barang terkait.');
        }

        $sumberdana->delete();

        return redirect()
            ->route('sumberdana.index')
            ->with('success', 'Sumber Dana berhasil dihapus.');
    }
}
