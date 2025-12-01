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
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
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
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
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

    body.light-mode .hero-welcome p {
        color: #475569;
    }

    /* Advanced Hero Effects */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }

    .hero-welcome {
        background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #0f172a);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    body.light-mode .hero-welcome {
        background: linear-gradient(-45deg, #eff6ff, #dbeafe, #bfdbfe, #eff6ff);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        border: 1px solid #bfdbfe;
    }

    .shape {
        position: absolute;
        filter: blur(50px);
        z-index: 0;
        opacity: 0.6;
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        top: -10%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.4), transparent);
        animation-delay: 0s;
    }

    .shape-2 {
        bottom: -20%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.4), transparent);
        animation-delay: -2s;
    }

    .shape-3 {
        top: 20%;
        right: 20%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.4), transparent);
        animation-delay: -4s;
    }

    /* Typewriter Cursor */
    .cursor {
        display: inline-block;
        width: 3px;
        height: 1em;
        background-color: #fff;
        animation: blink 1s infinite;
        margin-left: 5px;
        vertical-align: middle;
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }
</style>

<div class="container-fluid">
    <!-- Hero Section -->
    <!-- Hero Section -->
    <div class="text-center py-5 mb-4 rounded-4 position-relative overflow-hidden hero-welcome">
        <!-- Floating Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        
        <div class="position-relative z-1">
            <h2 class="fw-bold display-5 mb-3" style="text-shadow: 0 2px 10px rgba(0,0,0,0.1); min-height: 1.2em;">
                <span id="typewriter"></span><span class="cursor"></span>
            </h2>
            <p class="lead mb-0" style="max-width: 600px; margin: 0 auto; text-shadow: 0 1px 5px rgba(0,0,0,0.1);">
                Temukan pengalaman gaming terbaikmu hari ini. Sewa konsol, game, dan aksesoris dengan mudah dan cepat.
            </p>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-grid" style="opacity: 0.05;"></div>
    </div>

    <!-- Unit PS Section -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0"><i class="bi bi-controller me-2" style="color: #3b82f6;"></i>Unit PlayStation</h4>
            <a href="{{ route('pelanggan.unitps.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Lihat Semua</a>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
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
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
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
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textElement = document.getElementById('typewriter');
        const phrases = [
            "Selamat Datang, {{ Auth::user()->name }}!", 
            "Sewa Konsol PS5 Murah", 
            "Main Game Terbaru Hari Ini", 
            "Upgrade Gear Gaming Kamu",
            "Rasakan Sensasi Next-Gen"
        ];
        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typeSpeed = 100;

        function type() {
            const currentPhrase = phrases[phraseIndex];
            
            if (isDeleting) {
                textElement.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
                typeSpeed = 50;
            } else {
                textElement.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
                typeSpeed = 100;
            }

            if (!isDeleting && charIndex === currentPhrase.length) {
                isDeleting = true;
                typeSpeed = 2000; // Pause at end
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                typeSpeed = 500; // Pause before new phrase
            }

            setTimeout(type, typeSpeed);
        }

        // Start typing
        if(textElement) {
            type();
        }
    });
</script>
@endsection