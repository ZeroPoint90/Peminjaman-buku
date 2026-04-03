@extends('layout.user')

@section('content')

<h1>Transaksi Saya</h1>

<table id="transaksiTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Judul Buku</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Denda</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($transaksi as $item)
        <tr>
            <td>{{ $item->buku->judul }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->status_label }}</td>
            <td>
                Rp {{ number_format($item->denda_realtime, 0, ',', '.') }}
            </td>
            <td>
                @if($item->status == 'dipinjam')
                <form action="{{ route('user.transaksi.kembalikan', $item->id) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm btn-success">
                        Kembalikan
                    </button>
                </form>
                @else
                <span class="badge bg-success">Sudah Dikembalikan</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Belum ada transaksi
            </td>
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