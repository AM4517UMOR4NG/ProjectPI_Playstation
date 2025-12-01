@extends('layouts.dashboard')

@section('title', 'Dashboard Pelanggan')

@section('header_title', '')

@section('sidebar_menu')
    <a href="{{ route('dashboard.pelanggan') }}" class="nav-link {{ request()->routeIs('dashboard.pelanggan') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Beranda">
        <i class="bi bi-grid"></i>
        <span>Beranda</span>
    </a>
    
    <div class="sidebar-heading">Belanja</div>
    
    <a href="{{ route('pelanggan.unitps.index') }}" class="nav-link {{ request()->routeIs('pelanggan.unitps.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Sewa PS">
        <i class="bi bi-controller"></i>
        <span>Sewa PS</span>
    </a>
    <a href="{{ route('pelanggan.games.index') }}" class="nav-link {{ request()->routeIs('pelanggan.games.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Sewa Game">
        <i class="bi bi-disc"></i>
        <span>Sewa Game</span>
    </a>
    <a href="{{ route('pelanggan.accessories.index') }}" class="nav-link {{ request()->routeIs('pelanggan.accessories.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Sewa Aksesoris">
        <i class="bi bi-headset"></i>
        <span>Sewa Aksesoris</span>
    </a>
    
    <div class="sidebar-heading">Transaksi</div>

    <a href="{{ route('pelanggan.cart.index') }}" class="nav-link {{ request()->routeIs('pelanggan.cart.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Keranjang">
        <i class="bi bi-cart"></i>
        <span>Keranjang</span>
    </a>
    <a href="{{ route('pelanggan.rentals.index') }}" class="nav-link {{ request()->routeIs('pelanggan.rentals.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Riwayat Sewa">
        <i class="bi bi-clock-history"></i>
        <span>Riwayat Sewa</span>
    </a>
    
    <div class="sidebar-heading">Akun</div>

    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Profil Saya">
        <i class="bi bi-person-circle"></i>
        <span>Profil Saya</span>
    </a>
@endsection

@push('styles')
<style>
    /* Premium Card Enhancements */
    .card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(148, 163, 184, 0.2);
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s;
    }

    .card:hover::before {
        left: 100%;
    }

    .card-hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(59, 130, 246, 0.1);
    }

    .card-glow:hover {
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3), 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    /* Interactive Table Enhancements */
    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Premium Button Effects */
    .btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:active::after {
        width: 300px;
        height: 300px;
    }

    .btn-primary:hover, .btn-success:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
    }

    /* Badge Enhancements */
    .badge-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
    }

    /* Form Input Enhancements */
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 0 12px rgba(59, 130, 246, 0.2);
        transform: translateY(-1px);
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Glassmorphism */
    .glass-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(148, 163, 184, 0.2);
    }

    /* Gradient Text */
    .gradient-text {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Hover Scale */
    .hover-scale:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    /* Dynamic Grid Resizing Logic */
    @media (min-width: 1200px) {
        /* Sidebar Open: 3 Columns (Wider Cards) */
        body:not(.sidebar-collapsed) .main-content .row-cols-lg-4 > *,
        body:not(.sidebar-collapsed) .main-content .row-cols-xl-4 > * {
            flex: 0 0 auto;
            width: 33.3333%;
        }
        
        /* Sidebar Collapsed: 5 Columns (Smaller Cards) */
        body.sidebar-collapsed .main-content .row-cols-lg-4 > *,
        body.sidebar-collapsed .main-content .row-cols-xl-4 > * {
            flex: 0 0 auto;
            width: 20%;
        }
    }

    /* Smooth Transition for Grid Items */
    .main-content .row > * {
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease;
    }

    /* Custom Tooltip Styling */
    .tooltip-inner {
        background-color: #1e293b; /* Dark background */
        color: #fff;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 8px 12px;
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    
    .tooltip.bs-tooltip-end .tooltip-arrow::before {
        border-right-color: #1e293b;
    }

    /* ========================================
       LIGHT MODE STYLES FOR PELANGGAN
       ======================================== */
    
    /* Card Styles */
    body.light-mode .card {
        background: #ffffff;
        border-color: #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    body.light-mode .card::before {
        background: linear-gradient(90deg, transparent, rgba(21, 93, 252, 0.08), transparent);
    }
    
    body.light-mode .card-hover-lift:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(21, 93, 252, 0.15);
    }
    
    body.light-mode .card-body {
        background: transparent;
    }
    
    /* Glass Card Light Mode */
    body.light-mode .glass-card {
        background: rgba(255, 255, 255, 0.9);
        border-color: #e2e8f0;
    }
    
    /* Text Colors */
    body.light-mode .text-white {
        color: #0f172a !important;
    }
    
    body.light-mode .text-muted {
        color: #64748b !important;
    }
    
    body.light-mode .text-secondary {
        color: #475569 !important;
    }
    
    body.light-mode h1, 
    body.light-mode h2, 
    body.light-mode h3, 
    body.light-mode h4, 
    body.light-mode h5, 
    body.light-mode h6 {
        color: #0f172a;
    }
    
    body.light-mode p,
    body.light-mode span:not(.badge),
    body.light-mode div:not(.badge):not(.alert) {
        color: #334155;
    }
    
    /* Gradient Text Light Mode */
    body.light-mode .gradient-text {
        background: linear-gradient(135deg, #155DFC, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Table Styles */
    body.light-mode .table {
        color: #0f172a;
    }
    
    body.light-mode .table thead th {
        background: #f8fafc;
        color: #0f172a;
        border-bottom: 2px solid #e2e8f0;
    }
    
    body.light-mode .table tbody tr {
        border-color: #e2e8f0;
    }
    
    body.light-mode .table tbody tr:hover {
        background-color: rgba(21, 93, 252, 0.05);
    }
    
    body.light-mode .table td {
        color: #334155;
        border-color: #e2e8f0;
    }
    
    /* Form Controls */
    body.light-mode .form-control,
    body.light-mode .form-select {
        background-color: #ffffff;
        border-color: #cbd5e1;
        color: #0f172a;
    }
    
    body.light-mode .form-control::placeholder {
        color: #94a3b8;
    }
    
    body.light-mode .form-control:focus,
    body.light-mode .form-select:focus {
        background-color: #ffffff;
        border-color: #155DFC;
        box-shadow: 0 0 0 3px rgba(21, 93, 252, 0.15);
    }
    
    body.light-mode .input-group-text {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        color: #64748b;
    }
    
    body.light-mode .form-label {
        color: #334155;
    }
    
    /* Badge Styles */
    body.light-mode .badge.bg-secondary-subtle {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
    }
    
    body.light-mode .badge.bg-success-subtle {
        background-color: #dcfce7 !important;
        color: #166534 !important;
    }
    
    body.light-mode .badge.bg-warning-subtle {
        background-color: #fef3c7 !important;
        color: #92400e !important;
    }
    
    body.light-mode .badge.bg-danger-subtle {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
    }
    
    body.light-mode .badge.bg-info-subtle {
        background-color: #dbeafe !important;
        color: #1e40af !important;
    }
    
    body.light-mode .badge.bg-primary-subtle {
        background-color: #dbeafe !important;
        color: #1e40af !important;
    }
    
    /* Alert Styles */
    body.light-mode .alert {
        border-width: 1px;
    }
    
    body.light-mode .alert-success,
    body.light-mode .alert.bg-success-subtle {
        background-color: #dcfce7 !important;
        border-color: #86efac !important;
        color: #166534 !important;
    }
    
    body.light-mode .alert-warning,
    body.light-mode .alert.bg-warning-subtle {
        background-color: #fef3c7 !important;
        border-color: #fcd34d !important;
        color: #92400e !important;
    }
    
    body.light-mode .alert-danger,
    body.light-mode .alert.bg-danger-subtle {
        background-color: #fee2e2 !important;
        border-color: #fca5a5 !important;
        color: #991b1b !important;
    }
    
    body.light-mode .alert-info,
    body.light-mode .alert.bg-info-subtle {
        background-color: #dbeafe !important;
        border-color: #93c5fd !important;
        color: #1e40af !important;
    }
    
    /* Button Styles */
    body.light-mode .btn-primary {
        background-color: #155DFC;
        border-color: #155DFC;
    }
    
    body.light-mode .btn-primary:hover {
        background-color: #1249cc;
        border-color: #1249cc;
    }
    
    body.light-mode .btn-outline-secondary {
        border-color: #cbd5e1;
        color: #475569;
    }
    
    body.light-mode .btn-outline-secondary:hover {
        background-color: #f1f5f9;
        border-color: #94a3b8;
        color: #334155;
    }
    
    body.light-mode .btn-outline-primary {
        border-color: #155DFC;
        color: #155DFC;
    }
    
    body.light-mode .btn-outline-primary:hover {
        background-color: #155DFC;
        color: #ffffff;
    }
    
    body.light-mode .btn-info {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
    }
    
    body.light-mode .btn-success {
        background-color: #22c55e;
        border-color: #22c55e;
    }
    
    /* Border Colors */
    body.light-mode .border-secondary {
        border-color: #e2e8f0 !important;
    }
    
    body.light-mode .border-bottom {
        border-color: #e2e8f0 !important;
    }
    
    /* Background Colors */
    body.light-mode .bg-dark {
        background-color: #f1f5f9 !important;
    }
    
    body.light-mode .bg-secondary {
        background-color: #e2e8f0 !important;
    }
    
    /* Tooltip Light Mode */
    body.light-mode .tooltip-inner {
        background-color: #1e293b;
        color: #fff;
    }
    
    /* Font Monospace */
    body.light-mode .font-monospace {
        color: #475569;
    }
    
    /* Image Placeholder */
    body.light-mode .bg-dark.rounded {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
    }
    
    /* Pagination */
    body.light-mode .pagination .page-link {
        background-color: #ffffff;
        border-color: #e2e8f0;
        color: #334155;
    }
    
    body.light-mode .pagination .page-link:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    body.light-mode .pagination .page-item.active .page-link {
        background-color: #155DFC;
        border-color: #155DFC;
        color: #ffffff;
    }
    
    body.light-mode .pagination .page-item.disabled .page-link {
        background-color: #f8fafc;
        color: #94a3b8;
    }
    
    /* Card Footer */
    body.light-mode .card-footer {
        background-color: #f8fafc;
        border-top-color: #e2e8f0;
    }
    
    /* Specific Icon Colors */
    body.light-mode .bi.text-primary {
        color: #155DFC !important;
    }
    
    body.light-mode .bi.text-success {
        color: #22c55e !important;
    }
    
    body.light-mode .bi.text-warning {
        color: #f59e0b !important;
    }
    
    body.light-mode .bi.text-danger {
        color: #ef4444 !important;
    }
    
    body.light-mode .bi.text-info {
        color: #0ea5e9 !important;
    }
    
    body.light-mode .bi.text-muted {
        color: #94a3b8 !important;
    }
    
    /* Small Text */
    body.light-mode small,
    body.light-mode .small {
        color: #64748b;
    }
    
    /* FW Bold Text */
    body.light-mode .fw-bold {
        color: #0f172a;
    }
    
    body.light-mode .table .fw-bold {
        color: #0f172a;
    }
    
    /* Specific overrides for rental pages */
    body.light-mode .card .text-white {
        color: #0f172a !important;
    }
    
    body.light-mode .card .text-muted.small {
        color: #64748b !important;
    }
    
    /* ========================================
       LIGHT MODE - DASHBOARD CARDS (Katalog)
       ======================================== */
    
    /* Dash Card - Main Container */
    body.light-mode .dash-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    body.light-mode .dash-card::before {
        background: linear-gradient(90deg, #155DFC, #3b82f6, #2563eb);
    }
    
    body.light-mode .dash-card:hover {
        box-shadow: 0 20px 40px rgba(21, 93, 252, 0.15),
                    0 0 0 1px rgba(21, 93, 252, 0.2);
        border-color: rgba(21, 93, 252, 0.4);
    }
    
    /* Dash Frame - Image Container - BIRU DI ATAS */
    body.light-mode .dash-frame {
        background: linear-gradient(135deg, #155DFC 0%, #3b82f6 100%);
        border: 2px solid #dbeafe;
    }
    
    /* Card Content - Label Area - BIRU DI BAWAH */
    body.light-mode .dash-card .card-content {
        background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        border-radius: 0 0 1rem 1rem;
    }
    
    /* Card Title */
    body.light-mode .dash-card h5,
    body.light-mode .dash-card .text-white {
        color: #0f172a !important;
    }
    
    /* Price Text */
    body.light-mode .text-price {
        color: #155DFC !important;
        text-shadow: none;
    }
    
    /* Stock Badge - BIRU */
    body.light-mode .badge-stock {
        background: rgba(21, 93, 252, 0.15);
        color: #155DFC;
        border: 1px solid rgba(21, 93, 252, 0.3);
    }
    
    /* CTA Button */
    body.light-mode .btn-cta {
        background: linear-gradient(135deg, #155DFC, #3b82f6);
    }
    
    body.light-mode .btn-cta:hover {
        box-shadow: 0 10px 30px rgba(21, 93, 252, 0.4);
    }
    
    /* Hero Section */
    body.light-mode .dash-hero h2 {
        background: linear-gradient(135deg, #155DFC, #7c3aed, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    body.light-mode .dash-hero p {
        color: #64748b;
    }
    
    /* Section Header */
    body.light-mode .section-header h3,
    body.light-mode section h3.text-white {
        color: #0f172a !important;
    }
    
    /* Top Navbar Light Mode - BIRU */
    body.light-mode .top-navbar {
        background: linear-gradient(135deg, #155DFC 0%, #3b82f6 100%) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    body.light-mode .top-navbar .header-title {
        color: #ffffff !important;
    }
    
    body.light-mode .top-navbar .toggle-btn {
        color: #ffffff;
    }
    
    body.light-mode .top-navbar .toggle-btn:hover {
        background: rgba(255, 255, 255, 0.15);
    }
    
    body.light-mode .top-navbar .dropdown-toggle {
        color: #ffffff !important;
    }
    
    body.light-mode .top-navbar .user-name {
        color: #ffffff !important;
    }
    
    body.light-mode .top-navbar .bi {
        color: #ffffff !important;
    }
    
    /* Theme Toggle Button in Navbar */
    body.light-mode .top-navbar #themeToggle {
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    body.light-mode .top-navbar #themeToggle:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    /* ========================================
       LIGHT MODE - NOTIFICATION FIXES
       ======================================== */
    
    /* SweetAlert2 Fixes */
    body.light-mode .swal2-popup {
        background: #ffffff !important;
        color: #1e293b !important;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
    
    body.light-mode .swal2-title,
    body.light-mode .swal2-content,
    body.light-mode .swal2-html-container {
        color: #1e293b !important;
    }
    
    body.light-mode .swal2-icon.swal2-success {
        border-color: #22c55e;
        color: #22c55e;
    }
    
    body.light-mode .swal2-timer-progress-bar {
        background: #3b82f6;
    }
    
    /* Bootstrap Toast Fixes */
    body.light-mode .toast {
        background-color: #ffffff !important;
        color: #1e293b !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
    
    body.light-mode .toast-header {
        background-color: #f8fafc !important;
        color: #0f172a !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    
    body.light-mode .toast-body {
        color: #334155 !important;
    }
    
    body.light-mode .btn-close {
        filter: none !important; /* Ensure close button is visible on light bg */
    }
    
    /* Force white text on primary buttons - BOTH dark and light mode */
    .btn-primary,
    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active,
    body.light-mode .btn-primary,
    body.light-mode .btn-primary:hover,
    body.light-mode .btn-primary:focus,
    body.light-mode .btn-primary:active {
        color: #ffffff !important;
    }
    
    /* Force white text for all content inside primary buttons */
    .btn-primary *,
    body.light-mode .btn-primary * {
        color: #ffffff !important;
    }
</style>
@endpush

@section('content')
    @yield('pelanggan_content')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover' // Explicitly set trigger to hover
            })
        });

        // Optional: Disable tooltips when sidebar is expanded (if desired)
        const body = document.body;
        const sidebar = document.getElementById('sidebar');
        
        function updateTooltips() {
            if (body.classList.contains('sidebar-collapsed')) {
                tooltipList.forEach(t => t.enable());
            } else {
                tooltipList.forEach(t => t.disable());
            }
        }

        // Initial check
        updateTooltips();

        // Listen for sidebar toggle events (assuming toggle button clicks toggle the class)
        const toggleBtn = document.getElementById('sidebarToggle');
        if(toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                // Wait a bit for class toggle to happen
                setTimeout(updateTooltips, 50);
            });
        }
    });
</script>
@endpush
