@extends('layout.template')

@section('content')
<a href="{{ route('transaksi.index') }}" class="btn btn-secondary mb-3">Batal</a>

<div class="card">
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-3">
                <label>User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Buku</label>
                <select name="buku_id" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($buku as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->judul }} (stok: {{ $item->stok }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Jumlah (maks 2)</label>
                <input type="number"
                    name="jumlah"
                    class="form-control"
                    min="1"
                    max="2"
                    value="1"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">
                Pinjam Buku
            </button>
        </form>
    </div>
</div>

@endsection