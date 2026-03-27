<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('buku_id')
                ->constrained('buku')
                ->onDelete('cascade');

            $table->integer('jumlah')->default(1);

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana')->nullable();
            $table->date('tanggal_kembali')->nullable();

            $table->enum('status', ['dipinjam', 'dikembalikan'])
                ->default('dipinjam');

            $table->integer('denda')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
