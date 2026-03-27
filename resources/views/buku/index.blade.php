@extends('layout.admin')

@section('content')
<h1>Daftar Buku</h1>
<a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>
<table id="bukuTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Gambar</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($buku as $item)
        <tr>
            <td>{{ $item->judul }}</td>
            <td>
                @if($item->gambar)
                <img src="{{ asset('gambar/'.$item->gambar) }}"
                    style="
                        width:80px;
                        height:100px;
                        object-fit:cover;
                        border-radius:4px;
                        display:block;
                        margin: 0 auto;
                    ">
                @else
                Tidak ada gambar...
                @endif
            </td>
            <td>{{ $item->penulis }}</td>
            <td>{{ $item->penerbit }}</td>
            <td>{{ $item->tahun }}</td>
            <td>{{ $item->stok }}</td>
            <td>
                <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('buku.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Daftar buku belum ada</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#bukuTable').DataTable({
            pageLength: 10
        });
    });
</script>
@endsection