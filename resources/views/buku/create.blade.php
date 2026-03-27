@extends('layout.template')

@section('content')
<a href="{{ route('buku.index') }}" class="btn btn-secondary mb-3">Batal</a>

<div class="card">
    <div class="card-body">
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <input type="text" name="judul" class="form-control" placeholder="Judul Buku" required>
            </div>

            <div class="mb-3">
                <input type="text" name="penulis" class="form-control" placeholder="Penulis" required>
            </div>

            <div class="mb-3">
                <input type="text" name="penerbit" class="form-control" placeholder="Penerbit" required>
            </div>

            <div class="mb-3">
                <input type="number" name="tahun" class="form-control" placeholder="Tahun Terbit" required>
            </div>

            <div class="mb-3">
                <input type="number" name="stok" class="form-control" placeholder="Stok Buku" required>
            </div>

            <div class="mb-3">
                <label>Gambar Buku</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>


@endsection