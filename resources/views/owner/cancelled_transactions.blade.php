@extends('pemilik.layout')
@section('title', 'Transaksi Dibatalkan')
@section('owner_content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-white mb-1"><i class="bi bi-x-circle text-danger me-2"></i>Transaksi Dibatalkan</h2>
        <p class="text-muted mb-0">Daftar semua transaksi yang dibatalkan</p>
    </div>
    <a href="{{ route('pemilik.laporan_transaksi') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Tanggal Dibuat</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $rental)
                <tr>
                    <td><code class="fw-bold">{{ $rental->kode }}</code></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-25 text-danger rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                {{ substr($rental->customer->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $rental->customer->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $rental->customer->email ?? '' }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="fw-bold">Rp {{ number_format($rental->total, 0, ',', '.') }}</td>
                    <td>
                        <div>{{ $rental->created_at->format('d/m/Y') }}</div>
                        <small class="text-muted">{{ $rental->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <small class="text-muted">{{ $rental->notes ?? '-' }}</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="bi bi-check-circle text-success display-1 mb-3 d-block"></i>
                        <h5 class="text-white">Tidak Ada Transaksi Dibatalkan</h5>
                        <p class="text-muted mb-0">Semua transaksi berjalan dengan baik.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($rentals->hasPages())
    <div class="card-footer bg-transparent border-0 py-3">
        {{ $rentals->links() }}
    </div>
    @endif
</div>

@endsection
