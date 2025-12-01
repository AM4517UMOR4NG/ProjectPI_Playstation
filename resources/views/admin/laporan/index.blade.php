@extends('admin.layout')
@section('title','Laporan - Admin')
@section('admin_content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h1 class="h3 m-0 fw-bold text-white">
                <i class="bi bi-graph-up-arrow me-2 text-primary"></i>Laporan
            </h1>
            <p class="text-muted mb-0 small">Ringkasan kinerja bisnis Anda</p>
        </div>
    </div>

    <!-- Revenue Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="premium-glass-card h-100 animate-slide-up" style="animation-delay: 0.1s">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="icon-box bg-primary-subtle text-primary">
                                <i class="bi bi-calendar-day"></i>
                            </div>
                            <span class="badge bg-dark border border-secondary text-secondary-emphasis rounded-pill px-3">Hari Ini</span>
                        </div>
                        <div class="metric-value">Rp {{ number_format($revenueToday ?? 0, 0, ',', '.') }}</div>
                        <div class="metric-label text-muted">Pendapatan Hari Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-glass-card h-100 animate-slide-up" style="animation-delay: 0.2s">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="icon-box bg-primary-subtle text-primary">
                                <i class="bi bi-calendar-month"></i>
                            </div>
                            <span class="badge bg-dark border border-secondary text-secondary-emphasis rounded-pill px-3">Bulan Ini</span>
                        </div>
                        <div class="metric-value">Rp {{ number_format($revenueMonth ?? 0, 0, ',', '.') }}</div>
                        <div class="metric-label text-muted">Pendapatan Bulan Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-glass-card h-100 animate-slide-up" style="animation-delay: 0.3s">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="icon-box bg-primary-subtle text-primary">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <span class="badge bg-dark border border-secondary text-secondary-emphasis rounded-pill px-3">Total</span>
                        </div>
                        <div class="metric-value">Rp {{ number_format($revenueTotal ?? 0, 0, ',', '.') }}</div>
                        <div class="metric-label text-muted">Total Pendapatan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card animate-slide-up" style="animation-delay: 0.4s">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-small text-primary">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $rentalsTotal ?? 0 }}</div>
                            <div class="stat-label">Total Transaksi</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card animate-slide-up" style="animation-delay: 0.5s">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-small text-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $rentalsActive ?? 0 }}</div>
                            <div class="stat-label">Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card animate-slide-up" style="animation-delay: 0.6s">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-small text-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $rentalsReturned ?? 0 }}</div>
                            <div class="stat-label">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card animate-slide-up" style="animation-delay: 0.7s">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-small text-danger">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $rentalsCancelled ?? 0 }}</div>
                            <div class="stat-label">Dibatalkan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments Table -->
        <div class="premium-glass-card animate-slide-up" style="animation-delay: 0.8s">
            <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-white">
                        <i class="bi bi-cash-stack me-2 text-primary"></i>Pembayaran Terbaru
                    </h6>
                    <span class="badge bg-primary-subtle text-primary rounded-pill">{{ count($latestPayments ?? []) }} Transaksi</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Customer</th>
                            <th>Metode</th>
                            <th class="text-end pe-4">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($latestPayments ?? []) as $index => $pay)
                        <tr style="animation-delay: {{ 0.8 + ($index * 0.05) }}s">
                            <td class="ps-4">
                                <span class="text-secondary-emphasis font-monospace small">{{ ($pay->paid_at ?? $pay->transaction_time ?? $pay->created_at)?->format('d M Y H:i') }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-xs bg-dark rounded-circle d-flex align-items-center justify-content-center text-primary border border-secondary border-opacity-25">
                                        {{ substr($pay->rental?->customer?->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-white fw-medium">{{ $pay->rental?->customer?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-dark border border-secondary text-secondary-emphasis fw-normal">
                                    {{ strtoupper($pay->method ?? '-') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="text-success fw-bold">Rp {{ number_format($pay->amount ?? 0, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-6 d-block mb-3 opacity-50"></i>
                                    Belum ada pembayaran
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Cancelled Transactions -->
        @if(($rentalsCancelled ?? 0) > 0)
        <div class="premium-glass-card animate-slide-up mt-4" style="animation-delay: 0.9s">
            <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-white">
                        <i class="bi bi-x-circle me-2 text-danger"></i>Transaksi Dibatalkan
                    </h6>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">{{ $rentalsCancelled ?? 0 }} Transaksi</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Kode</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th class="text-end pe-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($cancelledRentals ?? []) as $rental)
                        <tr>
                            <td class="ps-4">
                                <code class="text-danger bg-danger-subtle px-2 py-1 rounded">{{ $rental->kode }}</code>
                            </td>
                            <td>
                                <span class="text-white">{{ $rental->customer->name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="text-secondary-emphasis font-monospace small">{{ $rental->updated_at->format('d M Y H:i') }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="text-danger fw-bold">Rp {{ number_format($rental->total ?? 0, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Tidak ada transaksi dibatalkan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
@endsection

@push('styles')
<style>
    /* Premium Glass Theme */
    :root {
        --glass-bg: rgba(17, 25, 40, 0.75);
        --glass-border: rgba(255, 255, 255, 0.08);
        --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        --primary-glow: rgba(99, 102, 241, 0.15);
    }

    .premium-glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        box-shadow: var(--glass-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .premium-glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.5px;
        margin-bottom: 0.25rem;
    }

    .metric-label {
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Stat Cards */
    .stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .stat-icon-small {
        font-size: 1.5rem;
        opacity: 0.9;
    }

    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Table Styling */
    .premium-table {
        --bs-table-bg: transparent;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.03);
    }

    .premium-table thead th {
        background: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.6);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--glass-border);
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .premium-table tbody td {
        border-bottom: 1px solid var(--glass-border);
        color: rgba(255, 255, 255, 0.8);
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .avatar-xs {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Animations */
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-slide-up {
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) backwards;
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Light Mode Overrides */
    body.light-mode {
        --glass-bg: #ffffff;
        --glass-border: #e2e8f0;
        --glass-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    body.light-mode .premium-glass-card {
        background: #ffffff;
    }
    
    body.light-mode .metric-value,
    body.light-mode .stat-value,
    body.light-mode .text-white {
        color: #0f172a !important;
    }
    
    body.light-mode .text-muted,
    body.light-mode .stat-label,
    body.light-mode .premium-table thead th {
        color: #64748b !important;
    }
    
    body.light-mode .stat-card {
        background: #f8fafc;
        border-color: #e2e8f0;
    }
    
    body.light-mode .stat-card:hover {
        background: #f1f5f9;
    }
    
    body.light-mode .premium-table tbody td {
        color: #334155;
        border-bottom-color: #e2e8f0;
    }
    
    body.light-mode .premium-table {
        --bs-table-hover-bg: #f8fafc;
    }
</style>
@endpush
