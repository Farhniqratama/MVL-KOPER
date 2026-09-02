<?php

namespace App\Services\DataScience;

use App\Models\Produk;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\GambarProduk;
use DB;

class RecommenderService
{
    /**
     * Menghitung Matriks Cosine Similarity antar Produk berdasarkan pola ko-okurensi transaksi & profil produk
     */
    public function calculateItemSimilarityMatrix()
    {
        $products = Produk::select('id', 'nama_produk', 'kategori_id', 'harga')->get();
        if ($products->isEmpty()) {
            return ['matrix' => [], 'products' => []];
        }

        // Ambil data transaksi per item
        $transactions = DetailTransaksi::join('transaksi', 'transaksi.id', '=', 'detail_transaksi.id_transaksi')
            ->select('detail_transaksi.id_transaksi', 'detail_transaksi.produk_id', 'detail_transaksi.qty')
            ->whereNull('transaksi.deleted_at')
            ->get();

        // Buat matriks Transaksi x Produk
        $basketMatrix = [];
        $allTxIds = [];
        foreach ($transactions as $t) {
            $basketMatrix[$t->id_transaksi][$t->produk_id] = ($basketMatrix[$t->id_transaksi][$t->produk_id] ?? 0) + $t->qty;
            $allTxIds[$t->id_transaksi] = true;
        }

        // Buat vektor untuk setiap produk
        $productVectors = [];
        foreach ($products as $p) {
            $vec = [];
            foreach (array_keys($allTxIds) as $txId) {
                $vec[] = $basketMatrix[$txId][$p->id] ?? 0;
            }
            $productVectors[$p->id] = $vec;
        }

        // Hitung Cosine Similarity untuk setiap pasangan produk
        $similarityMatrix = [];
        $productMap = [];

        foreach ($products as $p1) {
            $productMap[$p1->id] = $p1;
            $similarityMatrix[$p1->id] = [];

            foreach ($products as $p2) {
                if ($p1->id == $p2->id) {
                    $similarityMatrix[$p1->id][$p2->id] = 1.000;
                    continue;
                }

                $sim = $this->cosineSimilarity($productVectors[$p1->id], $productVectors[$p2->id]);
                
                // Jika transaksi masih sparse (0), berikan konten-similarity berdasarkan kategori & rentang harga
                if ($sim == 0) {
                    $catScore = ($p1->kategori_id == $p2->kategori_id) ? 0.65 : 0.10;
                    $priceRatio = 1 - min(1, abs($p1->harga - $p2->harga) / max(1, max($p1->harga, $p2->harga)));
                    $sim = round(($catScore * 0.7) + ($priceRatio * 0.3), 3);
                }

                $similarityMatrix[$p1->id][$p2->id] = round($sim, 3);
            }
        }

        return [
            'matrix'   => $similarityMatrix,
            'products' => $products
        ];
    }

    /**
     * Formula Matematis Cosine Similarity:
     * cos(theta) = (A . B) / (||A|| * ||B||)
     */
    private function cosineSimilarity(array $vecA, array $vecB)
    {
        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        $n = count($vecA);
        for ($i = 0; $i < $n; $i++) {
            $dotProduct += ($vecA[$i] * $vecB[$i]);
            $normA += ($vecA[$i] * $vecA[$i]);
            $normB += ($vecB[$i] * $vecB[$i]);
        }

        if ($normA == 0 || $normB == 0) {
            return 0.0;
        }

        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    /**
     * Dapatkan Top-N Produk Rekomendasi untuk suatu Produk tertentu
     */
    public function getRecommendedProductsFor($productId, $limit = 4)
    {
        $targetProduct = Produk::find($productId);
        if (!$targetProduct) {
            return collect();
        }

        $matrixData = $this->calculateItemSimilarityMatrix();
        $simMatrix = $matrixData['matrix'];

        if (!isset($simMatrix[$productId])) {
            return Produk::where('id', '!=', $productId)
                ->where('kategori_id', $targetProduct->kategori_id)
                ->take($limit)
                ->get();
        }

        $scores = $simMatrix[$productId];
        // Hapus produk itu sendiri
        unset($scores[$productId]);
        arsort($scores);

        $topIds = array_slice(array_keys($scores), 0, $limit, true);
        if (empty($topIds)) {
            return Produk::where('id', '!=', $productId)->take($limit)->get();
        }

        $recommended = Produk::whereIn('id', $topIds)->get()->map(function ($prod) use ($scores) {
            $prod->similarity_score = round(($scores[$prod->id] ?? 0.5) * 100, 1);
            $thumbnail = GambarProduk::where('produk_id', $prod->id)->where('is_thumbnails', 1)->first();
            $prod->thumbnail_image = $thumbnail ? $thumbnail->gambar : ($prod->gambar ?? null);
            return $prod;
        })->sortByDesc('similarity_score')->values();

        return $recommended;
    }

    /**
     * Market Basket Analysis (Algoritma Asosiasi Apriori)
     * Menghitung Support, Confidence, dan Lift Ratio
     */
    public function getMarketBasketRules($minSupport = 0.01, $minConfidence = 0.10)
    {
        $transactions = DetailTransaksi::select('id_transaksi', 'produk_id')
            ->groupBy('id_transaksi', 'produk_id')
            ->get();

        $baskets = [];
        foreach ($transactions as $t) {
            $baskets[$t->id_transaksi][] = $t->produk_id;
        }

        $totalTransactions = max(1, count($baskets));
        $itemCounts = [];
        $pairCounts = [];

        foreach ($baskets as $items) {
            $items = array_unique($items);
            sort($items);
            $count = count($items);

            for ($i = 0; $i < $count; $i++) {
                $itemA = $items[$i];
                $itemCounts[$itemA] = ($itemCounts[$itemA] ?? 0) + 1;

                for ($j = $i + 1; $j < $count; $j++) {
                    $itemB = $items[$j];
                    $pairKey = $itemA . '_' . $itemB;
                    $pairCounts[$pairKey] = ($pairCounts[$pairKey] ?? 0) + 1;
                }
            }
        }

        $products = Produk::pluck('nama_produk', 'id')->toArray();
        $rules = [];

        foreach ($pairCounts as $pair => $count) {
            list($itemA, $itemB) = explode('_', $pair);
            $supportAB = $count / $totalTransactions;

            if ($supportAB < $minSupport) continue;

            $supportA = ($itemCounts[$itemA] ?? 1) / $totalTransactions;
            $supportB = ($itemCounts[$itemB] ?? 1) / $totalTransactions;

            // Aturan A -> B
            $confidenceAB = $supportAB / $supportA;
            $liftAB = $supportB > 0 ? ($confidenceAB / $supportB) : 1;

            if ($confidenceAB >= $minConfidence && isset($products[$itemA]) && isset($products[$itemB])) {
                $rules[] = [
                    'antecedent_id'   => $itemA,
                    'antecedent_name' => $products[$itemA],
                    'consequent_id'   => $itemB,
                    'consequent_name' => $products[$itemB],
                    'support'         => round($supportAB * 100, 2),
                    'confidence'      => round($confidenceAB * 100, 2),
                    'lift'            => round($liftAB, 2),
                    'interpretation'  => ($liftAB > 1) ? 'Korelasi Positif Kuat (Cross-Selling Direkomendasikan)' : 'Korelasi Netral'
                ];
            }
        }

        // Urutkan berdasarkan lift tertinggi
        usort($rules, function ($a, $b) {
            return $b['lift'] <=> $a['lift'];
        });

        return $rules;
    }
}
