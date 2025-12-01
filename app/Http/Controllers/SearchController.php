<?php

namespace App\Http\Controllers;

use App\Models\UnitPS;
use App\Models\Game;
use App\Models\Accessory;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * Synonym mappings for semantic search
     * Maps common terms to their related keywords
     */
    protected $synonyms = [
        // PlayStation related
        'ps' => ['playstation', 'ps3', 'ps4', 'ps5', 'sony', 'console', 'konsol'],
        'playstation' => ['ps', 'ps3', 'ps4', 'ps5', 'sony', 'console', 'konsol'],
        'konsol' => ['console', 'ps', 'playstation', 'unit'],
        'console' => ['konsol', 'ps', 'playstation', 'unit'],
        
        // Controller related
        'controller' => ['stik', 'stick', 'joystick', 'gamepad', 'dualshock', 'dualsense', 'kontroller'],
        'stik' => ['controller', 'stick', 'joystick', 'gamepad', 'dualshock', 'dualsense'],
        'stick' => ['controller', 'stik', 'joystick', 'gamepad', 'dualshock', 'dualsense'],
        'joystick' => ['controller', 'stik', 'stick', 'gamepad'],
        'dualshock' => ['controller', 'stik', 'stick', 'ps4'],
        'dualsense' => ['controller', 'stik', 'stick', 'ps5'],
        
        // Game genres
        'action' => ['aksi', 'adventure', 'petualangan', 'fighting', 'shooter'],
        'aksi' => ['action', 'adventure', 'petualangan', 'fighting'],
        'rpg' => ['role playing', 'jrpg', 'action rpg', 'adventure'],
        'sport' => ['olahraga', 'sepak bola', 'football', 'soccer', 'basket', 'racing'],
        'olahraga' => ['sport', 'sepak bola', 'football', 'soccer', 'basket'],
        'racing' => ['balap', 'mobil', 'motor', 'car', 'speed'],
        'balap' => ['racing', 'mobil', 'motor', 'car', 'speed'],
        'horror' => ['horor', 'scary', 'seram', 'thriller'],
        'horor' => ['horror', 'scary', 'seram', 'thriller'],
        'adventure' => ['petualangan', 'action', 'open world'],
        'petualangan' => ['adventure', 'action', 'open world'],
        
        // Popular game titles keywords
        'fifa' => ['sepak bola', 'football', 'soccer', 'ea sports', 'sport'],
        'pes' => ['sepak bola', 'football', 'soccer', 'efootball', 'konami', 'sport'],
        'gta' => ['grand theft auto', 'rockstar', 'open world', 'action'],
        'cod' => ['call of duty', 'shooter', 'fps', 'war', 'perang'],
        'nba' => ['basket', 'basketball', 'sport', '2k'],
        
        // Accessories
        'headset' => ['headphone', 'earphone', 'audio', 'mic', 'microphone'],
        'headphone' => ['headset', 'earphone', 'audio'],
        'vr' => ['virtual reality', 'psvr', 'headset vr'],
        'kabel' => ['cable', 'charger', 'hdmi', 'usb'],
        'cable' => ['kabel', 'charger', 'hdmi', 'usb'],
        'charger' => ['charging', 'kabel', 'cable', 'power'],
        
        // Rental related
        'sewa' => ['rental', 'pinjam', 'rent', 'penyewaan'],
        'rental' => ['sewa', 'pinjam', 'rent', 'penyewaan'],
        'pinjam' => ['sewa', 'rental', 'rent'],
        'murah' => ['cheap', 'promo', 'diskon', 'hemat', 'terjangkau'],
        'baru' => ['new', 'latest', 'terbaru', 'newest'],
        'terbaru' => ['new', 'latest', 'baru', 'newest'],
        
        // Condition
        'bagus' => ['baik', 'good', 'excellent', 'prima'],
        'baik' => ['bagus', 'good', 'excellent', 'prima'],
        'rusak' => ['broken', 'damaged', 'cacat', 'defect'],
    ];

    /**
     * Category keywords for intent detection
     */
    protected $categoryKeywords = [
        'unit' => ['ps', 'playstation', 'ps3', 'ps4', 'ps5', 'console', 'konsol', 'unit', 'sony'],
        'game' => ['game', 'games', 'permainan', 'judul', 'title', 'main', 'bermain', 'play'],
        'accessory' => ['aksesoris', 'accessory', 'accessories', 'controller', 'stik', 'headset', 'vr', 'kabel', 'charger'],
        'rental' => ['sewa', 'rental', 'riwayat', 'history', 'transaksi', 'order', 'pesanan'],
    ];

    /**
     * Perform global semantic search
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));
        
        if (empty($query)) {
            return view('search.results', [
                'query' => '',
                'results' => collect(),
                'categories' => [],
                'totalResults' => 0,
            ]);
        }

        // Expand query with synonyms for semantic search
        $expandedTerms = $this->expandQueryWithSynonyms($query);
        
        // Detect user intent/category
        $detectedCategories = $this->detectCategories($query, $expandedTerms);
        
        // Perform search across all models
        $results = $this->performSearch($query, $expandedTerms, $detectedCategories);
        
        // Calculate relevance scores and sort
        $results = $this->calculateRelevanceScores($results, $query, $expandedTerms);
        
        return view('search.results', [
            'query' => $query,
            'results' => $results,
            'expandedTerms' => $expandedTerms,
            'detectedCategories' => $detectedCategories,
            'totalResults' => $results->count(),
        ]);
    }

    /**
     * AJAX endpoint for autocomplete suggestions
     */
    public function suggestions(Request $request)
    {
        $query = trim($request->input('q', ''));
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $expandedTerms = $this->expandQueryWithSynonyms($query);
        $suggestions = collect();

        // Get unit suggestions
        $units = UnitPS::where(function($q) use ($query, $expandedTerms) {
                $this->applySemanticSearch($q, $expandedTerms, ['nama', 'model', 'merek', 'name', 'brand']);
            })
            ->where(function($q) {
                $q->where('stock', '>', 0)->orWhere('stok', '>', 0);
            })
            ->limit(3)
            ->get()
            ->map(fn($item) => [
                'type' => 'unit',
                'icon' => 'bi-controller',
                'text' => $item->nama ?? $item->name,
                'subtext' => $item->model,
                'url' => route('pelanggan.unitps.index', ['q' => $item->nama ?? $item->name]),
            ]);

        // Get game suggestions
        $games = Game::where(function($q) use ($query, $expandedTerms) {
                $this->applySemanticSearch($q, $expandedTerms, ['judul', 'platform', 'genre']);
            })
            ->where('stok', '>', 0)
            ->limit(3)
            ->get()
            ->map(fn($item) => [
                'type' => 'game',
                'icon' => 'bi-disc',
                'text' => $item->judul,
                'subtext' => "{$item->platform} • {$item->genre}",
                'url' => route('pelanggan.games.index', ['q' => $item->judul]),
            ]);

        // Get accessory suggestions
        $accessories = Accessory::where(function($q) use ($query, $expandedTerms) {
                $this->applySemanticSearch($q, $expandedTerms, ['nama', 'jenis']);
            })
            ->where('stok', '>', 0)
            ->limit(3)
            ->get()
            ->map(fn($item) => [
                'type' => 'accessory',
                'icon' => 'bi-headset',
                'text' => $item->nama,
                'subtext' => $item->jenis,
                'url' => route('pelanggan.accessories.index', ['q' => $item->nama]),
            ]);

        $suggestions = $units->concat($games)->concat($accessories)->take(8);

        return response()->json($suggestions);
    }

    /**
     * Expand query with synonyms for semantic matching
     */
    protected function expandQueryWithSynonyms(string $query): array
    {
        $words = preg_split('/\s+/', Str::lower($query));
        $expandedTerms = $words;

        foreach ($words as $word) {
            // Direct synonym lookup
            if (isset($this->synonyms[$word])) {
                $expandedTerms = array_merge($expandedTerms, $this->synonyms[$word]);
            }

            // Partial match for compound words
            foreach ($this->synonyms as $key => $synonyms) {
                if (Str::contains($word, $key) || Str::contains($key, $word)) {
                    $expandedTerms = array_merge($expandedTerms, $synonyms);
                    $expandedTerms[] = $key;
                }
            }
        }

        return array_unique($expandedTerms);
    }

    /**
     * Detect which categories the user is likely searching for
     */
    protected function detectCategories(string $query, array $expandedTerms): array
    {
        $detected = [];
        $queryLower = Str::lower($query);

        foreach ($this->categoryKeywords as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (Str::contains($queryLower, $keyword) || in_array($keyword, $expandedTerms)) {
                    $detected[$category] = ($detected[$category] ?? 0) + 1;
                }
            }
        }

        // Sort by relevance score
        arsort($detected);
        
        // If no category detected, search all
        if (empty($detected)) {
            return ['unit', 'game', 'accessory'];
        }

        return array_keys($detected);
    }

    /**
     * Perform the actual search across models
     */
    protected function performSearch(string $query, array $expandedTerms, array $categories): \Illuminate\Support\Collection
    {
        $results = collect();

        if (in_array('unit', $categories)) {
            $units = UnitPS::where(function($q) use ($expandedTerms) {
                    $this->applySemanticSearch($q, $expandedTerms, ['nama', 'model', 'merek', 'name', 'brand']);
                })
                ->where(function($q) {
                    $q->where('stock', '>', 0)->orWhere('stok', '>', 0);
                })
                ->get()
                ->map(fn($item) => [
                    'type' => 'unit',
                    'type_label' => 'Unit PlayStation',
                    'icon' => 'bi-controller',
                    'color' => 'primary',
                    'id' => $item->id,
                    'title' => $item->nama ?? $item->name,
                    'subtitle' => $item->model . ' - ' . ($item->merek ?? $item->brand),
                    'description' => "Stok: {$item->stok} unit tersedia",
                    'price' => $item->harga_per_jam ?? $item->price_per_hour,
                    'price_label' => '/jam',
                    'image' => $item->foto,
                    'url' => route('pelanggan.unitps.index', ['q' => $item->nama ?? $item->name]),
                    'searchable_text' => Str::lower(($item->nama ?? $item->name) . ' ' . $item->model . ' ' . ($item->merek ?? $item->brand)),
                ]);
            $results = $results->concat($units);
        }

        if (in_array('game', $categories)) {
            $games = Game::where(function($q) use ($expandedTerms) {
                    $this->applySemanticSearch($q, $expandedTerms, ['judul', 'platform', 'genre']);
                })
                ->where('stok', '>', 0)
                ->get()
                ->map(fn($item) => [
                    'type' => 'game',
                    'type_label' => 'Game',
                    'icon' => 'bi-disc',
                    'color' => 'success',
                    'id' => $item->id,
                    'title' => $item->judul,
                    'subtitle' => "{$item->platform} • {$item->genre}",
                    'description' => "Stok: {$item->stok} kopi tersedia",
                    'price' => $item->harga_per_hari,
                    'price_label' => '/hari',
                    'image' => $item->gambar,
                    'url' => route('pelanggan.games.index', ['q' => $item->judul]),
                    'searchable_text' => Str::lower($item->judul . ' ' . $item->platform . ' ' . $item->genre),
                ]);
            $results = $results->concat($games);
        }

        if (in_array('accessory', $categories)) {
            $accessories = Accessory::where(function($q) use ($expandedTerms) {
                    $this->applySemanticSearch($q, $expandedTerms, ['nama', 'jenis']);
                })
                ->where('stok', '>', 0)
                ->get()
                ->map(fn($item) => [
                    'type' => 'accessory',
                    'type_label' => 'Aksesoris',
                    'icon' => 'bi-headset',
                    'color' => 'warning',
                    'id' => $item->id,
                    'title' => $item->nama,
                    'subtitle' => $item->jenis,
                    'description' => "Stok: {$item->stok} unit tersedia",
                    'price' => $item->harga_per_hari,
                    'price_label' => '/hari',
                    'image' => $item->gambar,
                    'url' => route('pelanggan.accessories.index', ['q' => $item->nama]),
                    'searchable_text' => Str::lower($item->nama . ' ' . $item->jenis),
                ]);
            $results = $results->concat($accessories);
        }

        return $results;
    }

    /**
     * Apply semantic search conditions to query builder
     */
    protected function applySemanticSearch($query, array $terms, array $columns): void
    {
        $query->where(function($q) use ($terms, $columns) {
            foreach ($terms as $term) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$term}%");
                }
            }
        });
    }

    /**
     * Calculate relevance scores for search results
     */
    protected function calculateRelevanceScores(\Illuminate\Support\Collection $results, string $query, array $expandedTerms): \Illuminate\Support\Collection
    {
        $queryLower = Str::lower($query);
        $queryWords = preg_split('/\s+/', $queryLower);

        return $results->map(function($item) use ($queryLower, $queryWords, $expandedTerms) {
            $score = 0;
            $searchableText = $item['searchable_text'];

            // Exact match bonus (highest priority)
            if (Str::contains($searchableText, $queryLower)) {
                $score += 100;
            }

            // Title starts with query
            if (Str::startsWith(Str::lower($item['title']), $queryLower)) {
                $score += 50;
            }

            // Word match scoring
            foreach ($queryWords as $word) {
                if (Str::contains($searchableText, $word)) {
                    $score += 20;
                }
            }

            // Synonym match scoring (lower weight)
            foreach ($expandedTerms as $term) {
                if (!in_array($term, $queryWords) && Str::contains($searchableText, $term)) {
                    $score += 5;
                }
            }

            $item['relevance_score'] = $score;
            return $item;
        })
        ->sortByDesc('relevance_score')
        ->values();
    }
}
