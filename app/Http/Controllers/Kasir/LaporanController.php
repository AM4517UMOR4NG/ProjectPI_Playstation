<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Rental;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Halaman utama laporan pemasukkan kasir
     * Menampilkan SEMUA data transaksi toko (bukan hanya yang dihandle kasir tertentu)
     */
    public function index(Request $request)
    {
        Gate::authorize('access-kasir');
        
        // Get date range from request or use defaults (last 30 days for better data)
        $dari = $request->input('dari', now()->subDays(29)->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));
        
        // Validate and parse dates
        $start = Carbon::parse($dari)->startOfDay();
        $end = Carbon::parse($sampai)->endOfDay();
        
        // ===== STATISTIK UMUM (SEMUA DATA TOKO) =====
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();
        $weekStart = now()->startOfWeek();
        
        // Total pendapatan toko
        $revenueTotal = Payment::whereNotNull('paid_at')->sum('amount');
        $revenueToday = Payment::whereNotNull('paid_at')->where('paid_at', '>=', $today)->sum('amount');
        $revenueMonth = Payment::whereNotNull('paid_at')->where('paid_at', '>=', $monthStart)->sum('amount');
        $revenueWeek = Payment::whereNotNull('paid_at')->where('paid_at', '>=', $weekStart)->sum('amount');
        
        // ===== STATISTIK TRANSAKSI =====
        $transaksiTotal = Rental::count();
        $transaksiAktif = Rental::whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi', 'paid', 'pending'])->count();
        $transaksiSelesai = Rental::where('status', 'selesai')->count();
        $transaksiBatal = Rental::where('status', 'cancelled')->count();
        
        // ===== CHART DATA: Pendapatan per hari =====
        $paymentData = Payment::whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->selectRaw('DATE(paid_at) as payment_date, SUM(amount) as total_amount')
            ->groupBy('payment_date')
            ->pluck('total_amount', 'payment_date');

        $revLabels = [];
        $revData = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->format('Y-m-d');
            $revLabels[] = $d->format('d M');
            $revData[] = (float) ($paymentData[$key] ?? 0);
        }
        
        $revenueFiltered = array_sum($revData);
        
        // ===== CHART DATA: Transaksi per status =====
        $statusData = [
            'pending' => Rental::where('status', 'pending')->count(),
            'paid' => Rental::where('status', 'paid')->count(),
            'sedang_disewa' => Rental::where('status', 'sedang_disewa')->count(),
            'menunggu_konfirmasi' => Rental::where('status', 'menunggu_konfirmasi')->count(),
            'selesai' => Rental::where('status', 'selesai')->count(),
            'cancelled' => Rental::where('status', 'cancelled')->count(),
        ];
        
        // ===== CHART DATA: Metode pembayaran =====
        $paymentMethods = Payment::whereNotNull('paid_at')
            ->selectRaw("COALESCE(NULLIF(payment_type, ''), NULLIF(method, ''), 'cash') as pay_method, SUM(amount) as total")
            ->groupBy('pay_method')
            ->pluck('total', 'pay_method')
            ->toArray();
        
        // ===== RIWAYAT PEMBAYARAN TERBARU =====
        $recentPayments = Payment::with(['rental.customer'])
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->orderByDesc('paid_at')
            ->paginate(15);
        
        // ===== TRANSAKSI AKTIF =====
        $activeRentals = Rental::with(['customer', 'items'])
            ->whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi', 'paid', 'pending'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        // ===== TRANSAKSI TERBARU =====
        $recentRentals = Rental::with(['customer', 'payments'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        // Calculate period label
        $periodDays = round($start->diffInDays($end)) + 1;
        $periodLabel = $periodDays . ' Hari';
        if ($periodDays == 1) {
            $periodLabel = $start->format('d M Y');
        } elseif ($periodDays == 7) {
            $periodLabel = '7 Hari Terakhir';
        } elseif ($periodDays == 30) {
            $periodLabel = '30 Hari Terakhir';
        }
        
        return view('kasir.laporan.index', compact(
            'revenueTotal',
            'revenueToday',
            'revenueMonth',
            'revenueWeek',
            'transaksiTotal',
            'transaksiAktif',
            'transaksiSelesai',
            'transaksiBatal',
            'revLabels',
            'revData',
            'revenueFiltered',
            'statusData',
            'paymentMethods',
            'recentPayments',
            'activeRentals',
            'recentRentals',
            'dari',
            'sampai',
            'periodLabel'
        ));
    }
    
    /**
     * API endpoint untuk real-time stats (AJAX)
     */
    public function stats()
    {
        Gate::authorize('access-kasir');
        
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();
        
        return response()->json([
            'revenue_today' => Payment::whereNotNull('paid_at')
                ->where('paid_at', '>=', $today)->sum('amount'),
            
            'revenue_month' => Payment::whereNotNull('paid_at')
                ->where('paid_at', '>=', $monthStart)->sum('amount'),
            
            'active_rentals' => Rental::whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi', 'paid', 'pending'])
                ->count(),
            
            'pending_returns' => Rental::where('status', 'menunggu_konfirmasi')
                ->count(),
            
            'timestamp' => now()->format('H:i:s'),
        ]);
    }
    
    /**
     * API endpoint untuk chart data (AJAX)
     */
    public function chartData(Request $request)
    {
        Gate::authorize('access-kasir');
        
        $days = $request->input('days', 30);
        
        $start = now()->subDays($days - 1)->startOfDay();
        $end = now()->endOfDay();
        
        $paymentData = Payment::whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->selectRaw('DATE(paid_at) as payment_date, SUM(amount) as total_amount')
            ->groupBy('payment_date')
            ->pluck('total_amount', 'payment_date');

        $labels = [];
        $data = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->format('Y-m-d');
            $labels[] = $d->format('d M');
            $data[] = (float) ($paymentData[$key] ?? 0);
        }
        
        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'total' => array_sum($data),
        ]);
    }
}
