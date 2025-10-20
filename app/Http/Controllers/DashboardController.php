<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\SumberDana;

class DashboardController extends Controller
{
    public function index()
    {
    // Total barang = jumlah record barang (hitung ID barang yang ada)
    $jumlahBarang = Barang::count();

        $jumlahKategori = Kategori::count();
        $jumlahLokasi   = Lokasi::count();
        $jumlahUser     = User::count();
        $jumlahSumberDana = SumberDana::count();
        $jumlahPeminjaman = Peminjaman::count();
        
        // Hitung jumlah per kondisi
        $kondisiBaik        = Barang::sum('jumlah_baik');
        $kondisiRusakRingan = Barang::sum('jumlah_rusak_ringan');
        $kondisiRusakBerat  = Barang::sum('jumlah_rusak_berat');

        // Barang terbaru (opsional untuk ditampilkan di dashboard)
        $barangTerbaru = Barang::with(['kategori', 'lokasi'])
            ->latest()
            ->take(5)
            ->get();

        // Data untuk kartu peminjaman terakhir
        $barangDipinjam = Peminjaman::with(['details.barang'])
            ->latest()
            ->take(5)
            ->get();

        // Barang yang harus segera dikembalikan (3 hari sebelum tanggal kembali)
        $tanggalTigaHariLagi = now()->addDays(3)->format('Y-m-d');
        $barangHarusKembali = Peminjaman::with(['details.barang'])
            ->where('status', 'Dipinjam')
            ->where('tanggal_kembali', '<=', $tanggalTigaHariLagi)
            ->where('tanggal_kembali', '>=', now()->format('Y-m-d'))
            ->latest('tanggal_kembali')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'jumlahBarang',
            'jumlahKategori',
            'jumlahLokasi',
            'jumlahUser',
            'jumlahSumberDana',
            'jumlahPeminjaman',
            'kondisiBaik',
            'kondisiRusakRingan',
            'kondisiRusakBerat',
            'barangTerbaru',
            'barangDipinjam',
            'barangHarusKembali'
        ));
    }
}
