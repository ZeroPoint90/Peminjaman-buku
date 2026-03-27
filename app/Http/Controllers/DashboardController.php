<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate   = now()->endOfDay();

        // ===== DATA DIPINJAM =====
        $dataPinjam = Transaksi::selectRaw("
        DATE(tanggal_pinjam) as tanggal,
        SUM(jumlah) as total
    ")
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->where('status', 'dipinjam')
            ->groupByRaw("DATE(tanggal_pinjam)")
            ->get();

        // ===== DATA DIKEMBALIKAN =====
        $dataKembali = Transaksi::selectRaw("
        DATE(tanggal_kembali) as tanggal,
        SUM(jumlah) as total
    ")
            ->whereBetween('tanggal_kembali', [$startDate, $endDate])
            ->where('status', 'dikembalikan')
            ->groupByRaw("DATE(tanggal_kembali)")
            ->get();

        // Label 7 hari terakhir
        $labels = collect();
        for ($i = 6; $i >= 0; $i--) {
            $labels->push(now()->subDays($i)->format('Y-m-d'));
        }

        $dipinjam = [];
        $dikembalikan = [];

        foreach ($labels as $tanggal) {
            $dipinjam[] = $dataPinjam
                ->where('tanggal', $tanggal)
                ->sum('total');

            $dikembalikan[] = $dataKembali
                ->where('tanggal', $tanggal)
                ->sum('total');
        }

        $labels = $labels->map(function ($tgl) {
            return \Carbon\Carbon::parse($tgl)->format('d M');
        });

        $transaksiTerbaru = Transaksi::with('user', 'buku')
            ->latest()
            ->take(10)
            ->get();

            // Data untuk grafik stok buku
        $buku = Buku::all();

        $stokLabels = $buku->pluck('judul');
        $stokData   = $buku->pluck('stok');

        return view('admin.dashboard', compact(
            'labels',
            'dipinjam',
            'dikembalikan',
            'transaksiTerbaru',
            'stokLabels',
            'stokData'
        ));
    }
}
