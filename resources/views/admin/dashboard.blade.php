@extends('layout.admin')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Statistik Peminjaman (7 Hari Terakhir)
        </h6>
    </div>
    <div class="card-body">
        <canvas id="chartTransaksi" height="100"></canvas>
    </div>
</div>

<div class="card shadow mt-4">
    <div class="card-header">
        <strong>Data Peminjaman Terbaru</strong>
    </div>

    <div class="card-body">
        <table id="memberTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $item)
                <tr>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->buku->judul ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status == 'dipinjam' ? 'warning' : 'success' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
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
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow mt-4">
    <div class="card-header">
        <strong>Grafik Stok Buku Saat Ini</strong>
    </div>
    <div class="card-body">
        <canvas id="stokChart"></canvas>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const labels = @json($labels ?? []);
        const dipinjam = @json($dipinjam ?? []);
        const dikembalikan = @json($dikembalikan ?? []);

        const ctx = document.getElementById('chartTransaksi');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Dipinjam',
                        data: dipinjam,
                        backgroundColor: '#4e73df'
                    },
                    {
                        label: 'Dikembalikan',
                        data: dikembalikan,
                        backgroundColor: '#1cc88a'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        ticks: {
                            stepSize: 2
                        }
                    }
                }
            }
        });

    });
</script>

<script>
    const stokCtx = document.getElementById('stokChart');

    new Chart(stokCtx, {
        type: 'bar',
        data: {
            labels: @json($stokLabels),
            datasets: [{
                label: 'Jumlah Stok',
                data: @json($stokData),
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 100,
                    ticks: {
                        stepSize: 20
                    }
                }
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#memberTable').DataTable({
            pageLength: 10
        });
    });
</script>

@endsection