@extends('pelanggan.layout')

@section('pelanggan_content')
<style>
    /* Product Card Styling - Consistent for both modes */
    .product-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.15);
        border-color: #3b82f6;
    }
    
    .product-card .card-img-wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }
    
    .product-card .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .card-img-wrapper img {
        transform: scale(1.05);
    }
    
    .product-card .card-content {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex: 1;
        background: var(--card-bg);
        border-top: 3px solid #3b82f6;
    }
    
    .product-card .product-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
        color: var(--text-main);
    }
    
    .product-card .product-brand {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .product-card .product-price {
        font-weight: 700;
        font-size: 1.1rem;
        color: #3b82f6;
    }
    
    .product-card .product-price span {
        font-weight: 400;
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    
    .product-card .stock-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        background: #3b82f6;
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
    }
    
    .product-card .btn-sewa {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .product-card .btn-sewa:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    /* Light Mode Overrides */
    body.light-mode .product-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    body.light-mode .product-card:hover {
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.12);
        border-color: #3b82f6;
    }
    
    body.light-mode .product-card .card-img-wrapper {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    }
    
    body.light-mode .product-card .card-content {
        background: #ffffff;
    }
    
    body.light-mode .product-card .product-title {
        color: #0f172a;
    }
    
    body.light-mode .product-card .product-brand {
        color: #64748b;
    }
    
    body.light-mode .product-card .product-price {
        color: #2563eb;
    }
    
    body.light-mode .product-card .product-price span {
        color: #64748b;
    }
</style>

<div class="container-fluid">
    <!-- Hero Section -->
    <div class="text-center py-5 mb-4 rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.2)); border: 1px solid var(--card-border);">
        <div class="position-relative z-1">
            <h2 class="fw-bold display-5 mb-3 text-white">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="lead text-muted mb-0" style="max-width: 600px; margin: 0 auto;">
                Temukan pengalaman gaming terbaikmu hari ini. Sewa konsol, game, dan aksesoris dengan mudah dan cepat.
            </p>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-grid" style="opacity: 0.1;"></div>
    </div>

    <!-- Unit PS Section -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0"><i class="bi bi-controller me-2" style="color: #3b82f6;"></i>Unit PlayStation</h4>
            <a href="{{ route('pelanggan.unitps.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Lihat Semua</a>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($unitps as $unit)
                <div class="col">
                    <div class="product-card">
                        <div class="card-img-wrapper">
                            @if($unit->foto)
                                <img src="{{ str_starts_with($unit->foto, 'http') ? $unit->foto : asset('storage/' . $unit->foto) }}" alt="{{ $unit->name }}">
                            @else
                                <img src="https://placehold.co/400x300/1e293b/ffffff?text={{ urlencode($unit->model) }}" alt="{{ $unit->name }}">
                            @endif
                            <span class="stock-badge">{{ $unit->stock ?? 0 }} Unit</span>
                        </div>
                        <div class="card-content">
                            <h5 class="product-title">{{ $unit->name }}</h5>
                            <p class="product-brand">{{ $unit->brand }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="product-price">Rp {{ number_format($unit->price_per_hour, 0, ',', '.') }}<span>/jam</span></div>
                                <a href="{{ route('pelanggan.rentals.create') }}?type=unitps&id={{ $unit->id }}" class="btn-sewa">Sewa</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info bg-opacity-10 border-0 text-info">
                        <i class="bi bi-info-circle me-2"></i>Tidak ada unit PlayStation tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Games Section -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0"><i class="bi bi-disc me-2" style="color: #3b82f6;"></i>Games Populer</h4>
            <a href="{{ route('pelanggan.games.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Lihat Semua</a>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($games as $game)
                <div class="col">
                    <div class="product-card">
                        <div class="card-img-wrapper">
                            @if($game->gambar)
                                <img src="{{ str_starts_with($game->gambar, 'http') ? $game->gambar : asset('storage/' . $game->gambar) }}" alt="{{ $game->judul }}">
                            @else
                                <img src="https://placehold.co/300x400/1e293b/ffffff?text={{ urlencode($game->judul) }}" alt="{{ $game->judul }}">
                            @endif
                            <span class="stock-badge">{{ $game->stok ?? 0 }} Stok</span>
                        </div>
                        <div class="card-content">
                            <h5 class="product-title text-truncate">{{ $game->judul }}</h5>
                            <p class="product-brand">{{ $game->platform }} • {{ $game->genre }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="product-price">Rp {{ number_format($game->harga_per_hari, 0, ',', '.') }}<span>/hari</span></div>
                                <a href="{{ route('pelanggan.rentals.create') }}?type=game&id={{ $game->id }}" class="btn-sewa">Sewa</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info bg-opacity-10 border-0 text-info">
                        <i class="bi bi-info-circle me-2"></i>Tidak ada game tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Accessories Section -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0"><i class="bi bi-headset me-2" style="color: #3b82f6;"></i>Aksesoris</h4>
            <a href="{{ route('pelanggan.accessories.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Lihat Semua</a>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($accessories as $acc)
                <div class="col">
                    <div class="product-card">
                        <div class="card-img-wrapper">
                            @if($acc->gambar)
                                <img src="{{ str_starts_with($acc->gambar, 'http') ? $acc->gambar : asset('storage/' . $acc->gambar) }}" alt="{{ $acc->nama }}">
                            @else
                                <img src="https://placehold.co/400x300/1e293b/ffffff?text={{ urlencode($acc->nama) }}" alt="{{ $acc->nama }}">
                            @endif
                            <span class="stock-badge">{{ $acc->stok ?? 0 }} Stok</span>
                        </div>
                        <div class="card-content">
                            <h5 class="product-title">{{ $acc->nama }}</h5>
                            <p class="product-brand">{{ $acc->jenis }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="product-price">Rp {{ number_format($acc->harga_per_hari, 0, ',', '.') }}<span>/hari</span></div>
                                <a href="{{ route('pelanggan.rentals.create') }}?type=accessory&id={{ $acc->id }}" class="btn-sewa">Sewa</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info bg-opacity-10 border-0 text-info">
                        <i class="bi bi-info-circle me-2"></i>Tidak ada aksesoris tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection