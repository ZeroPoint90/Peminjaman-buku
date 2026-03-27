@extends('layout.user')

@section('content')
<h1>Dashboard User</h1>
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-center shadow">
            <div class="card-body">
                <h5>Total Buku</h5>
                <h2>{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center shadow">
            <div class="card-body">
                <h5>Buku Dipinjam</h5>
                <h2>{{ $totalDipinjam }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <strong>Daftar Buku yang Sedang Dipinjam</strong>
    </div>

    <div class="card-body">
        <table id="dipinjamTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Buku</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dipinjam as $item)
                <tr>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ $item->jumlah }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">
                        Belum ada buku dipinjam
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dipinjamTable').DataTable({
            pageLength: 10
        });
    });
</script>
@endsection