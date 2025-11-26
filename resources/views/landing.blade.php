@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i> Pilihan #1 Gamers
            </div>
            <h1>Rasakan Sensasi Gaming <br><span class="text-highlight">Tanpa Batas!</span></h1>
            <p>Sewa konsol PlayStation 4 & 5 terbaru dengan harga terjangkau. <br>Siap antar ke rumah Anda, 24/7.</p>
            <div class="hero-buttons">
                <a href="{{ route('register.show') }}" class="btn-hero btn-primary">
                    <i class="fas fa-gamepad"></i> Sewa Sekarang
                </a>
                <a href="#featured" class="btn-hero btn-secondary">
                    Lihat Unit
                </a>
            </div>
        </div>
    </header>

    <!-- Featured Units Section (Highlight) -->
    <section id="featured" class="featured-section">
        <div class="section-header">
            <h2>Unit <span class="text-highlight">Unggulan</span></h2>
            <p>Pilih konsol favoritmu dan mulai bermain hari ini</p>
        </div>
        
        <div class="features-grid">
            @forelse($featuredUnits as $unit)
                <div class="feature-card {{ $loop->first ? 'highlight-card' : '' }}">
                    @if($loop->first)
                        <div class="card-badge">Best Choice</div>
                    @endif
                    
                    <div class="card-image-wrapper">
                        <img src="{{ $unit->foto }}" alt="{{ $unit->nama }}" class="card-image">
                    </div>
                    
                    <h3>{{ $unit->nama }}</h3>
                    <p class="price">Rp {{ number_format($unit->harga_per_jam, 0, ',', '.') }} / jam</p>
                    
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Kondisi: {{ ucfirst($unit->kondisi) }}</li>
                        <li><i class="fas fa-check"></i> Serial: {{ $unit->nomor_seri }}</li>
                        <li><i class="fas fa-check"></i> Ready Stock</li>
                    </ul>
                    <a href="{{ route('register.show') }}" class="btn-card">Sewa Sekarang</a>
                </div>
            @empty
                <!-- Fallback if no units found -->
                <div class="feature-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?auto=format&fit=crop&w=800&q=80" alt="PlayStation 5" class="card-image">
                    </div>
                    <h3>PlayStation 5</h3>
                    <p class="price">Mulai Rp 150.000 / hari</p>
                    <a href="{{ route('register.show') }}" class="btn-card">Sewa PS5</a>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Features/Benefits Section -->
    <section class="benefits-section">
        <div class="features-grid">
            <div class="benefit-item">
                <i class="fas fa-truck-fast"></i>
                <h3>Pengiriman Cepat</h3>
                <p>Unit diantar dalam waktu kurang dari 2 jam.</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-wallet"></i>
                <h3>Harga Terbaik</h3>
                <p>Tarif kompetitif dengan paket hemat mingguan.</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-headset"></i>
                <h3>Support 24/7</h3>
                <p>Bantuan teknis siap sedia kapanpun Anda butuh.</p>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Inline styles for quick implementation of new design elements */
    .hero {
        background: linear-gradient(135deg, #000428 0%, #004e92 100%);
        color: white;
        padding: 100px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 16px;
        border-radius: 50px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .text-highlight {
        color: #00d4ff; /* Cyan highlight */
        text-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
    }

    .hero p {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 40px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .btn-hero {
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .btn-primary {
        background: #00d4ff;
        color: #000428;
        box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
    }

    .btn-primary:hover {
        background: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 212, 255, 0.6);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Featured Section */
    .featured-section {
        padding: 80px 20px;
        background: #f8f9fa;
        text-align: center;
    }

    .section-header {
        margin-bottom: 60px;
    }

    .section-header h2 {
        font-size: 2.5rem;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .highlight-card {
        border: 2px solid #00d4ff;
        transform: scale(1.05);
    }

    .highlight-card:hover {
        transform: scale(1.05) translateY(-10px);
    }

    .card-badge {
        position: absolute;
        top: 20px;
        right: -35px;
        background: #00d4ff;
        color: #000428;
        padding: 5px 40px;
        transform: rotate(45deg);
        font-weight: bold;
        font-size: 0.8rem;
    }

    .card-icon {
        font-size: 3rem;
        color: #004e92;
        margin-bottom: 20px;
    }

    .card-image-wrapper {
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .feature-card:hover .card-image {
        transform: scale(1.1);
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #1a1a1a;
    }

    .price {
        color: #00d4ff;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
        text-align: left;
    }

    .feature-list li {
        margin-bottom: 10px;
        color: #666;
    }

    .feature-list i {
        color: #00d4ff;
        margin-right: 10px;
    }

    .btn-card {
        display: block;
        width: 100%;
        padding: 12px;
        background: #004e92;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .btn-card:hover {
        background: #003366;
    }

    /* Benefits Section */
    .benefits-section {
        padding: 60px 20px;
        background: white;
    }

    .benefit-item {
        text-align: center;
        padding: 20px;
    }

    .benefit-item i {
        font-size: 2.5rem;
        color: #00d4ff;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .hero h1 { font-size: 2.5rem; }
        .highlight-card { transform: none; }
        .highlight-card:hover { transform: translateY(-10px); }
    }
</style>
@endpush