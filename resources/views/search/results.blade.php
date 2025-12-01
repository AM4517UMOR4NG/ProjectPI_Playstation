@extends('pelanggan.layout')

@section('title', 'Hasil Pencarian - ' . $query)

@section('header_title', 'Pencarian')

@section('pelanggan_content')
<div class="search-page">
    <!-- Floating Orbs Background -->
    <div class="search-bg-effects">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <!-- Search Hero Section -->
    <div class="search-hero-section">
        <div class="search-hero-glass">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <a href="{{ route('dashboard.pelanggan') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Animated Icon -->
            <div class="search-icon-wrapper">
                <div class="search-icon-ring"></div>
                <div class="search-icon-ring ring-2"></div>
                <div class="search-icon-core">
                    <i class="bi bi-search"></i>
                </div>
            </div>

            @if($query)
                <div class="search-result-info">
                    <span class="result-count">{{ $totalResults }}</span>
                    <span class="result-text">hasil ditemukan untuk</span>
                    <h1 class="result-query">"{{ $query }}"</h1>
                </div>
            @else
                <h1 class="search-title">Temukan Produk Impian</h1>
                <p class="search-subtitle">Cari unit PlayStation, game, dan aksesoris dengan mudah</p>
            @endif

            <!-- Search Input -->
            <form method="GET" action="{{ route('search') }}" class="search-form">
                <div class="search-input-group">
                    <div class="search-input-container">
                        <i class="bi bi-search input-icon"></i>
                        <input type="text" 
                               name="q" 
                               value="{{ $query }}" 
                               class="search-input-field" 
                               placeholder="Ketik untuk mencari..."
                               autocomplete="off"
                               autofocus>
                        @if($query)
                            <a href="{{ route('search') }}" class="clear-btn">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="search-btn">
                        <span class="btn-text">Cari</span>
                        <i class="bi bi-arrow-right btn-icon"></i>
                    </button>
                </div>
            </form>

            <!-- Semantic Tags -->
            @if(!empty($expandedTerms) && count($expandedTerms) > 1)
                <div class="semantic-section">
                    <div class="semantic-header">
                        <div class="semantic-icon">
                            <i class="bi bi-stars"></i>
                        </div>
                        <span>Pencarian Terkait</span>
                    </div>
                    <div class="semantic-chips">
                        @foreach(array_slice($expandedTerms, 0, 8) as $term)
                            <a href="{{ route('search', ['q' => $term]) }}" class="semantic-chip">
                                {{ $term }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>



    @if($totalResults === 0 && $query)
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-illustration">
                <div class="empty-circle"></div>
                <div class="empty-circle inner"></div>
                <i class="bi bi-search-heart"></i>
                <div class="floating-particles">
                    <span></span><span></span><span></span>
                </div>
            </div>
            <h2 class="empty-title">Oops! Tidak ada hasil</h2>
            <p class="empty-desc">
                Kami tidak menemukan "<strong>{{ $query }}</strong>" di katalog kami.<br>
                Coba kata kunci lain atau jelajahi kategori berikut:
            </p>
            <div class="empty-actions">
                <a href="{{ route('pelanggan.unitps.index') }}" class="empty-action-card">
                    <div class="action-icon unit-icon">
                        <i class="bi bi-controller"></i>
                    </div>
                    <span>Unit PS</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="{{ route('pelanggan.games.index') }}" class="empty-action-card">
                    <div class="action-icon game-icon">
                        <i class="bi bi-disc"></i>
                    </div>
                    <span>Games</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="{{ route('pelanggan.accessories.index') }}" class="empty-action-card">
                    <div class="action-icon acc-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <span>Aksesoris</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

    @elseif($totalResults > 0)
        <!-- Filter Section -->
        @php
            $typeGroups = $results->groupBy('type');
        @endphp
        <div class="filter-section">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">
                    <div class="tab-icon all-icon">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                    <div class="tab-info">
                        <span class="tab-label">Semua</span>
                        <span class="tab-count">{{ $totalResults }}</span>
                    </div>
                </button>
                @if($typeGroups->has('unit'))
                    <button class="filter-tab" data-filter="unit">
                        <div class="tab-icon unit-icon">
                            <i class="bi bi-controller"></i>
                        </div>
                        <div class="tab-info">
                            <span class="tab-label">Unit PS</span>
                            <span class="tab-count">{{ $typeGroups['unit']->count() }}</span>
                        </div>
                    </button>
                @endif
                @if($typeGroups->has('game'))
                    <button class="filter-tab" data-filter="game">
                        <div class="tab-icon game-icon">
                            <i class="bi bi-disc"></i>
                        </div>
                        <div class="tab-info">
                            <span class="tab-label">Games</span>
                            <span class="tab-count">{{ $typeGroups['game']->count() }}</span>
                        </div>
                    </button>
                @endif
                @if($typeGroups->has('accessory'))
                    <button class="filter-tab" data-filter="accessory">
                        <div class="tab-icon acc-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div class="tab-info">
                            <span class="tab-label">Aksesoris</span>
                            <span class="tab-count">{{ $typeGroups['accessory']->count() }}</span>
                        </div>
                    </button>
                @endif
            </div>
        </div>

        <!-- Results Grid -->
        <div class="results-container">
            @foreach($results as $index => $item)
                <article class="product-card" data-type="{{ $item['type'] }}" style="--delay: {{ $index * 0.05 }}s">
                    <div class="card-visual">
                        @if($item['image'])
                            @if(Str::startsWith($item['image'], ['http://', 'https://']))
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="card-image" style="width: 100% !important; height: 100% !important; object-fit: cover !important; object-position: center !important; display: block !important;">
                            @else
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}" class="card-image" style="width: 100% !important; height: 100% !important; object-fit: cover !important; object-position: center !important; display: block !important;">
                            @endif
                        @else
                            <div class="card-placeholder {{ $item['type'] }}">
                                <i class="bi {{ $item['icon'] }}"></i>
                            </div>
                        @endif
                        
                        <div class="card-badge {{ $item['type'] }}">
                            <i class="bi {{ $item['icon'] }}"></i>
                            {{ $item['type_label'] }}
                        </div>

                        @if(isset($item['relevance_score']) && $item['relevance_score'] >= 50)
                            <div class="relevance-indicator">
                                <i class="bi bi-stars"></i>
                                <span>Top Match</span>
                            </div>
                        @endif

                        <div class="card-overlay">
                            <a href="{{ $item['url'] }}" class="btn-view">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title">{{ $item['title'] }}</h3>
                        <p class="card-meta">{{ $item['subtitle'] }}</p>
                        
                        <div class="card-stock">
                            <span class="stock-indicator {{ $item['description'] ? 'available' : 'unavailable' }}"></span>
                            {{ $item['description'] }}
                        </div>

                        <div class="card-footer">
                            <div class="price-block">
                                <span class="price-label">Harga Sewa</span>
                                <div class="price-value">
                                    <span class="currency">Rp</span>
                                    <span class="amount">{{ number_format($item['price'], 0, ',', '.') }}</span>
                                    <span class="unit">{{ $item['price_label'] }}</span>
                                </div>
                            </div>
                            <a href="{{ $item['url'] }}" class="btn-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

    @else
        <!-- Initial State -->
        <div class="initial-state">
            <div class="initial-visual">
                <div class="visual-ring"></div>
                <div class="visual-ring ring-2"></div>
                <div class="visual-ring ring-3"></div>
                <i class="bi bi-search"></i>
            </div>
            <h2 class="initial-title">Mulai Pencarian Anda</h2>
            <p class="initial-desc">Temukan unit PS, game terbaru, dan aksesoris gaming terbaik</p>
            
            <div class="popular-searches">
                <span class="popular-label">Pencarian Populer:</span>
                <div class="popular-tags">
                    <a href="{{ route('search', ['q' => 'ps5']) }}" class="popular-tag">
                        <i class="bi bi-controller"></i> PS5
                    </a>
                    <a href="{{ route('search', ['q' => 'fifa 24']) }}" class="popular-tag">
                        <i class="bi bi-disc"></i> FIFA 24
                    </a>
                    <a href="{{ route('search', ['q' => 'stik ps4']) }}" class="popular-tag">
                        <i class="bi bi-joystick"></i> Stik PS4
                    </a>
                    <a href="{{ route('search', ['q' => 'god of war']) }}" class="popular-tag">
                        <i class="bi bi-fire"></i> God of War
                    </a>
                </div>
            </div>

            <!-- Category Cards -->
            <div class="category-cards">
                <a href="{{ route('pelanggan.unitps.index') }}" class="category-card unit">
                    <div class="category-bg"></div>
                    <div class="category-icon">
                        <i class="bi bi-controller"></i>
                    </div>
                    <h4>Unit PlayStation</h4>
                    <p>Sewa konsol PS3, PS4, & PS5</p>
                </a>
                <a href="{{ route('pelanggan.games.index') }}" class="category-card game">
                    <div class="category-bg"></div>
                    <div class="category-icon">
                        <i class="bi bi-disc"></i>
                    </div>
                    <h4>Games</h4>
                    <p>Koleksi game terbaru & populer</p>
                </a>
                <a href="{{ route('pelanggan.accessories.index') }}" class="category-card accessory">
                    <div class="category-bg"></div>
                    <div class="category-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>Aksesoris</h4>
                    <p>Controller, VR, & Headset</p>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* ==========================================
       SEARCH PAGE - ULTRA MODERN DESIGN
       ========================================== */
    .search-page { position: relative; min-height: 80vh; padding-bottom: 3rem; }
    
    /* Floating Orbs */
    .search-bg-effects { position: fixed; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
    .orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.3; animation: float 20s infinite ease-in-out; }
    .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, #3b82f6 0%, transparent 70%); top: -10%; right: -10%; }
    .orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, #8b5cf6 0%, transparent 70%); bottom: 10%; left: -10%; animation-delay: -7s; }
    .orb-3 { width: 300px; height: 300px; background: radial-gradient(circle, #22c55e 0%, transparent 70%); top: 40%; right: 20%; animation-delay: -14s; }
    @keyframes float { 0%, 100% { transform: translate(0, 0); } 33% { transform: translate(30px, -30px); } 66% { transform: translate(-20px, 20px); } }

    /* Hero Section */
    .search-hero-section { position: relative; z-index: 1; margin-bottom: 2.5rem; }
    .search-hero-glass { 
        background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('{{ asset("images/playstation-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        backdrop-filter: blur(10px); 
        border: 1px solid rgba(255,255,255,0.08); 
        border-radius: 24px; 
        padding: 2.5rem; 
        text-align: center; 
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #94a3b8;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        font-size: 0.9rem;
    }
    .btn-back:hover { color: #f8fafc; transform: translateX(-3px); }

    /* Animated Icon */
    .search-icon-wrapper { position: relative; width: 70px; height: 70px; margin: 0 auto 1.5rem; }
    .search-icon-ring { position: absolute; inset: 0; border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 50%; animation: pulse-ring 2s infinite; }
    .search-icon-ring.ring-2 { animation-delay: 1s; }
    .search-icon-core { position: absolute; inset: 12px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4); }
    @keyframes pulse-ring { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(1.6); opacity: 0; } }

    /* Result Info */
    .search-result-info { margin-bottom: 2rem; }
    .result-count { font-size: 3.5rem; font-weight: 800; background: linear-gradient(135deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: block; line-height: 1; margin-bottom: 0.5rem; }
    .result-text { color: #94a3b8; font-size: 1rem; display: block; margin-bottom: 0.5rem; }
    .result-query { color: #f8fafc; font-weight: 700; font-size: 1.5rem; margin: 0; }

    .search-title { font-size: 2.5rem; font-weight: 800; background: linear-gradient(135deg, #f8fafc, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.75rem; }
    .search-subtitle { color: #64748b; font-size: 1.1rem; margin-bottom: 2rem; }

    /* Search Form */
    .search-form { max-width: 650px; margin: 0 auto; }
    .search-input-group { display: flex; gap: 0.75rem; background: rgba(15, 23, 42, 0.6); padding: 0.5rem; border-radius: 18px; border: 1px solid rgba(148, 163, 184, 0.15); transition: all 0.3s; }
    .search-input-group:focus-within { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); background: rgba(15, 23, 42, 0.8); }
    
    .search-input-container { flex: 1; position: relative; display: flex; align-items: center; padding: 0 1rem; }
    .input-icon { color: #64748b; font-size: 1.25rem; margin-right: 1rem; }
    .search-input-field { flex: 1; background: transparent; border: none; outline: none; color: #f8fafc; font-size: 1.1rem; padding: 0.75rem 0; font-weight: 500; }
    .search-input-field::placeholder { color: #64748b; font-weight: 400; }
    
    .clear-btn { color: #64748b; padding: 0.5rem; border-radius: 50%; transition: all 0.2s; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; }
    .clear-btn:hover { color: #ef4444; background: rgba(239, 68, 68, 0.1); }
    
    .search-btn { display: flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; border-radius: 12px; padding: 0 1.75rem; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s; white-space: nowrap; height: 54px; }
    .search-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4); filter: brightness(1.1); }

    /* Semantic Section */
    .semantic-section { margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(148, 163, 184, 0.1); }
    .semantic-header { display: inline-flex; align-items: center; gap: 0.5rem; color: #94a3b8; font-size: 0.85rem; margin-bottom: 1rem; font-weight: 500; }
    .semantic-icon { width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; color: #3b82f6; }
    .semantic-chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.6rem; }
    .semantic-chip { background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(148, 163, 184, 0.2); color: #94a3b8; padding: 0.4rem 0.9rem; border-radius: 20px; font-size: 0.85rem; text-decoration: none; transition: all 0.2s; }
    .semantic-chip:hover { background: rgba(59, 130, 246, 0.1); border-color: #3b82f6; color: #3b82f6; transform: translateY(-2px); }

    /* Filter Section */
    .filter-section { position: relative; z-index: 1; margin-bottom: 2rem; overflow-x: auto; padding-bottom: 0.5rem; }
    .filter-tabs { display: flex; gap: 1rem; min-width: min-content; }
    .filter-tab { display: flex; align-items: center; gap: 0.875rem; background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(148, 163, 184, 0.15); border-radius: 16px; padding: 0.75rem 1.25rem; color: #94a3b8; cursor: pointer; transition: all 0.3s; min-width: 140px; }
    .filter-tab:hover { background: rgba(59, 130, 246, 0.05); border-color: rgba(59, 130, 246, 0.3); transform: translateY(-2px); }
    .filter-tab.active { background: linear-gradient(135deg, #3b82f6, #2563eb); border-color: transparent; color: white; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3); }
    .tab-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.3s; }
    .tab-icon.all-icon { background: rgba(139, 92, 246, 0.15); color: #a78bfa; }
    .tab-icon.unit-icon { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    .tab-icon.game-icon { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
    .tab-icon.acc-icon { background: rgba(234, 179, 8, 0.15); color: #facc15; }
    .filter-tab.active .tab-icon { background: rgba(255,255,255,0.2); color: white; }
    .tab-info { display: flex; flex-direction: column; align-items: flex-start; }
    .tab-label { font-weight: 600; font-size: 0.9rem; }
    .tab-count { font-size: 0.75rem; opacity: 0.8; }

    /* Results Grid - Horizontal Layout */
    .results-container { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem; }
    .product-card { 
        background: rgba(30, 41, 59, 0.7); 
        backdrop-filter: blur(12px); 
        border: 1px solid rgba(148, 163, 184, 0.1); 
        border-radius: 20px; 
        overflow: hidden; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        animation: cardIn 0.5s ease forwards; 
        animation-delay: var(--delay); 
        opacity: 0; 
        display: flex; 
        flex-direction: row !important; /* Horizontal Layout */
        height: 130px;
        align-items: stretch;
    }
    @keyframes cardIn { to { opacity: 1; transform: translateY(0); } from { opacity: 0; transform: translateY(20px); } }
    .product-card:hover { 
        transform: translateY(-5px) scale(1.01); 
        border-color: rgba(59, 130, 246, 0.4); 
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(59, 130, 246, 0.1); 
        background: rgba(30, 41, 59, 0.85);
    }

    /* Card Visual - Left Side */
    .card-visual { 
        position: relative; 
        width: 110px !important; 
        height: 100% !important; 
        overflow: hidden !important; 
        flex-shrink: 0 !important; 
        background: #0f172a; 
        border-right: 1px solid rgba(148, 163, 184, 0.1);
        border-bottom: none !important;
        display: block !important;
    }
    .card-image { 
        width: 100% !important; 
        height: 100% !important; 
        object-fit: cover !important; 
        object-position: center !important; 
        transition: transform 0.6s ease; 
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width: none !important;
        max-height: none !important;
    }
    .product-card:hover .card-image { transform: scale(1.1); }
    .card-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 4rem; }
    .card-placeholder.unit { background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.05)); color: #3b82f6; }
    .card-placeholder.game { background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.05)); color: #22c55e; }
    .card-placeholder.accessory { background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(234, 179, 8, 0.05)); color: #eab308; }

    /* Card Badge - Repositioned */
    .card-badge { 
        position: absolute; 
        top: 0.5rem; 
        left: 0.5rem; 
        display: flex; 
        align-items: center; 
        gap: 0.3rem; 
        padding: 0.25rem 0.5rem; 
        border-radius: 6px; 
        font-size: 0.6rem; 
        font-weight: 700; 
        backdrop-filter: blur(4px); 
        box-shadow: 0 2px 8px rgba(0,0,0,0.2); 
        z-index: 2; 
    }
    .card-badge.unit { background: rgba(59, 130, 246, 0.9); color: white; }
    .card-badge.game { background: rgba(34, 197, 94, 0.9); color: white; }
    .card-badge.accessory { background: rgba(234, 179, 8, 0.9); color: #1e293b; }

    /* Relevance Indicator - Hidden for cleaner look or repositioned */
    .relevance-indicator { display: none; }

    /* Card Overlay */
    .card-overlay { position: absolute; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s; }
    .product-card:hover .card-overlay { opacity: 1; }
    .btn-view { background: white; color: #0f172a; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; text-decoration: none; transform: translateY(20px); transition: all 0.3s; display: flex; align-items: center; gap: 0.5rem; }
    .product-card:hover .btn-view { transform: translateY(0); }
    .btn-view:hover { background: #3b82f6; color: white; }

    /* Card Body - Right Side */
    .card-body { 
        padding: 1rem 1.25rem; 
        flex: 1; 
        display: flex; 
        flex-direction: column; 
        justify-content: space-between;
        min-width: 0; /* Fix flex text overflow */
    }
    .card-title { 
        font-size: 1.1rem; 
        font-weight: 700; 
        color: #f8fafc; 
        margin-bottom: 0.2rem; 
        line-height: 1.2; 
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis; 
    }
    .card-meta { 
        color: #94a3b8; 
        font-size: 0.8rem; 
        margin-bottom: 0.5rem; 
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .card-stock { display: flex; align-items: center; gap: 0.4rem; color: #64748b; font-size: 0.75rem; font-weight: 500; }
    .stock-indicator { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .stock-indicator.available { background: #22c55e; box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2); }
    .stock-indicator.unavailable { background: #ef4444; }

    /* Card Footer - Compact */
    .card-footer { 
        display: flex; 
        align-items: flex-end; 
        justify-content: space-between; 
        padding-top: 0; 
        border-top: none; 
        margin-top: auto; 
    }
    .price-block { display: flex; flex-direction: column; gap: 0; }
    .price-label { font-size: 0.65rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
    .price-value { display: flex; align-items: baseline; gap: 3px; }
    .currency { font-size: 0.85rem; color: #3b82f6; font-weight: 600; }
    .amount { 
        font-size: 1.4rem; 
        font-weight: 800; 
        background: linear-gradient(135deg, #f8fafc 0%, #cbd5e1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .unit { font-size: 0.75rem; color: #94a3b8; }
    
    .btn-arrow { 
        width: 36px; 
        height: 36px; 
        border-radius: 10px; 
        background: rgba(59, 130, 246, 0.1); 
        color: #3b82f6; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        text-decoration: none; 
        transition: all 0.2s; 
    }
    .btn-arrow:hover { background: #3b82f6; color: white; transform: translateX(3px) scale(1.05); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }

    /* Empty State */
    .empty-state { position: relative; z-index: 1; background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(20px); border: 1px solid rgba(148, 163, 184, 0.15); border-radius: 24px; padding: 4rem 2rem; text-align: center; max-width: 800px; margin: 0 auto; overflow: hidden; }
    .empty-illustration { position: relative; width: 140px; height: 140px; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center; }
    .empty-circle { position: absolute; inset: 0; border: 2px dashed rgba(239, 68, 68, 0.3); border-radius: 50%; animation: spin 20s linear infinite; }
    .empty-circle.inner { inset: 20px; border-color: rgba(59, 130, 246, 0.3); animation-direction: reverse; animation-duration: 15s; }
    @keyframes spin { to { transform: rotate(360deg); } }
    .empty-illustration i { font-size: 4rem; background: linear-gradient(135deg, #ef4444, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; position: relative; z-index: 2; animation: heartbeat 2s infinite ease-in-out; }
    @keyframes heartbeat { 0%, 100% { transform: scale(1); } 15% { transform: scale(1.2); } 30% { transform: scale(1); } }
    
    .floating-particles span { position: absolute; width: 6px; height: 6px; background: #3b82f6; border-radius: 50%; opacity: 0; animation: particleFloat 3s infinite; }
    .floating-particles span:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; background: #ef4444; }
    .floating-particles span:nth-child(2) { top: 60%; right: 20%; animation-delay: 1s; background: #f59e0b; }
    .floating-particles span:nth-child(3) { bottom: 20%; left: 40%; animation-delay: 2s; background: #3b82f6; }
    @keyframes particleFloat { 0% { transform: translateY(0) scale(0); opacity: 0; } 50% { opacity: 1; } 100% { transform: translateY(-40px) scale(1.5); opacity: 0; } }

    .empty-title { font-size: 1.75rem; font-weight: 700; color: #f8fafc; margin-bottom: 1rem; }
    .empty-desc { color: #94a3b8; max-width: 450px; margin: 0 auto 2.5rem; line-height: 1.6; font-size: 1.05rem; }
    .empty-actions { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }
    .empty-action-card { display: flex; align-items: center; gap: 1rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(148, 163, 184, 0.15); border-radius: 16px; padding: 1rem 1.5rem; text-decoration: none; color: #f8fafc; transition: all 0.3s; min-width: 180px; }
    .empty-action-card:hover { transform: translateY(-5px); border-color: rgba(59, 130, 246, 0.3); background: rgba(30, 41, 59, 0.8); }
    .action-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .action-icon.unit-icon { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    .action-icon.game-icon { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
    .action-icon.acc-icon { background: rgba(234, 179, 8, 0.15); color: #facc15; }
    .empty-action-card span { font-weight: 600; flex: 1; text-align: left; }
    .empty-action-card .bi-chevron-right { color: #64748b; transition: transform 0.2s; }
    .empty-action-card:hover .bi-chevron-right { transform: translateX(3px); color: #3b82f6; }

    /* Initial State */
    .initial-state { position: relative; z-index: 1; text-align: center; padding: 2rem 0; }
    .initial-visual { position: relative; width: 140px; height: 140px; margin: 0 auto 2rem; }
    .visual-ring { position: absolute; inset: 0; border: 2px solid rgba(59, 130, 246, 0.2); border-radius: 50%; animation: pulse-ring 3s infinite; }
    .visual-ring.ring-2 { inset: 20px; animation-delay: 1s; }
    .visual-ring.ring-3 { inset: 40px; animation-delay: 2s; }
    .initial-visual i { font-size: 3rem; color: #3b82f6; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
    .initial-title { font-size: 2rem; font-weight: 800; color: #f8fafc; margin-bottom: 0.75rem; }
    .initial-desc { color: #94a3b8; margin-bottom: 3rem; font-size: 1.1rem; }

    /* Popular Searches */
    .popular-searches { margin-bottom: 4rem; }
    .popular-label { color: #64748b; font-size: 0.9rem; margin-bottom: 1rem; display: block; font-weight: 500; }
    .popular-tags { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem; }
    .popular-tag { display: flex; align-items: center; gap: 0.5rem; background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(148, 163, 184, 0.2); color: #94a3b8; padding: 0.6rem 1.2rem; border-radius: 50px; text-decoration: none; font-weight: 500; transition: all 0.3s; }
    .popular-tag:hover { background: rgba(59, 130, 246, 0.1); border-color: #3b82f6; color: #3b82f6; transform: translateY(-3px); }

    /* Category Cards */
    .category-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto; }
    .category-card { position: relative; background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(148, 163, 184, 0.15); border-radius: 24px; padding: 2.5rem 1.5rem; text-align: center; text-decoration: none; overflow: hidden; transition: all 0.4s; display: flex; flex-direction: column; align-items: center; }
    .category-bg { position: absolute; inset: 0; opacity: 0; transition: opacity 0.4s; }
    .category-card.unit .category-bg { background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.05)); }
    .category-card.game .category-bg { background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.05)); }
    .category-card.accessory .category-bg { background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(234, 179, 8, 0.05)); }
    .category-card:hover .category-bg { opacity: 1; }
    .category-card:hover { transform: translateY(-10px); border-color: rgba(255,255,255,0.1); box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
    
    .category-icon { width: 64px; height: 64px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1.5rem; position: relative; z-index: 1; transition: all 0.4s; }
    .category-card.unit .category-icon { background: rgba(59, 130, 246, 0.1); color: #60a5fa; }
    .category-card.game .category-icon { background: rgba(34, 197, 94, 0.1); color: #4ade80; }
    .category-card.accessory .category-icon { background: rgba(234, 179, 8, 0.1); color: #facc15; }
    
    .category-card:hover .category-icon { transform: scale(1.1) rotate(5deg); }
    
    .category-card h4 { color: #f8fafc; font-weight: 700; margin-bottom: 0.5rem; position: relative; z-index: 1; font-size: 1.25rem; }
    .category-card p { color: #94a3b8; font-size: 0.9rem; position: relative; z-index: 1; margin: 0; }

    /* ==========================================
       LIGHT MODE
       ========================================== */
    body.light-mode .orb { opacity: 0.15; }
    body.light-mode .search-hero-glass { background: rgba(255, 255, 255, 0.85); border-color: rgba(226, 232, 240, 0.8); box-shadow: 0 20px 50px rgba(0,0,0,0.05); }
    body.light-mode .search-title { background: linear-gradient(135deg, #0f172a, #334155); -webkit-background-clip: text; }
    body.light-mode .search-subtitle, body.light-mode .result-text { color: #64748b; }
    body.light-mode .result-query { color: #0f172a; }
    body.light-mode .search-input-group { background: #ffffff; border-color: #e2e8f0; }
    body.light-mode .search-input-group:focus-within { background: #ffffff; border-color: #3b82f6; }
    body.light-mode .search-input-field { color: #0f172a; }
    body.light-mode .semantic-header { color: #64748b; }
    body.light-mode .semantic-chip { background: #f1f5f9; border-color: #e2e8f0; color: #64748b; }
    body.light-mode .semantic-chip:hover { background: #eff6ff; border-color: #3b82f6; color: #3b82f6; }
    
    body.light-mode .filter-tab { background: #ffffff; border-color: #e2e8f0; color: #64748b; }
    body.light-mode .filter-tab:hover { background: #f8fafc; }
    body.light-mode .filter-tab.active { color: white; }
    
    body.light-mode .product-card { background: #ffffff; border-color: #e2e8f0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04); }
    body.light-mode .product-card:hover { box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); border-color: #3b82f6; }
    body.light-mode .card-title { color: #0f172a; }
    body.light-mode .card-meta { color: #64748b; }
    body.light-mode .card-footer { border-top-color: #f1f5f9; }
    body.light-mode .amount { color: #0f172a; }
    body.light-mode .btn-arrow { background: #f1f5f9; }
    body.light-mode .btn-arrow:hover { background: #3b82f6; }
    
    body.light-mode .empty-state, body.light-mode .initial-state { background: #ffffff; border-color: #e2e8f0; }
    body.light-mode .empty-title, body.light-mode .initial-title { color: #0f172a; }
    body.light-mode .empty-desc, body.light-mode .initial-desc { color: #64748b; }
    body.light-mode .empty-action-card { background: #f8fafc; border-color: #e2e8f0; color: #0f172a; }
    body.light-mode .empty-action-card:hover { background: #ffffff; border-color: #3b82f6; }
    
    body.light-mode .popular-tag { background: #f1f5f9; border-color: #e2e8f0; color: #64748b; }
    body.light-mode .popular-tag:hover { background: #eff6ff; border-color: #3b82f6; color: #3b82f6; }
    
    body.light-mode .category-card { background: #ffffff; border-color: #e2e8f0; }
    body.light-mode .category-card h4 { color: #0f172a; }
    body.light-mode .category-card p { color: #64748b; }

    /* ==========================================
       RESPONSIVE
       ========================================== */
    @media (max-width: 768px) {
        .search-hero-glass { padding: 1.5rem; }
        .search-icon-wrapper { width: 50px; height: 50px; margin-bottom: 1rem; }
        .search-icon-core { inset: 8px; font-size: 1.2rem; }
        .result-count { font-size: 2.5rem; }
        .search-title { font-size: 1.8rem; }
        .search-input-group { flex-direction: column; padding: 0.5rem; }
        .search-input-container { padding: 0.5rem; }
        .search-btn { width: 100%; justify-content: center; margin-top: 0.5rem; }
        .filter-tabs { padding-bottom: 0.5rem; }
        .results-container { grid-template-columns: 1fr; }
        .empty-state { padding: 2rem 1.5rem; }
        .empty-actions { flex-direction: column; }
        .category-cards { grid-template-columns: 1fr; }
        .initial-visual { width: 100px; height: 100px; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter Tab Functionality
        const tabs = document.querySelectorAll('.filter-tab');
        const cards = document.querySelectorAll('.product-card');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Update active tab
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Filter cards with animation
                cards.forEach((card, index) => {
                    if (filter === 'all' || card.dataset.type === filter) {
                        card.style.display = 'flex';
                        // Reset animation
                        card.style.animation = 'none';
                        card.offsetHeight; /* trigger reflow */
                        card.style.animation = `cardIn 0.6s ease forwards ${index * 0.05}s`;
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
