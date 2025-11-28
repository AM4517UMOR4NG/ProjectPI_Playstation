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

    <!-- Complete Experience Section -->
    <section id="collection" class="collection-section">
        <div class="section-header">
            <h2>Lengkapi <span class="text-highlight">Pengalaman Gamingmu</span></h2>
            <p>Semua yang kamu butuhkan untuk pengalaman gaming terbaik ada di sini</p>
        </div>

        <div class="tabs-container">
            <div class="tabs-nav">
                <button class="tab-btn active" data-target="units">
                    <i class="fas fa-gamepad"></i> Konsol
                </button>
                <button class="tab-btn" data-target="games">
                    <i class="fas fa-compact-disc"></i> Games
                </button>
                <button class="tab-btn" data-target="accessories">
                    <i class="fas fa-headset"></i> Aksesoris
                </button>
            </div>

            <div class="tab-content active" id="units">
                <div class="features-grid">
                    @forelse($featuredUnits as $unit)
                        <div class="feature-card">
                            <div class="card-image-wrapper">
                                <img src="{{ $unit->foto }}" alt="{{ $unit->nama }}" class="card-image" onerror="this.onerror=null;this.src='https://via.placeholder.com/300x200?text=No+Image';">
                            </div>
                            <div class="card-body">
                                <h3>{{ $unit->nama }}</h3>
                                <p class="price">Rp {{ number_format($unit->harga_per_jam, 0, ',', '.') }} / jam</p>
                                <a href="{{ route('register.show') }}" class="btn-card">Sewa Sekarang</a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Belum ada unit tersedia</div>
                    @endforelse
                </div>
            </div>

            <div class="tab-content" id="games">
                <div class="features-grid">
                    @forelse($featuredGames as $game)
                        <div class="feature-card">
                            <div class="card-image-wrapper">
                                <img src="{{ !empty($game->gambar) ? $game->gambar : 'https://via.placeholder.com/300x400?text=No+Image' }}" alt="{{ $game->judul }}" class="card-image" onerror="this.onerror=null;this.src='https://via.placeholder.com/300x400?text=No+Image';">
                            </div>
                            <div class="card-body">
                                <h3>{{ $game->judul }}</h3>
                                <p class="genre">{{ $game->genre }}</p>
                                <a href="{{ route('register.show') }}" class="btn-card">Sewa Sekarang</a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Belum ada game tersedia</div>
                    @endforelse
                </div>
            </div>

            <div class="tab-content" id="accessories">
                <div class="features-grid">
                    @forelse($featuredAccessories as $accessory)
                        <div class="feature-card">
                            <div class="card-image-wrapper">
                                <img src="{{ !empty($accessory->gambar) ? $accessory->gambar : 'https://via.placeholder.com/300x300?text=No+Image' }}" alt="{{ $accessory->nama }}" class="card-image" onerror="this.onerror=null;this.src='https://via.placeholder.com/300x300?text=No+Image';">
                            </div>
                            <div class="card-body">
                                <h3>{{ $accessory->nama }}</h3>
                                <p class="price">Rp {{ number_format($accessory->harga_sewa, 0, ',', '.') }} / jam</p>
                                <a href="{{ route('register.show') }}" class="btn-card">Sewa Sekarang</a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Belum ada aksesoris tersedia</div>
                    @endforelse
                </div>
            </div>
            
            <div class="cta-container">
                <a href="{{ route('register.show') }}" class="btn-hero btn-primary">
                    <i class="fas fa-rocket"></i> Mulai Sewa Sekarang
                </a>
            </div>
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

    /* Collection Section */
    .collection-section {
        padding: 80px 20px;
        background: #f8f9fa;
        text-align: center;
    }

    .tabs-nav {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 12px 30px;
        border: none;
        background: white;
        color: #666;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        font-size: 1rem;
    }

    .tab-btn.active, .tab-btn:hover {
        background: #00d4ff;
        color: #000428;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3);
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto 50px;
    }

    .feature-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .card-image-wrapper {
        width: 100%;
        height: 220px;
        overflow: hidden;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #f8f9fa;
        transition: transform 0.5s ease;
    }

    .feature-card:hover .card-image {
        transform: scale(1.1);
    }

    .card-body {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .feature-card h3 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #1a1a1a;
    }

    .price {
        color: #00d4ff;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .genre {
        color: #666;
        margin-bottom: 20px;
        font-size: 0.9rem;
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

    .cta-container {
        margin-top: 50px;
    }

    .empty-state {
        grid-column: 1 / -1;
        padding: 40px;
        color: #666;
        font-style: italic;
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
        .tab-btn { width: 100%; margin-bottom: 10px; }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                // Add active class to clicked tab and target content
                tab.classList.add('active');
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>
@endpush