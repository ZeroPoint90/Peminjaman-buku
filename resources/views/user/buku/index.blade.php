@extends('layout.user')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Buku</h1>

    <div class="row">
        @forelse ($buku as $book)
        <form action="{{ route('user.pinjam') }}" method="POST">
            @csrf

            <input type="hidden" name="buku_id" value="{{ $book->id }}">

            <p>Stok: {{ $book->stok }}</p>

            <input type="number"
                name="jumlah"
                min="1"
                max="2"
                value="1"
                class="form-control mb-2">

            <button type="submit"
                class="btn btn-primary w-100"
                {{ $book->stok == 0 ? 'disabled' : '' }}>
                Pinjam
            </button>
        </form>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <img
                    src="{{ asset('gambar/' . $book->gambar) }}"
                    class="card-img-top"
                    alt="{{ $book->judul }}"
                    style="height: 250px; object-fit: cover;">

                <div class="card-body text-center">
                    <h6 class="card-title">{{ $book->judul }}</h6>
                </div>
            </div>
        </div>
        @empty
        <p>Tidak ada buku.</p>
        @endforelse
    </div>
</div>
@endsection