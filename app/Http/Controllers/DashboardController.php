<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\UnitPS;
use App\Models\Game;
use App\Models\Accessory;
use App\Models\RentalItem;
use App\Models\Rental;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function admin()
    {
        Gate::authorize('access-admin');
        
        // Gunakan eager loading dan aggregasi untuk meningkatkan performa
        $unitPSData = UnitPS::selectRaw('*, COALESCE(stock, 0) as total_stok')->get();
        $gameData = Game::selectRaw('*, COALESCE(stok, 0) as total_stok')->get();
        $accessoryData = Accessory::selectRaw('*, COALESCE(stok, 0) as total_stok')->get();
        
        $unitAvailable = $unitPSData->sum('total_stok');
        $unitRented = RentalItem::whereHas('rental', function ($q) { $q->whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi']); })
            ->where('rentable_type', UnitPS::class)
            ->sum('quantity');
        // Count damaged: from kondisi field OR from rental items returned as rusak
        $unitDamagedFromKondisi = UnitPS::where('kondisi', 'rusak')->count();
        $unitDamagedFromRental = RentalItem::where('rentable_type', UnitPS::class)
            ->where('kondisi_kembali', 'rusak')
            ->count();
        $unitDamaged = $unitDamagedFromKondisi + $unitDamagedFromRental;
        $unitTotal = $unitAvailable + $unitRented;

        $gameAvailable = $gameData->sum('total_stok');
        $gameRented = RentalItem::whereHas('rental', function ($q) { $q->whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi']); })
            ->where('rentable_type', Game::class)
            ->sum('quantity');
        $gameDamagedFromKondisi = Game::where('kondisi', 'rusak')->count();
        $gameDamagedFromRental = RentalItem::where('rentable_type', Game::class)
            ->where('kondisi_kembali', 'rusak')
            ->count();
        $gameDamaged = $gameDamagedFromKondisi + $gameDamagedFromRental;
        $gameTotal = $gameAvailable + $gameRented;

        $accAvailable = $accessoryData->sum('total_stok');
        $accRented = RentalItem::whereHas('rental', function ($q) { $q->whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi']); })
            ->where('rentable_type', Accessory::class)
            ->sum('quantity');
        $accDamagedFromKondisi = Accessory::where('kondisi', 'rusak')->count();
        $accDamagedFromRental = RentalItem::where('rentable_type', Accessory::class)
            ->where('kondisi_kembali', 'rusak')
            ->count();
        $accDamaged = $accDamagedFromKondisi + $accDamagedFromRental;
        $accTotal = $accAvailable + $accRented;

        // Ambil rental yang aktif untuk menghitung jumlah sewa per item
        $activeRentalItems = RentalItem::whereHas('rental', function ($q) { $q->whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi']); })
            ->whereIn('rentable_type', [UnitPS::class, Game::class, Accessory::class])
            ->selectRaw('rentable_type, rentable_id, SUM(quantity) as total_rented')
            ->groupBy('rentable_type', 'rentable_id')
            ->get()
            ->keyBy(function($item) {
                return $item->rentable_type . '_' . $item->rentable_id;
            });

        // Get damaged count per item from rental_items
        $damagedPerUnit = RentalItem::where('rentable_type', UnitPS::class)
            ->where('kondisi_kembali', 'rusak')
            ->selectRaw('rentable_id, COUNT(*) as damaged_count')
            ->groupBy('rentable_id')
            ->pluck('damaged_count', 'rentable_id')
            ->toArray();
            
        $damagedPerGame = RentalItem::where('rentable_type', Game::class)
            ->where('kondisi_kembali', 'rusak')
            ->selectRaw('rentable_id, COUNT(*) as damaged_count')
            ->groupBy('rentable_id')
            ->pluck('damaged_count', 'rentable_id')
            ->toArray();
            
        $damagedPerAcc = RentalItem::where('rentable_type', Accessory::class)
            ->where('kondisi_kembali', 'rusak')
            ->selectRaw('rentable_id, COUNT(*) as damaged_count')
            ->groupBy('rentable_id')
            ->pluck('damaged_count', 'rentable_id')
            ->toArray();

        // Optimasi data detail UnitPS
        $unitps = $unitPSData->map(function($unit) use ($activeRentalItems, $damagedPerUnit) {
            $key = UnitPS::class . '_' . $unit->id;
            $rentedCount = $activeRentalItems->has($key) ? $activeRentalItems->get($key)->total_rented : 0;
            $isRusak = ($unit->kondisi ?? 'baik') === 'rusak';
            $damagedFromRental = $damagedPerUnit[$unit->id] ?? 0;
            $totalDamaged = ($isRusak ? 1 : 0) + $damagedFromRental;
            
            return [
                'nama' => $unit->name,
                'model' => $unit->model,
                'merek' => $unit->brand,
                'stok' => $unit->total_stok,
                'kondisi' => $unit->kondisi ?? 'baik',
                'kondisi_baik' => $isRusak ? 0 : $unit->total_stok,
                'kondisi_buruk' => $totalDamaged,
                'disewa' => $rentedCount,
                'tersedia' => $unit->total_stok - $rentedCount,
                'nomor_seri' => $unit->serial_number ?? '-'
            ];
        });
        
        // Optimasi data detail Games
        $games = $gameData->map(function($game) use ($activeRentalItems, $damagedPerGame) {
            $key = Game::class . '_' . $game->id;
            $rentedCount = $activeRentalItems->has($key) ? $activeRentalItems->get($key)->total_rented : 0;
            $isRusak = ($game->kondisi ?? 'baik') === 'rusak';
            $damagedFromRental = $damagedPerGame[$game->id] ?? 0;
            $totalDamaged = ($isRusak ? 1 : 0) + $damagedFromRental;
            
            return [
                'judul' => $game->judul,
                'platform' => $game->platform,
                'genre' => $game->genre,
                'stok' => $game->total_stok,
                'kondisi' => $game->kondisi ?? 'baik',
                'kondisi_baik' => $isRusak ? 0 : $game->total_stok,
                'kondisi_buruk' => $totalDamaged,
                'disewa' => $rentedCount,
                'tersedia' => $game->total_stok - $rentedCount
            ];
        });
        
        // Optimasi data detail Aksesoris
        $accessories = $accessoryData->map(function($acc) use ($activeRentalItems, $damagedPerAcc) {
            $key = Accessory::class . '_' . $acc->id;
            $rentedCount = $activeRentalItems->has($key) ? $activeRentalItems->get($key)->total_rented : 0;
            $isRusak = ($acc->kondisi ?? 'baik') === 'rusak';
            $damagedFromRental = $damagedPerAcc[$acc->id] ?? 0;
            $totalDamaged = ($isRusak ? 1 : 0) + $damagedFromRental;
            
            return [
                'nama' => $acc->nama,
                'jenis' => $acc->jenis,
                'stok' => $acc->total_stok,
                'kondisi' => $acc->kondisi ?? 'baik',
                'kondisi_baik' => $isRusak ? 0 : $acc->total_stok,
                'kondisi_buruk' => $totalDamaged,
                'disewa' => $rentedCount,
                'tersedia' => $acc->total_stok - $rentedCount
            ];
        });
        
        $stats = [
            ['name' => 'Unit PS', 'total' => $unitTotal, 'available' => $unitAvailable, 'rented' => $unitRented, 'damaged' => $unitDamaged],
            ['name' => 'Game', 'total' => $gameTotal, 'available' => $gameAvailable, 'rented' => $gameRented, 'damaged' => $gameDamaged],
            ['name' => 'Aksesoris', 'total' => $accTotal, 'available' => $accAvailable, 'rented' => $accRented, 'damaged' => $accDamaged],
        ];

        return view('dashboards.admin', compact('stats', 'unitps', 'games', 'accessories'));
    }

    public function kasir()
    {
        Gate::authorize('access-kasir');
        
        // Statistics
        $unpaidCount = Rental::whereColumn('paid', '<', 'total')
            ->where('status', '!=', 'cancelled')
            ->count();
            
        $activeCount = Rental::whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi'])
            ->count();
            
        $completedTodayCount = Rental::where('status', 'selesai')
            ->whereDate('returned_at', now()->today())
            ->count();

        $rentals = Rental::with(['customer','items.rentable'])
            ->orderByDesc('created_at')
            ->paginate(10);
            
        return view('dashboards.kasir', compact('rentals', 'unpaidCount', 'activeCount', 'completedTodayCount'));
    }

    public function pemilik()
    {
        Gate::authorize('access-pemilik');
        
        // KPI Cards Data
        $availableUnits = UnitPS::sum('stock');
        $availableGames = Game::sum('stok');
        $availableAccessories = Accessory::sum('stok');
        $todaysTransactions = Rental::whereDate('created_at', now()->toDateString())->count();

        // Damaged Items Count
        $damagedUnits = UnitPS::where('kondisi', 'rusak')->count();
        $damagedGames = Game::where('kondisi', 'rusak')->count();
        $damagedAccessories = Accessory::where('kondisi', 'rusak')->count();
        $totalDamaged = $damagedUnits + $damagedGames + $damagedAccessories;

        // Revenue 7 Days (Simple Calculation for KPI Card)
        $start = now()->copy()->subDays(6)->startOfDay();
        $end = now()->endOfDay();
        $revTotal7 = Payment::whereBetween('paid_at', [$start, $end])->sum('amount');

        // Recent Transactions (Limit 5 for Dashboard)
        $recentTransactions = Rental::with(['customer', 'items.rentable'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboards.pemilik', compact(
            'availableUnits', 
            'availableGames',
            'availableAccessories',
            'todaysTransactions', 
            'revTotal7', 
            'recentTransactions',
            'damagedUnits',
            'damagedGames',
            'damagedAccessories',
            'totalDamaged'
        ));
    }

    public function pelanggan()
    {
        Gate::authorize('access-pelanggan');
        
        // Get latest available items with stock > 0 for display on landing page
        $unitps = UnitPS::where('stock', '>', 0)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
            
        $games = Game::where('stok', '>', 0)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
            
        $accessories = Accessory::where('stok', '>', 0)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
            
        return view('dashboards.pelanggan', compact('unitps', 'games', 'accessories'));
    }
    
    public function unitpsLanding()
    {
        Gate::authorize('access-pelanggan');
        
        // Get latest available Unit PS with stock > 0 for display on Unit PS landing page
        $unitps = UnitPS::where('stock', '>', 0)
            ->orderByDesc('id')
            ->get(); // Get all available units
            
        return view('dashboards.unitps', compact('unitps'));
    }
    
    public function gameLanding()
    {
        Gate::authorize('access-pelanggan');
        
        // Get latest available Games with stock > 0 for display on Game landing page
        $games = Game::where('stok', '>', 0)
            ->orderByDesc('id')
            ->get(); // Get all available games, not just 6
            
        return view('dashboards.game', compact('games'));
    }
    
    public function accessoryLanding()
    {
        Gate::authorize('access-pelanggan');
        
        // Get latest available Accessories with stock > 0 for display on Accessory landing page
        $accessories = Accessory::where('stok', '>', 0)
            ->orderByDesc('id')
            ->get(); // Get all available accessories, not just 6
            
        return view('dashboards.accessory', compact('accessories'));
    }

    public function adminReport()
    {
        Gate::authorize('access-admin');
        // Ringkasan pendapatan
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();
        $revenueTotal = Payment::sum('amount');
        $revenueToday = Payment::where('paid_at', '>=', $today)->sum('amount');
        $revenueMonth = Payment::where('paid_at', '>=', $monthStart)->sum('amount');

        // Ringkasan transaksi
        $rentalsTotal = Rental::count();
        $rentalsTotal = Rental::count();
        $rentalsActive = Rental::whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi'])->count();
        $rentalsReturned = Rental::where('status', 'selesai')->count();

        // Pembayaran terakhir - gunakan eager loading terbatas
        $latestPayments = Payment::with(['rental' => function($query) {
                $query->with('customer');
            }])
            ->orderByDesc('paid_at')
            ->limit(10)
            ->get();

        return view('admin.laporan.index', compact(
            'revenueTotal', 'revenueToday', 'revenueMonth',
            'rentalsTotal', 'rentalsActive', 'rentalsReturned',
            'latestPayments'
        ));
    }
}


