@extends('layout.admin')

@section('content')
<h1>Data Peminjaman</h1>

<table id="transaksiTable" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Judul Buku</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Denda</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transaksi as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->buku->judul ?? '-' }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->tanggal_pinjam }}</td>
            <td>{{ $item->tanggal_kembali ?? '-' }}</td>

            <td>
                <span class="badge bg-{{ $item->status == 'dipinjam' ? 'warning' : 'success' }}">
                    {{ $item->status }}
                </span>
            </td>

            <!-- Denda -->
            <td>
                Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}
                <br>
                @if(($item->denda ?? 0) > 0)
                    <span class="text-danger">Telat</span>
                @else
                    <span class="text-success">Aman</span>
                @endif
            </td>

            <!-- Tombol paksa -->
            <td>
                @if($item->status == 'dipinjam')
                <form action="{{ route('admin.force.kembali', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-danger btn-sm">
                        Paksa Kembalikan
                    </button>
                </form>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Data Peminjaman belum ada</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#transaksiTable').DataTable({
            pageLength: 10
        });
    });
</script>
@endsection