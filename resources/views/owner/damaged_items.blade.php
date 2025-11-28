@extends('pemilik.layout')
@section('title', 'Item Rusak')
@section('owner_content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-white mb-1"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Item Rusak</h2>
        <p class="text-muted mb-0">Daftar item yang dilaporkan rusak oleh kasir</p>
    </div>
    <a href="{{ route('pemilik.status_produk') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 bg-danger bg-opacity-25">
            <div class="card-body text-center">
                <h3 class="fw-bold text-danger mb-0">{{ $stats['total'] }}</h3>
                <small class="text-muted">Total Item Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-primary bg-opacity-25">
            <div class="card-body text-center">
                <h3 class="fw-bold text-primary mb-0">{{ $stats['units'] }}</h3>
                <small class="text-muted">Unit PS Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-warning bg-opacity-25">
            <div class="card-body text-center">
                <h3 class="fw-bold text-warning mb-0">{{ $stats['games'] }}</h3>
                <small class="text-muted">Game Rusak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-info bg-opacity-25">
            <div class="card-body text-center">
                <h3 class="fw-bold text-info mb-0">{{ $stats['accessories'] }}</h3>
                <small class="text-muted">Aksesoris Rusak</small>
            </div>
        </div>
    </div>
</div>

<!-- Unit PS Rusak -->
@if($damagedUnits->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-danger bg-opacity-10 border-0">
        <h5 class="mb-0 text-white"><i class="bi bi-controller me-2"></i>Unit PS Rusak ({{ $damagedUnits->count() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Model</th>
                    <th>Nomor Seri</th>
                    <th>Kondisi</th>
                    <th>Terakhir Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($damagedUnits as $unit)
                <tr>
                    <td>#{{ $unit->id }}</td>
                    <td class="fw-bold">{{ $unit->name ?? $unit->nama }}</td>
                    <td>{{ $unit->model }}</td>
                    <td><code>{{ $unit->serial_number ?? $unit->nomor_seri ?? '-' }}</code></td>
                    <td><span class="badge bg-danger">{{ ucfirst($unit->kondisi) }}</span></td>
                    <td>{{ $unit->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Games Rusak -->
@if($damagedGames->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-warning bg-opacity-10 border-0">
        <h5 class="mb-0 text-white"><i class="bi bi-disc me-2"></i>Game Rusak ({{ $damagedGames->count() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Platform</th>
                    <th>Genre</th>
                    <th>Kondisi</th>
                    <th>Terakhir Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($damagedGames as $game)
                <tr>
                    <td>#{{ $game->id }}</td>
                    <td class="fw-bold">{{ $game->judul }}</td>
                    <td>{{ $game->platform }}</td>
                    <td>{{ $game->genre }}</td>
                    <td><span class="badge bg-danger">{{ ucfirst($game->kondisi) }}</span></td>
                    <td>{{ $game->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Aksesoris Rusak -->
@if($damagedAccessories->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-info bg-opacity-10 border-0">
        <h5 class="mb-0 text-white"><i class="bi bi-headset me-2"></i>Aksesoris Rusak ({{ $damagedAccessories->count() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Kondisi</th>
                    <th>Terakhir Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($damagedAccessories as $acc)
                <tr>
                    <td>#{{ $acc->id }}</td>
                    <td class="fw-bold">{{ $acc->nama }}</td>
                    <td>{{ $acc->jenis }}</td>
                    <td><span class="badge bg-danger">{{ ucfirst($acc->kondisi) }}</span></td>
                    <td>{{ $acc->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Item Rusak dari Pengembalian -->
@if($damagedFromRentals->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-secondary bg-opacity-10 border-0">
        <h5 class="mb-0 text-white"><i class="bi bi-arrow-return-left me-2"></i>Dilaporkan Rusak saat Pengembalian ({{ $damagedFromRentals->count() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Item</th>
                    <th>Kondisi Kembali</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($damagedFromRentals as $item)
                <tr>
                    <td><code>{{ $item->rental->kode ?? '-' }}</code></td>
                    <td>{{ $item->rental->customer->name ?? 'N/A' }}</td>
                    <td class="fw-bold">
                        @if($item->rentable)
                            {{ $item->rentable->name ?? $item->rentable->nama ?? $item->rentable->judul ?? 'Item #'.$item->rentable_id }}
                        @else
                            Item tidak ditemukan
                        @endif
                    </td>
                    <td><span class="badge bg-danger">{{ ucfirst($item->kondisi_kembali) }}</span></td>
                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if($stats['total'] == 0 && $damagedFromRentals->count() == 0)
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-check-circle text-success display-1 mb-3"></i>
        <h4 class="text-white">Tidak Ada Item Rusak</h4>
        <p class="text-muted">Semua item dalam kondisi baik.</p>
    </div>
</div>
@endif

@endsection
