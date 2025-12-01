@extends('pemilik.layout')
@section('title', 'Item Rusak')
@section('owner_content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle me-2"></i>Item Rusak</h2>
        <p class="text-muted mb-0">Daftar item yang dilaporkan rusak oleh kasir</p>
    </div>
    <a href="{{ route('pemilik.status_produk') }}" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: #ffffff; border: 1px solid #e9ecef;">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #212529 !important;">{{ $stats['total'] }}</h3>
                <small class="text-muted">Total Item Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: #ffffff; border: 1px solid #e9ecef;">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #212529 !important;">{{ $stats['units'] }}</h3>
                <small class="text-muted">Unit PS Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: #ffffff; border: 1px solid #e9ecef;">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #212529 !important;">{{ $stats['games'] }}</h3>
                <small class="text-muted">Game Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: #ffffff; border: 1px solid #e9ecef;">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #212529 !important;">{{ $stats['accessories'] }}</h3>
                <small class="text-muted">Aksesoris Rusak</small>
            </div>
        </div>
    </div>
</div>

<!-- ==================== TABEL UNIT PS RUSAK ==================== -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header border-0 d-flex align-items-center bg-light">
        <i class="bi bi-controller me-2 text-dark"></i>
        <h5 class="mb-0 text-dark">Unit PS Rusak ({{ $stats['units'] }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Nama Unit</th>
                    <th>Model</th>
                    <th>Kondisi</th>
                    <th>Tanggal Laporan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($damagedUnitsFromRentals as $item)
                <tr>
                    <td><code class="bg-light px-2 py-1 rounded">{{ $item->rental->kode ?? '-' }}</code></td>
                    <td>{{ $item->rental->customer->name ?? 'N/A' }}</td>
                    <td class="fw-bold">{{ $item->rentable->name ?? $item->rentable->nama ?? 'N/A' }}</td>
                    <td>{{ $item->rentable->model ?? '-' }}</td>
                    <td><span class="badge bg-danger">Rusak</span></td>
                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle text-success me-2"></i>Tidak ada Unit PS yang rusak
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ==================== TABEL GAME RUSAK ==================== -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header border-0 d-flex align-items-center bg-light">
        <i class="bi bi-disc me-2 text-dark"></i>
        <h5 class="mb-0 text-dark">Game Rusak ({{ $stats['games'] }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Judul Game</th>
                    <th>Platform</th>
                    <th>Kondisi</th>
                    <th>Tanggal Laporan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($damagedGamesFromRentals as $item)
                <tr>
                    <td><code class="bg-light px-2 py-1 rounded">{{ $item->rental->kode ?? '-' }}</code></td>
                    <td>{{ $item->rental->customer->name ?? 'N/A' }}</td>
                    <td class="fw-bold">{{ $item->rentable->judul ?? 'N/A' }}</td>
                    <td>{{ $item->rentable->platform ?? '-' }}</td>
                    <td><span class="badge bg-danger">Rusak</span></td>
                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle text-success me-2"></i>Tidak ada Game yang rusak
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ==================== TABEL AKSESORIS RUSAK ==================== -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header border-0 d-flex align-items-center bg-light">
        <i class="bi bi-headset me-2 text-dark"></i>
        <h5 class="mb-0 text-dark">Aksesoris Rusak ({{ $stats['accessories'] }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Nama Aksesoris</th>
                    <th>Jenis</th>
                    <th>Kondisi</th>
                    <th>Tanggal Laporan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($damagedAccessoriesFromRentals as $item)
                <tr>
                    <td><code class="bg-light px-2 py-1 rounded">{{ $item->rental->kode ?? '-' }}</code></td>
                    <td>{{ $item->rental->customer->name ?? 'N/A' }}</td>
                    <td class="fw-bold">{{ $item->rentable->nama ?? 'N/A' }}</td>
                    <td>{{ $item->rentable->jenis ?? '-' }}</td>
                    <td><span class="badge bg-danger">Rusak</span></td>
                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle text-success me-2"></i>Tidak ada Aksesoris yang rusak
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($stats['total'] == 0)
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-check-circle text-success display-1 mb-3"></i>
        <h4>Semua Item dalam Kondisi Baik!</h4>
        <p class="text-muted mb-0">Tidak ada item yang dilaporkan rusak saat pengembalian.</p>
    </div>
</div>
@endif

@endsection
