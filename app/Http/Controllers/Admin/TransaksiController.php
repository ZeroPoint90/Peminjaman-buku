<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // LIST TRANSAKSI
    public function index()
    {
        $transaksi = Transaksi::with('buku', 'user')
            // ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('transaksi.index', compact('transaksi'));
    }

    // FORM PINJAM BUKU
    public function create()
    {
        $buku = Buku::where('stok', '>', 0)->get();
        $users = User::all();
        return view('transaksi.create', compact('buku', 'users'));
    }

    // SIMPAN PINJAM
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'jumlah'  => 'required|integer|min:1|max:2',
        ]);

        // $user = User::where('name', $request->nama_user)->first();

        // if (!$user) {
        //     return back()
        //         ->withInput()
        //         ->with('error', 'User tidak ditemukan');
        // }

        $buku = Buku::findOrFail($request->buku_id);

        // kurangi stok
        if ($buku->stok < $request->jumlah) {
            return back()->with('error', 'Stok habis');
        }

        Transaksi::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'jumlah'  => $request->jumlah,
            'tanggal_pinjam' => Carbon::now(),
            'status' => 'dipinjam'
        ]);

        $buku->decrement('stok', $request->jumlah);

        return redirect()->route('transaksi.index')
            ->with('success', 'Buku berhasil dipinjam');
    }

    // PENGEMBALIAN BUKU
    public function update(Transaksi $transaksi)
    {
        if ($transaksi->status === 'dipinjam') {
            $transaksi->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => Carbon::now()
            ]);

            // tambah stok
            $transaksi->buku->increment('stok', $transaksi->jumlah);
        }

        return redirect()->route('transaksi.index');
    }

    // PAKSA PENGEMBALIAN
    public function forceKembalikan($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Kalau sudah dikembalikan
        if ($transaksi->tanggal_kembali) {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        $today = Carbon::now();
        $batas = Carbon::parse($transaksi->tanggal_kembali_rencana);

        $denda = 0;

        if ($today->gt($batas)) {
            $telat = $batas->diffInDays($today);
            $denda = $telat * 5000; // denda: 5000/hari
        }

        $transaksi->update([
            'tanggal_kembali' => $today,
            'status' => 'dikembalikan',
            'denda' => $denda
        ]);

        $transaksi->buku->increment('stok', $transaksi->jumlah);

        return back()->with('success', 'Buku berhasil dikembalikan paksa');
    }

//     public function kembalikan($id)
// {
//     $data = Peminjaman::find($id);

//     $data->tanggal_kembali = now();
//     $data->denda = $this->hitungDenda($data);

//     $data->save();
// }

//     // HITUNG DENDA
//     public function hitungDenda($data)
//     {
//         $today = Carbon::now();
//         $jatuhTempo = Carbon::parse($data->tanggal_kembali_rencana);

//         // kalau sudah dikembalikan
//         if ($data->tanggal_kembali) {
//             $tanggalKembali = Carbon::parse($data->tanggal_kembali);

//             if ($tanggalKembali->gt($jatuhTempo)) {
//                 $hariTelat = $jatuhTempo->diffInDays($tanggalKembali);
//                 return $hariTelat * 5000;
//             }

//             return 0;
//         }

//         // kalau BELUM dikembalikan
//         if ($today->gt($jatuhTempo)) {
//             $hariTelat = $jatuhTempo->diffInDays($today);
//             return $hariTelat * 5000;
//         }

//         return 0;
//     }

    // PENCARIAN
    public function search(Request $request)
    {
        $transaksi = Transaksi::whereHas('buku', function ($q) use ($request) {
            $q->where('judul', 'like', '%' . $request->keyword . '%');
        })->get();

        return view('transaksi.index', compact('transaksi'));
    }
}
