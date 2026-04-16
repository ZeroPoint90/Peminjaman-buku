@extends('layout.admin')

@section('content')
<a href="{{ route('admin.buku.index') }}" class="btn btn-primary mb-3">Batal</a>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control">
            </div>


            <div class="mb-3">
                <label>Penulis</label>
                <input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tahun</label>
                <input type="text" name="tahun" value="{{ $buku->tahun }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="text" name="stok" value="{{ $buku->stok }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</div>
@endsection