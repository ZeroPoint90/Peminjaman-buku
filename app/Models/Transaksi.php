<?php

namespace App\Models;

use App\Models\User;
use App\Models\Buku;
use App\Http\Controllers\Admin\TransaksiController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'buku_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali',
        'status',
        'denda',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali_rencana' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function getDendaRealtimeAttribute()
    {
        if ($this->status == 'dikembalikan') {
            return $this->denda ?? 0;
        }

        if (!$this->tanggal_kembali_rencana) {
            return 0;
        }

        $today = Carbon::now();
        $batas = $this->tanggal_kembali_rencana;

        if ($today->gt($batas)) {
            $telat = $batas->diffInDays($today);
            return $telat * 5000;
        }

        return 0;
    }

    public function getStatusLabelAttribute()
    {
        if ($this->status == 'dikembalikan') {
            return 'Dikembalikan';
        }

        if ($this->tanggal_kembali_rencana && now()->gt($this->tanggal_kembali_rencana)) {
            return 'Terlambat';
        }

        return 'Dipinjam';
    }
}
