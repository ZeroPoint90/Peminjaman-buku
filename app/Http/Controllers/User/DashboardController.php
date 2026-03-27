<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalBuku = Buku::count();

        $dipinjam = Transaksi::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->with('buku')
            ->get();

        $totalDipinjam = $dipinjam->sum('jumlah');

        return view('user.dashboard', compact(
            'totalBuku',
            'totalDipinjam',
            'dipinjam'
        ));
    }
}
