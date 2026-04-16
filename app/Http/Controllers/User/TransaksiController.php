<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.transaksi.index', compact('transaksi'));
    }

    public function kembalikan($id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();

        $transaksi->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => Carbon::now(),
        ]);

        $transaksi->buku->increment('stok', $transaksi->jumlah);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }

public function store(Request $request)
{
    $maxTanggal = Carbon::now()->addDays(7);

    $request->validate([
        'buku_id' => 'required|exists:buku,id',
        'tanggal_kembali_rencana' => 'required|in:2,4,7',
        'jumlah'  => 'required|integer|min:1|max:2',
    ]);

    $buku = Buku::findOrFail($request->buku_id);
    $tanggalPinjam = Carbon::now();
    $tanggalKembali = Carbon::now()->addDays($request->tanggal_kembali_rencana);

    if ($buku->stok < $request->jumlah) {
        return back()->with('error', 'Stok tidak cukup');
    }

    Transaksi::create([
        'user_id' => auth()->id(),
        'buku_id' => $request->buku_id,
        'jumlah'  => $request->jumlah,
        'tanggal_pinjam' => $tanggalPinjam,
        'tanggal_kembali_rencana' => $tanggalKembali,
        'status' => 'dipinjam'
    ]);

    $buku->decrement('stok', $request->jumlah);

    return back()->with('success', 'Buku berhasil dipinjam');
}
}
