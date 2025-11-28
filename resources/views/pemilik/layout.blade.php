@extends('layouts.dashboard')

@section('title', 'Dashboard Pemilik')

@section('header_title', 'Panel Pemilik')

@section('sidebar_menu')
    <a href="{{ route('dashboard.pemilik') }}" class="nav-link {{ request()->routeIs('dashboard.pemilik') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2"></i>
        <span>Beranda</span>
    </a>
    
    <div class="sidebar-heading">Laporan</div>
    
    <a href="{{ route('pemilik.laporan_transaksi') }}" class="nav-link {{ request()->routeIs('pemilik.laporan_transaksi') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-text"></i>
        <span>Laporan Transaksi</span>
    </a>
    <a href="{{ route('pemilik.laporan_pendapatan') }}" class="nav-link {{ request()->routeIs('pemilik.laporan_pendapatan') ? 'active' : '' }}">
        <i class="bi bi-wallet2"></i>
        <span>Laporan Pendapatan</span>
    </a>
    
    <div class="sidebar-heading">Manajemen</div>
    
    <a href="{{ route('pemilik.status_produk') }}" class="nav-link {{ request()->routeIs('pemilik.status_produk') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>
        <span>Status Unit</span>
    </a>
    <a href="{{ route('pemilik.item_rusak') }}" class="nav-link {{ request()->routeIs('pemilik.item_rusak') ? 'active' : '' }}">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Item Rusak</span>
    </a>
    <a href="{{ route('pemilik.transaksi_dibatalkan') }}" class="nav-link {{ request()->routeIs('pemilik.transaksi_dibatalkan') ? 'active' : '' }}">
        <i class="bi bi-x-circle"></i>
        <span>Transaksi Dibatalkan</span>
    </a>
@endsection

@section('content')
    @yield('owner_content')
@endsection
