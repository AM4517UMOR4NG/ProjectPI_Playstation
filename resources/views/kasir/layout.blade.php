@extends('layouts.dashboard')

@section('title', 'Kasir Dashboard')

@section('header_title', 'Kasir Dashboard')

@section('sidebar_menu')
    <a href="{{ route('dashboard.kasir') }}" class="nav-link {{ request()->routeIs('dashboard.kasir') ? 'active' : '' }}">
        <i class="bi bi-grid"></i>
        <span>Beranda</span>
    </a>
    
    <div class="sidebar-heading">Operasional</div>
    
    <a href="{{ route('kasir.transaksi.index') }}" class="nav-link {{ request()->routeIs('kasir.transaksi.index') || request()->routeIs('kasir.transaksi.show') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i>
        <span>Transaksi</span>
    </a>
    <a href="{{ route('kasir.transaksi.cancelled') }}" class="nav-link {{ request()->routeIs('kasir.transaksi.cancelled') ? 'active' : '' }}">
        <i class="bi bi-x-circle"></i>
        <span>Transaksi Dibatalkan</span>
    </a>
    <a href="{{ route('kasir.rentals.index') }}" class="nav-link {{ request()->routeIs('kasir.rentals.*') ? 'active' : '' }}">
        <i class="bi bi-list-check"></i>
        <span>Daftar Sewa</span>
    </a>
@endsection

@section('content')
    @yield('kasir_content')
@endsection
