@extends('pemilik.layout')
@section('title','Laporan Pendapatan')
@section('owner_content')

<style>
/* Light Mode Fixes untuk Laporan Pendapatan */
body.light-mode .card[style*="rgba(30, 41, 59, 0.7)"] {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    border: 1px solid #cbd5e1 !important;
}

body.light-mode .card[style*="rgba(30, 41, 59, 0.7)"] .text-white {
    color: #1e293b !important;
}

body.light-mode .card[style*="rgba(30, 41, 59, 0.7)"] .text-muted {
    color: #64748b !important;
}

body.light-mode .modal-content.bg-dark {
    background: #ffffff !important;
    color: #1e293b !important;
    border: 1px solid #e2e8f0 !important;
}

body.light-mode .modal-content.bg-dark .text-white {
    color: #1e293b !important;
}

body.light-mode .modal-content.bg-dark .text-muted {
    color: #64748b !important;
}

body.light-mode .modal-content.bg-dark .form-control.bg-dark {
    background: #ffffff !important;
    color: #1e293b !important;
    border-color: #cbd5e1 !important;
}

body.light-mode .modal-content.bg-dark .border-secondary {
    border-color: #e2e8f0 !important;
}

body.light-mode .table thead.bg-light.bg-opacity-10 {
    background: #f8fafc !important;
}

body.light-mode .table .text-white {
    color: #1e293b !important;
}
</style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-white mb-1">Laporan Pendapatan</h2>
            <p class="text-muted mb-0">Analisis detail pendapatan bisnis Anda.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-calendar-range me-2"></i>Filter Tanggal
            </button>
            <a href="{{ route('pemilik.laporan_pendapatan.export', ['dari' => request('dari'), 'sampai' => request('sampai')]) }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid var(--card-border);">
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Pendapatan</p>
                    <h4 class="fw-bold text-white mb-0">Rp {{ number_format($revenueStats['total'] ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid var(--card-border);">
                <div class="card-body">
                    <p class="text-muted small mb-1">Hari Ini</p>
                    <h4 class="fw-bold text-success mb-0">+ Rp {{ number_format($revenueStats['today'] ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid var(--card-border);">
                <div class="card-body">
                    <p class="text-muted small mb-1">Bulan Ini</p>
                    <h4 class="fw-bold text-info mb-0">Rp {{ number_format($revenueStats['month'] ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid var(--card-border);">
                <div class="card-body">
                    <p class="text-muted small mb-1">{{ $periodLabel ?? '7 Hari Terakhir' }}</p>
                    <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($revenueStats['filtered'] ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chart -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <h5 class="fw-bold text-white mb-1">Grafik Pendapatan</h5>
            <p class="text-muted small mb-0">Tren pendapatan - {{ $periodLabel ?? '7 Hari Terakhir' }}</p>
        </div>
        <div class="card-body px-4 pb-4">
            <div style="height: 350px;">
                <canvas id="revChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Payments Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <h5 class="fw-bold text-white mb-1">Riwayat Pembayaran Masuk</h5>
            <p class="text-muted small mb-0">Daftar pembayaran yang diterima dari pelanggan</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-10">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-muted fw-semibold">ID Pembayaran</th>
                            <th class="px-4 py-3 text-muted fw-semibold">Pelanggan</th>
                            <th class="px-4 py-3 text-muted fw-semibold">Metode</th>
                            <th class="px-4 py-3 text-muted fw-semibold text-end">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($revenueList as $payment)
                            <tr>
                                <td class="px-4 py-3 text-white">
                                    {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-monospace text-muted">#{{ $payment->id }}</span>
                                </td>
                                <td class="px-4 py-3 text-white">
                                    {{ $payment->rental->customer->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-muted">
                                    {{ ucfirst($payment->payment_type ?? 'Manual') }}
                                </td>
                                <td class="px-4 py-3 fw-bold text-success text-end">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Belum ada data pembayaran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-top border-secondary border-opacity-25">
                {{ $revenueList->links() }}
            </div>
        </div>
    </div>

    <!-- Date Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="filterModalLabel">
                        <i class="bi bi-calendar-range me-2 text-primary"></i>Filter Tanggal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('pemilik.laporan_pendapatan') }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="dari" class="form-label text-muted small">Dari Tanggal</label>
                                <input type="date" class="form-control bg-dark text-white border-secondary" 
                                       id="dari" name="dari" value="{{ $dari ?? '' }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="sampai" class="form-label text-muted small">Sampai Tanggal</label>
                                <input type="date" class="form-control bg-dark text-white border-secondary" 
                                       id="sampai" name="sampai" value="{{ $sampai ?? '' }}" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="text-muted small mb-2">Quick Select:</p>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setDateRange(7)">7 Hari</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setDateRange(30)">30 Hari</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setDateRange(90)">90 Hari</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <a href="{{ route('pemilik.laporan_pendapatan') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check-circle me-1"></i>Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Quick date range selector
        function setDateRange(days) {
            const today = new Date();
            const fromDate = new Date();
            fromDate.setDate(today.getDate() - (days - 1));
            
            document.getElementById('dari').value = fromDate.toISOString().split('T')[0];
            document.getElementById('sampai').value = today.toISOString().split('T')[0];
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Set chart colors based on theme
            const isLightMode = document.body.classList.contains('light-mode');
            
            if (isLightMode) {
                Chart.defaults.color = '#475569';
                Chart.defaults.borderColor = 'rgba(71, 85, 105, 0.2)';
            } else {
                Chart.defaults.color = '#94a3b8';
                Chart.defaults.borderColor = 'rgba(148, 163, 184, 0.1)';
            }
            
            const revCtx = document.getElementById('revChart');
            if (revCtx) {
                const chartConfig = {
                    type: 'line',
                    data: {
                        labels: @json($revLabels ?? []),
                        datasets: [{
                            label: 'Pendapatan',
                            data: @json($revData ?? []),
                            borderColor: '#10b981',
                            backgroundColor: isLightMode ? 'rgba(16, 185, 129, 0.15)' : 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: isLightMode ? '#ffffff' : '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isLightMode ? '#ffffff' : '#1e293b',
                                titleColor: isLightMode ? '#1e293b' : '#fff',
                                bodyColor: isLightMode ? '#475569' : '#cbd5e1',
                                borderColor: isLightMode ? '#e2e8f0' : 'transparent',
                                borderWidth: isLightMode ? 1 : 0,
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { borderDash: [4, 4] },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(value);
                                    }
                                }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                };
                
                new Chart(revCtx, chartConfig);
            }
        });
    </script>
@endsection
