<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\UnitPS;
use App\Models\Game;
use App\Models\Accessory;
use App\Models\RentalItem;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;

class StatusProdukController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('access-pemilik');
        
        // Get active rental IDs
        $activeRentalIds = Rental::whereIn('status', ['sedang_disewa', 'menunggu_konfirmasi'])->pluck('id');
        
        // Get rented quantities grouped by item
        $rentedUnits = RentalItem::where('rentable_type', UnitPS::class)
            ->whereIn('rental_id', $activeRentalIds)
            ->select('rentable_id', DB::raw('SUM(quantity) as total_rented'))
            ->groupBy('rentable_id')
            ->pluck('total_rented', 'rentable_id')
            ->toArray();
            
        $rentedGames = RentalItem::where('rentable_type', Game::class)
            ->whereIn('rental_id', $activeRentalIds)
            ->select('rentable_id', DB::raw('SUM(quantity) as total_rented'))
            ->groupBy('rentable_id')
            ->pluck('total_rented', 'rentable_id')
            ->toArray();
            
        $rentedAccessories = RentalItem::where('rentable_type', Accessory::class)
            ->whereIn('rental_id', $activeRentalIds)
            ->select('rentable_id', DB::raw('SUM(quantity) as total_rented'))
            ->groupBy('rentable_id')
            ->pluck('total_rented', 'rentable_id')
            ->toArray();
        
        // Search functionality
        $search = $request->input('search');
        
        // Get items with search filter
        $unitpsQuery = UnitPS::query();
        $gamesQuery = Game::query();
        $accessoriesQuery = Accessory::query();
        
        if ($search) {
            $unitpsQuery->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('merek', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('nomor_seri', 'like', "%{$search}%");
            });
            
            $gamesQuery->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('platform', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%");
            });
            
            $accessoriesQuery->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%");
            });
        }
        
        $unitps = $unitpsQuery->orderBy('nama')->get();
        $games = $gamesQuery->orderBy('judul')->get();
        $accessories = $accessoriesQuery->orderBy('nama')->get();
        
        // Calculate statistics
        $stats = [
            'units' => [
                'total' => $unitps->sum('stok'),
                'available' => $unitps->sum('stok') - array_sum($rentedUnits),
                'rented' => array_sum($rentedUnits),
            ],
            'games' => [
                'total' => $games->sum('stok'),
                'available' => $games->sum('stok') - array_sum($rentedGames),
                'rented' => array_sum($rentedGames),
            ],
            'accessories' => [
                'total' => $accessories->sum('stok'),
                'available' => $accessories->sum('stok') - array_sum($rentedAccessories),
                'rented' => array_sum($rentedAccessories),
            ],
        ];
        
        return view('owner.status_produk', compact(
            'unitps', 'games', 'accessories', 
            'rentedUnits', 'rentedGames', 'rentedAccessories',
            'stats', 'search'
        ));
    }

    /**
     * Menampilkan daftar item yang rusak
     */
    public function damaged()
    {
        Gate::authorize('access-pemilik');
        
        // Get all damaged items
        $damagedUnits = UnitPS::where('kondisi', 'rusak')->orderBy('updated_at', 'desc')->get();
        $damagedGames = Game::where('kondisi', 'rusak')->orderBy('updated_at', 'desc')->get();
        $damagedAccessories = Accessory::where('kondisi', 'rusak')->orderBy('updated_at', 'desc')->get();
        
        // Get items with kondisi_kembali = rusak from rental items
        $damagedFromRentals = RentalItem::with(['rental.customer', 'rentable'])
            ->where('kondisi_kembali', 'rusak')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $stats = [
            'units' => $damagedUnits->count(),
            'games' => $damagedGames->count(),
            'accessories' => $damagedAccessories->count(),
            'from_rentals' => $damagedFromRentals->count(),
            'total' => $damagedUnits->count() + $damagedGames->count() + $damagedAccessories->count(),
        ];
        
        return view('owner.damaged_items', compact(
            'damagedUnits', 'damagedGames', 'damagedAccessories', 
            'damagedFromRentals', 'stats'
        ));
    }

    /**
     * Menampilkan daftar transaksi yang dibatalkan
     */
    public function cancelledTransactions()
    {
        Gate::authorize('access-pemilik');
        
        $rentals = Rental::with(['customer', 'items.rentable'])
            ->where('status', 'cancelled')
            ->orderByDesc('updated_at')
            ->paginate(15);
            
        return view('owner.cancelled_transactions', compact('rentals'));
    }
}
