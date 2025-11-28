@extends('pemilik.layout')
@section('title', 'Item Rusak')
@section('owner_content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Item Rusak</h2>
        <p class="text-muted mb-0">Daftar item yang dilaporkan rusak oleh kasir</p>
    </div>
    <a href="{{ route('pemilik.status_produk') }}" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #ffffff !important;">{{ $stats['total'] }}</h3>
                <small style="color: rgba(255,255,255,0.9) !important;">Total Item Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #ffffff !important;">{{ $stats['units'] }}</h3>
                <small style="color: rgba(255,255,255,0.9) !important;">Unit PS Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%);">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #ffffff !important;">{{ $stats['games'] }}</h3>
                <small style="color: rgba(255,255,255,0.9) !important;">Game Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1" style="color: #ffffff !important;">{{ $stats['accessories'] }}</h3>
                <small style="color: rgba(255,255,255,0.9) !important;">Aksesoris Rusak</small>
            </div>
        </div>
    </div>
</div>

<!-- ==================== TABEL UNIT PS RUSAK ==================== -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header border-0 d-flex align-items-center" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
        <i class="bi bi-controller me-2" style="color: #ffffff;"></i>
        <h5 class="mb-0" style="color: #ffffff;">Unit PS Rusak ({{ $stats['units'] }})</h5>
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
    <div class="card-header border-0 d-flex align-items-center" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%);">
        <i class="bi bi-disc me-2" style="color: #ffffff;"></i>
        <h5 class="mb-0" style="color: #ffffff;">Game Rusak ({{ $stats['games'] }})</h5>
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
    <div class="card-header border-0 d-flex align-items-center" style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);">
        <i class="bi bi-headset me-2" style="color: #ffffff;"></i>
        <h5 class="mb-0" style="color: #ffffff;">Aksesoris Rusak ({{ $stats['accessories'] }})</h5>
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
