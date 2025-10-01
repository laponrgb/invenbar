<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBarang   = Barang::sum('jumlah'); // total barang semua kondisi
        $jumlahKategori = Kategori::count();
        $jumlahLokasi   = Lokasi::count();
        $jumlahUser     = User::count();

        // Hitung per kondisi
        $kondisiBaik        = Barang::sum('jumlah_baik');
        $kondisiRusakRingan = Barang::sum('jumlah_rusak_ringan');
        $kondisiRusakBerat  = Barang::sum('jumlah_rusak_berat');

        $barangTerbaru = Barang::with(['kategori', 'lokasi'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'jumlahBarang',
            'jumlahKategori',
            'jumlahLokasi',
            'jumlahUser',
            'kondisiBaik',
            'kondisiRusakRingan',
            'kondisiRusakBerat',
            'barangTerbaru'
        ));
    }
}
