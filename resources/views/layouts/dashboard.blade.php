<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — RentalPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* High Contrast Dark Theme Palette */
            --bg-dark: #0f172a;       /* Slate 900 - Deep background */
            --sidebar-bg: #1e293b;    /* Slate 800 - Solid sidebar for better text contrast */
            --card-bg: #1e293b;       /* Slate 800 - Solid card background */
            --card-border: #334155;   /* Slate 700 - Visible borders */
            
            --primary: #3b82f6;       /* Blue 500 - Consistent blue primary */
            --primary-hover: #2563eb; /* Blue 600 */
            --secondary: #60a5fa;     /* Blue 400 - Light blue */
            
            --text-main: #f8fafc;     /* Slate 50 - Almost white for main text */
            --text-muted: #cbd5e1;    /* Slate 300 - Light gray for secondary text */
            --text-dim: #94a3b8;      /* Slate 400 - For less important details */
            
            --success: #22c55e;       /* Green 500 */
            --warning: #eab308;       /* Yellow 500 */
            --danger: #ef4444;        /* Red 500 */
            
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
        }

        /* Light Mode Palette */
        body.light-mode {
            --bg-dark: #f1f5f9;       /* Slate 100 */
            --sidebar-bg: #155DFC;    /* Custom Blue #155DFC */
            --card-bg: #ffffff;       /* White */
            --card-border: #e2e8f0;   /* Slate 200 */
            
            --text-main: #0f172a;     /* Slate 900 */
            --text-muted: #64748b;    /* Slate 500 */
            --text-dim: #94a3b8;      /* Slate 400 */
        }

        /* Sidebar Light Mode Overrides */
        body.light-mode .sidebar .nav-link {
            color: #ffffff;
            font-weight: 500;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        body.light-mode .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        body.light-mode .sidebar .nav-link.active {
            color: #155DFC;
            background: #ffffff;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
            text-shadow: none;
            font-weight: 700;
        }
        
        body.light-mode .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.light-mode .logo-text {
            color: #ffffff;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
        }
        
        body.light-mode .sidebar-heading {
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        /* Global Blue Overrides for Light Mode */
        body.light-mode .logo-icon {
            background: #ffffff !important;
            color: #155DFC !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        body.light-mode .bg-primary,
        body.light-mode .btn-primary {
            background: #155DFC !important;
            border-color: #155DFC !important;
            box-shadow: none !important;
        }
        
        body.light-mode .text-primary {
            color: #155DFC !important;
        }

        body.light-mode .nav-link:hover {
            background: rgba(0, 0, 0, 0.05);
            color: var(--primary);
        }

        body.light-mode .top-navbar {
            background: linear-gradient(135deg, #155DFC 0%, #3b82f6 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.light-mode .top-navbar .header-title,
        body.light-mode .top-navbar .toggle-btn,
        body.light-mode .top-navbar .dropdown-toggle,
        body.light-mode .top-navbar .bi {
            color: #ffffff !important;
        }
        
        body.light-mode .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        body.light-mode .top-navbar #themeToggle {
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        body.light-mode .top-navbar #themeToggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        body.light-mode .card-header {
            background: rgba(0, 0, 0, 0.02);
        }

        body.light-mode .table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--text-main);
        }

        body.light-mode .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        body.light-mode .form-control, 
        body.light-mode .form-select {
            background-color: #ffffff;
            color: var(--text-main);
        }

        body.light-mode .form-control:focus, 
        body.light-mode .form-select:focus {
            background-color: #ffffff;
        }

        body.light-mode .input-group-text {
            background-color: #f8fafc;
        }
        
        /* Light Mode Badge Overrides */
        body.light-mode .badge.bg-dark {
            background-color: #475569 !important;
            color: #f8fafc !important;
        }
        
        /* Light Mode - Dashboard Cards (Katalog) */
        body.light-mode .dash-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        body.light-mode .dash-frame {
            background: linear-gradient(135deg, #155DFC 0%, #3b82f6 100%) !important;
            border: 2px solid #dbeafe !important;
        }
        
        body.light-mode .dash-card .card-content {
            background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%) !important;
        }
        
        body.light-mode .dash-card h5,
        body.light-mode .dash-card .text-white {
            color: #0f172a !important;
        }
        
        body.light-mode .text-price {
            color: #155DFC !important;
            text-shadow: none !important;
        }
        
        body.light-mode .badge-stock {
            background: rgba(21, 93, 252, 0.15) !important;
            color: #155DFC !important;
            border: 1px solid rgba(21, 93, 252, 0.3) !important;
        }
        
        body.light-mode .btn-cta {
            background: linear-gradient(135deg, #155DFC, #3b82f6) !important;
        }
        
        body.light-mode .dash-hero p {
            color: #64748b !important;
        }
        
        body.light-mode section h3.text-white,
        body.light-mode .section-header h3 {
            color: #0f172a !important;
        }
        
        /* Light Mode - Global Text Colors */
        body.light-mode .text-white {
            color: #0f172a !important;
        }
        
        body.light-mode .text-muted {
            color: #64748b !important;
        }
        
        body.light-mode h1, body.light-mode h2, body.light-mode h3, 
        body.light-mode h4, body.light-mode h5, body.light-mode h6 {
            color: #0f172a;
        }
        
        body.light-mode p {
            color: #334155;
        }
        
        
        body.light-mode .fw-bold {
            color: #0f172a;
        }
        
        /* Ultra-High Specificity Override for Primary Buttons */
        html body.light-mode .btn-primary,
        html body.light-mode .btn-primary:hover,
        html body.light-mode .btn-primary:focus,
        html body.light-mode .btn-primary:active,
        html body.light-mode .btn-primary.fw-bold,
        html body.light-mode .btn-primary .fw-bold,
        html body.light-mode .btn-primary *,
        html body.light-mode .btn-primary.fw-bold * {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important; /* Force for webkit browsers */
        }
        
        /* Fix Dropdown Menu in Light Mode - Keep it dark but ensure text is white */
        body.light-mode .dropdown-menu-dark {
            background-color: #1e293b !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.light-mode .dropdown-menu-dark .dropdown-header,
        body.light-mode .dropdown-menu-dark .dropdown-item {
            color: #e2e8f0 !important; /* Light slate text */
        }
        
        body.light-mode .dropdown-menu-dark .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }
        
        body.light-mode .card .text-white {
            color: #0f172a !important;
        }
        
        body.light-mode .card-header .text-white {
            color: #0f172a !important;
        }
        
        /* Sidebar Logout Button Fix - Change from Red to White */
        .sidebar .nav-link.text-danger {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .sidebar .nav-link.text-danger:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1);
        }
        
        body.light-mode .table td {
            color: #334155;
        }
        
        body.light-mode .table .fw-bold {
            color: #0f172a;
        }
        
        /* Light Mode - Card Backgrounds */
        body.light-mode .card {
            background: #ffffff;
            border-color: #e2e8f0;
        }
        
        body.light-mode .card-header {
            background: #f8fafc;
            border-bottom-color: #e2e8f0;
        }
        
        /* Light Mode - Badges */
        html body.light-mode .badge.bg-primary,
        html body.light-mode .badge.bg-primary.fw-bold,
        html body.light-mode .badge.bg-primary * {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }

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
        
        /* Light Mode - Form Controls */
        body.light-mode .form-control,
        body.light-mode .form-select {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }
        
        body.light-mode .input-group-text {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #64748b !important;
        }
        
        /* Light Mode - Pagination */
        body.light-mode .pagination .page-link {
            background-color: #ffffff;
            border-color: #e2e8f0;
            color: #334155;
        }
        
        body.light-mode .pagination .page-item.active .page-link {
            background-color: #155DFC;
            border-color: #155DFC;
        }
        
        /* Light Mode - Table Styles */
        body.light-mode .table {
            background: #ffffff;
            color: #0f172a;
        }
        
        body.light-mode .table thead {
            background: #f8fafc;
        }
        
        body.light-mode .table thead th {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            border-bottom: 2px solid #e2e8f0 !important;
            font-weight: 600;
        }
        
        body.light-mode .table tbody tr {
            border-color: #e2e8f0;
        }
        
        body.light-mode .table tbody tr:hover {
            background-color: #f8fafc !important;
        }
        
        body.light-mode .table td {
            color: #334155 !important;
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode .table-responsive {
            background: #ffffff;
            border-radius: 0.5rem;
        }
        
        /* Light Mode - Stats Cards with Gradient (keep white text) */
        body.light-mode .card[style*="background: linear-gradient"] h3,
        body.light-mode .card[style*="background: linear-gradient"] .fw-bold,
        body.light-mode .card[style*="background: linear-gradient"] small,
        body.light-mode .card[style*="background: linear-gradient"] p,
        body.light-mode .card[style*="background: linear-gradient"] span,
        body.light-mode [style*="background: linear-gradient"] h3,
        body.light-mode [style*="background: linear-gradient"] .fw-bold,
        body.light-mode [style*="background: linear-gradient"] small {
            color: #ffffff !important;
        }
        
        body.light-mode .card[style*="background: linear-gradient"] .opacity-75 {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        /* Light Mode - Colored stat cards should keep white text */
        body.light-mode .bg-danger,
        body.light-mode .bg-primary,
        body.light-mode .bg-success,
        body.light-mode .bg-warning,
        body.light-mode .bg-info {
            color: #ffffff !important;
        }
        
        body.light-mode .bg-danger h3,
        body.light-mode .bg-primary h3,
        body.light-mode .bg-success h3,
        body.light-mode .bg-warning h3,
        body.light-mode .bg-info h3,
        body.light-mode .bg-danger .fw-bold,
        body.light-mode .bg-primary .fw-bold,
        body.light-mode .bg-success .fw-bold {
            color: #ffffff !important;
        }
        
        /* Light Mode - Opacity backgrounds */
        body.light-mode .bg-danger.bg-opacity-25,
        body.light-mode .bg-primary.bg-opacity-25,
        body.light-mode .bg-success.bg-opacity-25,
        body.light-mode .bg-warning.bg-opacity-25,
        body.light-mode .bg-info.bg-opacity-25 {
            background-color: rgba(var(--bs-danger-rgb), 0.15) !important;
        }
        
        body.light-mode .bg-danger.bg-opacity-25 h3,
        body.light-mode .bg-danger.bg-opacity-25 .fw-bold {
            color: #dc2626 !important;
        }
        
        body.light-mode .bg-primary.bg-opacity-25 h3,
        body.light-mode .bg-primary.bg-opacity-25 .fw-bold {
            color: #155DFC !important;
        }
        
        body.light-mode .bg-warning.bg-opacity-25 h3,
        body.light-mode .bg-warning.bg-opacity-25 .fw-bold {
            color: #d97706 !important;
        }
        
        body.light-mode .bg-info.bg-opacity-25 h3,
        body.light-mode .bg-info.bg-opacity-25 .fw-bold {
            color: #0891b2 !important;
        }
        
        body.light-mode .bg-success.bg-opacity-25 h3,
        body.light-mode .bg-success.bg-opacity-25 .fw-bold {
            color: #16a34a !important;
        }
        
        /* Light Mode - Card with colored backgrounds keep white text */
        body.light-mode .card.bg-danger,
        body.light-mode .card.bg-primary,
        body.light-mode .card.bg-success,
        body.light-mode .card.bg-info,
        body.light-mode .card.bg-warning {
            color: #ffffff !important;
        }
        
        body.light-mode .card.bg-danger *,
        body.light-mode .card.bg-primary *,
        body.light-mode .card.bg-success *,
        body.light-mode .card.bg-info * {
            color: #ffffff !important;
        }
        
        /* Light Mode - Alert styles */
        body.light-mode .alert {
            border-width: 1px;
        }
        
        body.light-mode .alert-info {
            background-color: #dbeafe !important;
            border-color: #93c5fd !important;
            color: #1e40af !important;
        }
        
        body.light-mode .alert-success {
            background-color: #dcfce7 !important;
            border-color: #86efac !important;
            color: #166534 !important;
        }
        
        body.light-mode .alert-warning {
            background-color: #fef3c7 !important;
            border-color: #fcd34d !important;
            color: #92400e !important;
        }
        
        body.light-mode .alert-danger {
            background-color: #fee2e2 !important;
            border-color: #fca5a5 !important;
            color: #991b1b !important;
        }
        
        /* Light Mode - Code/monospace */
        body.light-mode code {
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 2px 6px;
            border-radius: 4px;
        }
        
        /* Light Mode - Small text */
        body.light-mode small,
        body.light-mode .small {
            color: #64748b !important;
        }
        
        /* Light Mode - Border colors */
        body.light-mode .border-0 {
            border-color: transparent !important;
        }
        
        body.light-mode .shadow-sm {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Light Mode - Card header with opacity */
        body.light-mode .card-header.bg-danger.bg-opacity-10,
        body.light-mode .card-header.bg-warning.bg-opacity-10,
        body.light-mode .card-header.bg-info.bg-opacity-10,
        body.light-mode .card-header.bg-secondary.bg-opacity-10 {
            background-color: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0;
        }
        
        body.light-mode .card-header h5 {
            color: #0f172a !important;
        }
        
        /* Light Mode - Main content area */
        body.light-mode .main-content {
            background-color: #f1f5f9;
        }
        
        /* Light Mode - Grid background */
        body.light-mode .bg-grid {
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
        }
        
        /* ============================================
           LIGHT MODE - COMPREHENSIVE TEXT FIX
           Semua teks harus gelap di background terang
           ============================================ */
        
        /* Fix .text-light class - ini yang menyebabkan teks tidak terbaca */
        body.light-mode .text-light {
            color: #1e293b !important;
        }
        
        /* Fix semua teks dalam tabel */
        body.light-mode .table,
        body.light-mode .table td,
        body.light-mode .table th,
        body.light-mode .table span,
        body.light-mode .table a,
        body.light-mode .premium-table td,
        body.light-mode .premium-table span {
            color: #1e293b !important;
        }
        
        /* Fix teks dalam card biasa (bukan gradient) */
        body.light-mode .card:not([style*="gradient"]) {
            color: #1e293b;
        }
        
        body.light-mode .card:not([style*="gradient"]) h1,
        body.light-mode .card:not([style*="gradient"]) h2,
        body.light-mode .card:not([style*="gradient"]) h3,
        body.light-mode .card:not([style*="gradient"]) h4,
        body.light-mode .card:not([style*="gradient"]) h5,
        body.light-mode .card:not([style*="gradient"]) h6,
        body.light-mode .card:not([style*="gradient"]) p,
        body.light-mode .card:not([style*="gradient"]) span,
        body.light-mode .card:not([style*="gradient"]) div,
        body.light-mode .card:not([style*="gradient"]) .text-light,
        body.light-mode .card:not([style*="gradient"]) .fw-bold,
        body.light-mode .card:not([style*="gradient"]) .fw-medium {
            color: #1e293b !important;
        }
        
        /* Fix stat-card dan premium-metric text */
        body.light-mode .stat-card .stat-label,
        body.light-mode .stat-card .stat-number {
            color: #1e293b !important;
        }
        
        /* Fix table header text */
        body.light-mode .table-header h6,
        body.light-mode .table-header span {
            color: #1e293b !important;
        }
        
        /* Fix avatar text - tetap putih karena background gelap */
        body.light-mode .avatar-sm {
            color: #ffffff !important;
        }
        
        /* Fix date-badge icon */
        body.light-mode .date-badge {
            background: rgba(21, 93, 252, 0.15);
        }
        
        body.light-mode .date-badge i {
            color: #155DFC !important;
        }
        
        /* Fix method badge */
        body.light-mode .method-badge {
            background: rgba(21, 93, 252, 0.1) !important;
            color: #155DFC !important;
            border-color: rgba(21, 93, 252, 0.3) !important;
        }
        
        /* Fix amount text */
        body.light-mode .amount-text {
            color: #059669 !important;
        }
        
        /* Fix gradient text untuk heading */
        body.light-mode .gradient-text {
            background: linear-gradient(135deg, #155DFC 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Fix premium metric cards - tetap putih karena background gradient */
        body.light-mode .premium-metric,
        body.light-mode .premium-metric .metric-label,
        body.light-mode .premium-metric .metric-value,
        body.light-mode .premium-metric .metric-trend,
        body.light-mode .premium-metric .metric-trend span,
        body.light-mode .premium-metric .metric-icon {
            color: #ffffff !important;
        }
        
        /* Fix stat-card background untuk light mode */
        body.light-mode .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
        }
        
        /* Fix premium-table-card */
        body.light-mode .premium-table-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
        }
        
        body.light-mode .premium-table-card .table-header {
            background: linear-gradient(135deg, rgba(21, 93, 252, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
            border-bottom: 1px solid #e2e8f0;
        }
        
        body.light-mode .premium-table thead th {
            background: #f8fafc !important;
            color: #1e293b !important;
        }
        
        body.light-mode .premium-table tbody tr:hover {
            background: rgba(21, 93, 252, 0.05) !important;
        }
        
        /* Fix semua link dalam tabel */
        body.light-mode .table a:not(.btn) {
            color: #155DFC !important;
        }
        
        /* Fix code tag */
        body.light-mode code {
            background: #f1f5f9 !important;
            color: #0f172a !important;
        }

        body.light-mode code {
            background: #f1f5f9 !important;
            color: #0f172a !important;
        }

        /* ============================================
           SWEETALERT2 THEME OVERRIDES
           ============================================ */
        
        /* Default Dark Mode */
        div.swal2-popup {
            background: #1e293b !important;
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        div.swal2-title, div.swal2-content, div.swal2-html-container {
            color: #fff !important;
        }

        /* Light Mode Overrides */
        body.light-mode div.swal2-popup {
            background: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        
        body.light-mode div.swal2-title, 
        body.light-mode div.swal2-content, 
        body.light-mode div.swal2-html-container {
            color: #1e293b !important;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            margin: 0;
            line-height: 1.6;
        }

        /* Subtle Grid Background */
        .bg-grid {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: -2;
            pointer-events: none;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--card-border);
            z-index: 1040;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.2);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--card-border);
            white-space: nowrap;
            background: rgba(0, 0, 0, 0.2);
        }

        .logo-icon {
            min-width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 12px;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }

        .logo-text {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--text-main);
            letter-spacing: 0.5px;
            opacity: 1;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            pointer-events: none;
            display: none;
        }

        .sidebar-menu {
            flex: 1;
            padding: 1.5rem 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.9rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            white-space: nowrap;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .nav-link.active {
            color: #fff;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            font-weight: 600;
        }

        .nav-link i {
            font-size: 1.25rem;
            min-width: 24px;
            display: flex;
            justify-content: center;
            margin-right: 12px;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }
        
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.9rem 0;
        }
        
        .sidebar.collapsed .nav-link:hover {
            transform: none;
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        /* Sidebar Heading */
        .sidebar-heading {
            color: var(--text-dim);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 0 1rem;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .sidebar-heading {
            opacity: 0;
            display: none;
        }

        /* Utility Overrides for Dark Theme */
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .text-white {
            color: var(--text-main) !important;
        }
        
        .text-secondary {
            color: var(--secondary) !important;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding-top: calc(var(--header-height) + 2rem);
        }

        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            background: rgba(15, 23, 42, 0.95); /* High opacity for readability */
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--card-border);
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed + .main-content .top-navbar, 
        body.sidebar-collapsed .top-navbar { 
            left: var(--sidebar-collapsed-width);
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--card-border);
            padding: 1.25rem 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }

        /* Tables - High Contrast */
        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-muted);
            --bs-table-border-color: var(--card-border);
            margin-bottom: 0;
        }
        
        .table th {
            color: var(--text-main);
            font-weight: 600;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 2px solid var(--card-border);
            padding: 1rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .table td {
            vertical-align: middle;
            padding: 1rem;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-main); /* Brighter text for data */
        }
        
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }

        /* Badges - High Contrast for Dark Backgrounds */
        .badge {
            font-weight: 600;
            padding: 0.5em 0.8em;
            letter-spacing: 0.025em;
            border-radius: 6px;
        }
        
        /* Bright, vibrant colors that stand out on dark backgrounds */
        .bg-success-subtle { 
            background-color: rgba(34, 197, 94, 0.25) !important; 
            color: #6ee7b7 !important; /* Bright green */
            border: 1px solid rgba(34, 197, 94, 0.4);
        }
        .bg-warning-subtle { 
            background-color: rgba(234, 179, 8, 0.25) !important; 
            color: #fde047 !important; /* Bright yellow */
            border: 1px solid rgba(234, 179, 8, 0.4);
        }
        .bg-danger-subtle { 
            background-color: rgba(239, 68, 68, 0.25) !important; 
            color: #fca5a5 !important; /* Bright red */
            border: 1px solid rgba(239, 68, 68, 0.4);
        }
        .bg-primary-subtle { 
            background-color: rgba(99, 102, 241, 0.25) !important; 
            color: #a5b4fc !important; /* Bright indigo */
            border: 1px solid rgba(99, 102, 241, 0.4);
        }
        .bg-secondary-subtle { 
            background-color: rgba(148, 163, 184, 0.25) !important; 
            color: #e0e7ff !important; /* Bright slate */
            border: 1px solid rgba(148, 163, 184, 0.4);
        }
        .bg-info-subtle { 
            background-color: rgba(6, 182, 212, 0.25) !important; 
            color: #67e8f9 !important; /* Bright cyan */
            border: 1px solid rgba(6, 182, 212, 0.4);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        /* Pagination Styles */
        .pagination {
            margin: 0;
            gap: 0.25rem;
        }
        
        .pagination .page-link {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--card-border);
            color: var(--text-muted);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        
        .pagination .page-link:hover:not(.disabled) {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            border-color: var(--primary);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: transparent;
        }

        .pagination .page-link svg {
            width: 14px;
            height: 14px;
            vertical-align: middle;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .top-navbar {
                left: 0 !important;
            }
            
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.7); /* Darker overlay */
                backdrop-filter: blur(4px);
                z-index: 1035;
                display: none;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        /* Form Controls Dark Theme */
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: var(--card-border);
            color: var(--text-main);
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
            color: var(--text-main);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        }
        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }
        .input-group-text {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--card-border);
            color: var(--text-main);
        }

        /* Ensure text is readable in all containers */
        .card, .modal-content, .dropdown-menu {
            color: var(--text-main);
        }
        
        /* ========================================
           MODERN PROFILE DROPDOWN STYLES
           ======================================== */
        
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px 6px 6px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 220px;
            max-width: 260px;
            justify-content: space-between;
            position: relative;
            z-index: 1061;
        }

        .user-dropdown.show .user-dropdown-toggle {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.1);
            border-bottom-color: #1e293b;
        }
        
        .user-dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.25);
        }
        
        .user-avatar {
            position: relative;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-avatar span {
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }
        
        .status-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #22c55e;
            border: 2px solid #1e293b;
            border-radius: 50%;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 1.2;
            flex: 1;
            min-width: 0;
        }
        
        .user-name {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }
        
        .user-role {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }
        
        .chevron-icon {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }
        
        .user-dropdown.show .chevron-icon {
            transform: rotate(180deg);
        }
        
        /* Profile Dropdown Menu */
        .profile-dropdown {
            position: absolute !important;
            inset: auto !important;
            transform: none !important;
            top: 100% !important;
            margin-top: -1px;
            width: 100%;
            padding: 0;
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 
                        0 0 0 1px rgba(255, 255, 255, 0.05);
            overflow: hidden;
            z-index: 1060;
        }
        

        

        
        /* Profile Menu */
        .profile-menu {
            padding: 4px;
        }
        
        .profile-menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .profile-menu-item:hover {
            background: rgba(255, 255, 255, 0.08);
        }
        
        .menu-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }
        
        .profile-menu-item:hover .menu-icon {
            background: rgba(59, 130, 246, 0.25);
            transform: scale(1.05);
        }
        
        .menu-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .menu-title {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .menu-desc {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.75rem;
            margin-top: 2px;
        }
        
        .menu-arrow {
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }
        
        .profile-menu-item:hover .menu-arrow {
            color: rgba(255, 255, 255, 0.6);
            transform: translateX(3px);
        }
        
        /* Theme Toggle Section */
        .theme-toggle-section {
            padding: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .theme-toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        
        .theme-toggle-wrapper:hover {
            background: rgba(255, 255, 255, 0.08);
        }
        
        .theme-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(234, 179, 8, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fbbf24;
            font-size: 1.1rem;
        }
        
        .theme-label {
            flex: 1;
            color: white;
            font-weight: 500;
            font-size: 0.8rem;
            white-space: nowrap;
        }
        
        /* Custom Toggle Switch */
        .theme-switch {
            position: relative;
            width: 32px;
            height: 18px;
        }
        
        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .theme-switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 18px;
            transition: all 0.3s ease;
        }
        
        .theme-switch .slider:before {
            position: absolute;
            content: "";
            height: 12px;
            width: 12px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        
        .theme-switch input:checked + .slider {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        }
        
        .theme-switch input:checked + .slider:before {
            transform: translateX(14px);
        }
        
        /* Profile Footer */
        .profile-footer {
            padding: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 8px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            color: #f87171;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.4);
            color: #fca5a5;
        }
        
        /* Light Mode Overrides for Profile Dropdown */
        body.light-mode .user-dropdown-toggle {
            background: rgba(255, 255, 255, 0.9);
            border-color: #e2e8f0;
            color: #0f172a;
        }
        
        body.light-mode .user-dropdown-toggle:hover {
            background: #ffffff;
            border-color: #cbd5e1;
        }

        body.light-mode .user-dropdown.show .user-dropdown-toggle {
            background: #ffffff;
            border-color: #e2e8f0;
            border-bottom-color: #ffffff; /* Seamless blend with dropdown */
            color: #0f172a;
        }
        
        body.light-mode .top-navbar .user-dropdown-toggle .user-name {
            color: #0f172a !important;
        }
        
        body.light-mode .top-navbar .user-dropdown-toggle .user-role {
            color: #64748b !important;
        }
        
        body.light-mode .top-navbar .user-dropdown-toggle .chevron-icon {
            color: #64748b !important;
        }
        
        body.light-mode .status-dot {
            border-color: #ffffff;
        }
        
        body.light-mode .profile-dropdown {
            background: #ffffff;
            border-color: #e2e8f0;
            border-top: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        body.light-mode .profile-menu-item:hover {
            background: #f1f5f9;
        }
        
        body.light-mode .menu-title {
            color: #0f172a;
            text-shadow: none;
        }
        
        body.light-mode .menu-desc {
            color: #64748b;
        }
        
        body.light-mode .menu-arrow {
            color: #94a3b8;
        }
        
        body.light-mode .theme-toggle-section,
        body.light-mode .profile-footer {
            border-top-color: #e2e8f0;
        }
        
        body.light-mode .theme-toggle-wrapper:hover {
            background: #f1f5f9;
        }
        
        body.light-mode .theme-label {
            color: #0f172a;
            text-shadow: none;
        }
        
        body.light-mode .theme-switch .slider {
            background: #e2e8f0;
        }
        
        body.light-mode .logout-btn {
            background: #fee2e2;
            border-color: #fecaca;
            color: #ef4444;
            text-shadow: none;
        }
        
        body.light-mode .logout-btn:hover {
            background: #fecaca;
            color: #dc2626;
        }
        
        /* Mobile Responsive */
        @media (max-width: 767.98px) {
            .profile-dropdown {
                position: fixed !important;
                right: 10px !important;
                left: 10px !important;
                top: calc(var(--header-height) + 10px) !important;
                width: auto;
                max-width: none;
            }
            
            .user-dropdown-toggle {
                min-width: auto; /* Allow shrinking on mobile */
                max-width: 200px; /* Limit width */
                padding-right: 8px;
            }
            
            .user-info {
                display: flex !important; /* Force show */
            }
            
            .user-name {
                max-width: 100px; /* Truncate name if too long */
            }
            
            body.light-mode .user-name,
            body.light-mode .user-role {
                color: #0f172a !important;
            }
        }
        
        /* Fix for specific text-dark usages that might be on dark background */
        /* We target text-dark that is NOT inside a badge, alert, or light background */
        body:not(.bg-light):not(.bg-white) .text-dark:not(.badge):not(.alert):not(.btn):not(.bg-white):not(.bg-light):not(.bg-warning) {
            color: var(--text-muted) !important;
        }
        
        /* Prevent dark navy/blue colors on badges that would blend with background */
        .badge.bg-dark, .badge[style*="background-color: #1e293b"], 
        .badge[style*="background-color: #0f172a"],
        .badge[style*="background: #1e293b"],
        .badge[style*="background: #0f172a"] {
            background-color: rgba(99, 102, 241, 0.3) !important;
            color: #a5b4fc !important;
            border: 1px solid rgba(99, 102, 241, 0.5);
        }
        
        /* Ensure no text uses colors similar to background */
        .text-navy, .text-slate-900, .text-slate-800,
        [style*="color: #0f172a"], [style*="color: #1e293b"],
        [style*="color: #003087"] {
            color: var(--text-main) !important;
        }
        
        /* Override Bootstrap default badge colors for better contrast */
        .badge.bg-dark {
            background-color: rgba(71, 85, 105, 0.4) !important;
            color: #e2e8f0 !important;
        }
        
        .badge.bg-primary {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }
        
        .badge.bg-info {
            background-color: var(--secondary) !important;
            color: #ffffff !important;
        }

        /* Global Search Styles */
        .global-search-container .form-control {
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 0 8px 8px 0;
        }
        
        .global-search-container .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .global-search-container .form-control:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
        
        .global-search-container .input-group-text {
            border-radius: 8px 0 0 8px;
        }

        /* Search Suggestions Dropdown */
        .search-suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            margin-top: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 1050;
            display: none;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .search-suggestions-dropdown.show {
            display: block;
            animation: fadeInDown 0.2s ease;
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .search-suggestion-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            color: var(--text-main);
            border-bottom: 1px solid var(--card-border);
        }
        
        .search-suggestion-item:last-child {
            border-bottom: none;
        }
        
        .search-suggestion-item:hover {
            background: rgba(59, 130, 246, 0.1);
        }
        
        .search-suggestion-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.2rem;
        }
        
        .search-suggestion-icon.unit { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        .search-suggestion-icon.game { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
        .search-suggestion-icon.accessory { background: rgba(234, 179, 8, 0.2); color: #eab308; }
        
        .search-suggestion-text {
            flex: 1;
        }
        
        .search-suggestion-text strong {
            display: block;
            font-weight: 600;
        }
        
        .search-suggestion-text small {
            color: var(--text-muted);
        }
        
        .search-no-results {
            padding: 20px;
            text-align: center;
            color: var(--text-muted);
        }
        
        .search-loading {
            padding: 20px;
            text-align: center;
        }
        
        .search-footer {
            padding: 12px 16px;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid var(--card-border);
            text-align: center;
            border-radius: 0 0 12px 12px;
        }
        
        .search-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .search-footer a:hover {
            text-decoration: underline;
        }

        /* Light Mode Search Styles */
        body.light-mode .global-search-form .form-control {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #0f172a !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
        
        body.light-mode .global-search-form .form-control::placeholder {
            color: rgba(15, 23, 42, 0.5) !important;
        }
        
        body.light-mode .global-search-form .input-group-text {
            background: rgba(255, 255, 255, 0.9) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
        
        body.light-mode .global-search-form .input-group-text i {
            color: #64748b !important;
            opacity: 1 !important;
        }
        
        body.light-mode .search-suggestions-dropdown {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        
        body.light-mode .search-suggestion-item {
            color: #0f172a;
            border-bottom-color: #e2e8f0;
        }
        
        body.light-mode .search-suggestion-item:hover {
            background: rgba(21, 93, 252, 0.08);
        }
        
        body.light-mode .search-suggestion-text small {
            color: #64748b;
        }
        
        body.light-mode .search-footer {
            background: #f8fafc;
            border-top-color: #e2e8f0;
        }
        /* FORCE SIDEBAR TEXT WHITE GLOWING */
        body.light-mode .sidebar,
        body.light-mode .sidebar * {
            color: #ffffff !important;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        body.light-mode .sidebar .nav-link {
            color: #ffffff !important;
        }

        body.light-mode .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1) !important;
        }

        body.light-mode .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.4) !important;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8) !important;
            font-weight: 700 !important;
        }

        /* GLOBAL OVERRIDE FOR USERNAME VISIBILITY */
        body.light-mode .user-name,
        body.light-mode .user-role {
            color: #0f172a !important;
            text-shadow: none !important;
        }
        
        body.light-mode .sidebar-heading {
            color: rgba(255, 255, 255, 0.9) !important;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.3) !important;
        }

        body.light-mode .logo-text {
            color: #ffffff !important;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.6) !important;
        }
        
        /* Fix for specific text-danger or other utility classes in sidebar */
        body.light-mode .sidebar .text-danger {
            color: #ffffff !important;
        }

        /* FIX: Restore Logo Icon Color (Blue on White) */
        body.light-mode .sidebar .logo-icon,
        body.light-mode .sidebar .logo-icon i {
            color: #155DFC !important;
            text-shadow: none !important;
        }
        /* ULTRA SPECIFIC OVERRIDE FOR USERNAME */
        html body.light-mode header.top-navbar .user-dropdown-toggle .user-name,
        html body.light-mode header.top-navbar .user-dropdown-toggle .user-role {
            color: #0f172a !important;
            text-shadow: none !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        html body.light-mode header.top-navbar .user-dropdown-toggle .chevron-icon {
            color: #64748b !important;
        }
        
        /* ID-BASED OVERRIDE (HIGHEST SPECIFICITY) */
        body.light-mode #topNavbar .user-name,
        body.light-mode #topNavbar .user-role {
            color: #0f172a !important;
            text-shadow: none !important;
        }
    </style>
    @yield('styles')
    @stack('styles')

</head>
<body>
    <div class="bg-grid"></div>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="bi bi-controller"></i>
            </div>
            <span class="logo-text">RentalPS</span>
        </div>
        
        <nav class="sidebar-menu">
            @yield('sidebar_menu')
            
            <div class="mt-auto pt-4 border-top border-white border-opacity-10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-link w-100 text-start border-0 bg-transparent text-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Top Navbar -->
    <!-- Top Navbar -->
    <header class="top-navbar d-flex align-items-center justify-content-between px-3 px-md-4" id="topNavbar">
        <!-- Left Section: Toggle Button -->
        <div class="d-flex align-items-center">
            <button class="toggle-btn" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Center Section: Search Bar -->
        <div class="d-none d-md-block w-100 position-relative mx-auto" style="max-width: 400px;">
            <form action="{{ route('search') }}" method="GET" class="global-search-form">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255,255,255,0.2);">
                        <i class="bi bi-search text-white-50"></i>
                    </span>
                    <input type="text" 
                           name="q" 
                           class="form-control bg-transparent border-start-0 text-white placeholder-white-50" 
                           placeholder="Cari PS, game, aksesoris..." 
                           autocomplete="off"
                           id="globalSearchInput">
                </div>
            </form>
            <div id="searchSuggestions" class="search-suggestions-dropdown d-none"></div>
        </div>
        
        <!-- Mobile Search Button (Visible only on small screens) -->
        <a href="{{ route('search') }}" class="toggle-btn d-md-none ms-auto me-2" title="Cari">
            <i class="bi bi-search"></i>
        </a>
        
        <!-- Right Section: User Dropdown -->
        <div class="d-flex align-items-center justify-content-end gap-3">
            <!-- User Dropdown -->
            <div class="dropdown user-dropdown">
                <button class="user-dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                        @else
                            <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                        <div class="status-dot"></div>
                    </div>
                    <div class="user-info">
                        <span class="user-name" style="color: var(--text-main) !important;">{{ Auth::user()->name }}</span>
                        <span class="user-role" style="color: var(--text-muted) !important;">{{ ucfirst(Auth::user()->role ?? 'Pelanggan') }}</span>
                    </div>
                    <i class="bi bi-chevron-down chevron-icon" style="color: var(--text-muted) !important;"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-end profile-dropdown">

                    
                    <!-- Menu Items -->
                    <div class="profile-menu">
                        <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                            <div class="menu-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="menu-content">
                                <span class="menu-title">Profil Saya</span>
                                <span class="menu-desc">Kelola informasi akun</span>
                            </div>
                            <i class="bi bi-chevron-right menu-arrow"></i>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}#password" class="profile-menu-item">
                            <div class="menu-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <div class="menu-content">
                                <span class="menu-title">Keamanan</span>
                                <span class="menu-desc">Password & keamanan</span>
                            </div>
                            <i class="bi bi-chevron-right menu-arrow"></i>
                        </a>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <div class="theme-toggle-section">
                        <div class="theme-toggle-wrapper" id="themeToggleDropdown">
                            <div class="theme-icon">
                                <i class="bi bi-moon-stars"></i>
                            </div>
                            <span class="theme-label">Mode Gelap</span>
                            <label class="theme-switch">
                                <input type="checkbox" id="themeSwitchCheck">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Logout -->
                    <div class="profile-footer">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const topNavbar = document.getElementById('topNavbar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            const body = document.body;

            // Check local storage for preference
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed && window.innerWidth >= 992) {
                sidebar.classList.add('collapsed');
                body.classList.add('sidebar-collapsed');
                // Adjust navbar position manually since CSS variable dependency in calc() might lag
                topNavbar.style.left = 'var(--sidebar-collapsed-width)';
            }

            function toggleSidebar() {
                if (window.innerWidth >= 992) {
                    // Desktop: Collapse/Expand
                    sidebar.classList.toggle('collapsed');
                    body.classList.toggle('sidebar-collapsed');
                    
                    const collapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebar-collapsed', collapsed);
                    
                    // Update navbar position
                    if (collapsed) {
                        topNavbar.style.left = 'var(--sidebar-collapsed-width)';
                    } else {
                        topNavbar.style.left = 'var(--sidebar-width)';
                    }
                } else {
                    // Mobile: Show/Hide
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            }

            toggleBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Handle resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    
                    // Restore collapsed state
                    if (localStorage.getItem('sidebar-collapsed') === 'true') {
                        sidebar.classList.add('collapsed');
                        topNavbar.style.left = 'var(--sidebar-collapsed-width)';
                    } else {
                        sidebar.classList.remove('collapsed');
                        topNavbar.style.left = 'var(--sidebar-width)';
                    }
                } else {
                    sidebar.classList.remove('collapsed');
                    topNavbar.style.left = '0';
                }
            });


            // Theme Toggle Logic
        const themeToggleDropdown = document.getElementById('themeToggleDropdown');
        const themeSwitchCheck = document.getElementById('themeSwitchCheck');
        
        // Check local storage
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'light') {
            body.classList.add('light-mode');
            if(themeSwitchCheck) themeSwitchCheck.checked = true;
        }

        function toggleTheme(e) {
            if(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            body.classList.toggle('light-mode');
            const isLight = body.classList.contains('light-mode');
            
            // Update switch state
            if(themeSwitchCheck) themeSwitchCheck.checked = isLight;
            
            // Save preference
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            
            // Show toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            
            Toast.fire({
                icon: isLight ? 'info' : 'success',
                title: isLight ? 'Light Mode Activated' : 'Dark Mode Activated'
            });
        }

        if (themeToggleDropdown) {
            themeToggleDropdown.addEventListener('click', toggleTheme);
        }
        
        // Also handle direct clicks on the switch input
        if (themeSwitchCheck) {
            themeSwitchCheck.addEventListener('change', toggleTheme);
            themeSwitchCheck.addEventListener('click', (e) => e.stopPropagation());
        }
        });

        // Global Flash Message Function using SweetAlert2
        function showFlashMessage(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                timerProgressBar: true,
                // background and color removed to allow CSS styling
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }

        // Global Confirm Action Helper
        function confirmAction(message, formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6', // Primary blue color
                cancelButtonColor: '#ef4444', // Danger color
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal',
                // background and color removed to allow CSS styling
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
            return false;
        }

        // Global Semantic Search Autocomplete
        (function() {
            const searchInput = document.getElementById('globalSearchInput');
            const suggestionsDropdown = document.getElementById('searchSuggestions');
            
            if (!searchInput || !suggestionsDropdown) return;
            
            let debounceTimer;
            let currentQuery = '';
            
            // Debounced search function
            function performSearch(query) {
                if (query.length < 2) {
                    hideSuggestions();
                    return;
                }
                
                // Show loading state
                suggestionsDropdown.innerHTML = `
                    <div class="search-loading">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2 text-muted">Mencari...</span>
                    </div>
                `;
                showSuggestions();
                
                fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (currentQuery !== query) return; // Query changed, ignore results
                        
                        if (data.length === 0) {
                            suggestionsDropdown.innerHTML = `
                                <div class="search-no-results">
                                    <i class="bi bi-search text-muted mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0">Tidak ada hasil untuk "${query}"</p>
                                    <small class="text-muted">Coba kata kunci lain</small>
                                </div>
                                <div class="search-footer">
                                    <a href="{{ route('search') }}?q=${encodeURIComponent(query)}">
                                        <i class="bi bi-arrow-right-circle me-1"></i>
                                        Lihat semua hasil pencarian
                                    </a>
                                </div>
                            `;
                        } else {
                            let html = '';
                            data.forEach(item => {
                                html += `
                                    <a href="${item.url}" class="search-suggestion-item">
                                        <div class="search-suggestion-icon ${item.type}">
                                            <i class="bi ${item.icon}"></i>
                                        </div>
                                        <div class="search-suggestion-text">
                                            <strong>${escapeHtml(item.text)}</strong>
                                            <small>${escapeHtml(item.subtext)}</small>
                                        </div>
                                    </a>
                                `;
                            });
                            html += `
                                <div class="search-footer">
                                    <a href="{{ route('search') }}?q=${encodeURIComponent(query)}">
                                        <i class="bi bi-arrow-right-circle me-1"></i>
                                        Lihat semua hasil untuk "${escapeHtml(query)}"
                                    </a>
                                </div>
                            `;
                            suggestionsDropdown.innerHTML = html;
                        }
                        showSuggestions();
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        hideSuggestions();
                    });
            }
            
            function showSuggestions() {
                suggestionsDropdown.classList.add('show');
            }
            
            function hideSuggestions() {
                suggestionsDropdown.classList.remove('show');
            }
            
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Event listeners
            searchInput.addEventListener('input', function(e) {
                currentQuery = e.target.value.trim();
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => performSearch(currentQuery), 300);
            });
            
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    showSuggestions();
                }
            });
            
            // Close suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.global-search-container')) {
                    hideSuggestions();
                }
            });
            
            // Keyboard navigation
            searchInput.addEventListener('keydown', function(e) {
                const items = suggestionsDropdown.querySelectorAll('.search-suggestion-item');
                const activeItem = suggestionsDropdown.querySelector('.search-suggestion-item.active');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (!activeItem && items.length > 0) {
                        items[0].classList.add('active');
                        items[0].focus();
                    } else if (activeItem && activeItem.nextElementSibling?.classList.contains('search-suggestion-item')) {
                        activeItem.classList.remove('active');
                        activeItem.nextElementSibling.classList.add('active');
                        activeItem.nextElementSibling.focus();
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (activeItem && activeItem.previousElementSibling?.classList.contains('search-suggestion-item')) {
                        activeItem.classList.remove('active');
                        activeItem.previousElementSibling.classList.add('active');
                        activeItem.previousElementSibling.focus();
                    }
                } else if (e.key === 'Escape') {
                    hideSuggestions();
                    searchInput.blur();
                }
            });
        })();
    </script>
    @yield('scripts')
</body>
</html>
