<?php

namespace App\Services\DataScience;

use App\Models\Review;
use App\Models\Produk;
use DB;

class SentimentAnalysisService
{
    /**
     * Kamus Leksikon Sentimen Bahasa Indonesia
     */
    private $positiveWords = [
        'bagus', 'keren', 'kokoh', 'puas', 'mantap', 'halus', 'kuat', 'cepat', 'original',
        'rekomended', 'suka', 'tebal', 'aman', 'mulus', 'rapi', 'istimewa', 'terbaik',
        'awet', 'elegan', 'premium', 'berkualitas', 'nyaman', 'sesuai', 'murah', 'mantul',
        'juara', 'hebat', 'packing rapi', 'rekomendasi', 'sempurna', 'ringan', 'luas',
        'presisi', 'tahan', 'estetik', 'cantik', 'terpercaya', 'responsif'
    ];

    private $negativeWords = [
        'rusak', 'jelek', 'patah', 'kecewa', 'pecah', 'lecet', 'lambat', 'cacat', 'penyok',
        'kurang', 'buruk', 'palsu', 'tipis', 'macet', 'lama', 'rugi', 'baret', 'kotor',
        'mengecewakan', 'kasar', 'gampang rusak', 'letoy', 'bermasalah', 'lepas', 'bocor',
        'tidak sesuai', 'menyesal', 'jelek banget', 'batal', 'longgar', 'penipu'
    ];

    private $negationWords = [
        'tidak', 'bukan', 'kurang', 'jangan', 'gak', 'nggak', 'ga', 'belum'
    ];

    /**
     * Menjalankan Analisis Sentimen Menyeluruh terhadap Semua Ulasan Pelanggan Asli di Database
     */
    public function analyzeAllReviews()
    {
        $reviews = Review::leftJoin('produk', 'produk.id', '=', 'review.produk_id')
            ->leftJoin('pelanggan', 'pelanggan.id', '=', 'review.pelanggan_id')
            ->select(
                'review.*',
                'produk.nama_produk',
                'pelanggan.nama as nama_pelanggan'
            )
            ->orderBy('review.created_at', 'desc')
            ->get();

        if ($reviews->isEmpty()) {
            return [
                'total_reviews'    => 0,
                'positive_count'   => 0,
                'neutral_count'    => 0,
                'negative_count'   => 0,
                'positive_pct'     => 0.0,
                'neutral_pct'      => 0.0,
                'negative_pct'     => 0.0,
                'csi'              => 0.0,
                'csi_status'       => 'Belum Ada Ulasan',
                'top_keywords'     => [],
                'reviews_feed'     => []
            ];
        }

        $positiveCount = 0;
        $neutralCount = 0;
        $negativeCount = 0;
        $analyzedList = [];
        $keywordFrequencies = [];

        foreach ($reviews as $rev) {
            $analysis = $this->analyzeText($rev->review, $rev->rating);
            
            if ($analysis['sentiment'] === 'Positif') {
                $positiveCount++;
            } elseif ($analysis['sentiment'] === 'Negatif') {
                $negativeCount++;
            } else {
                $neutralCount++;
            }

            foreach ($analysis['tokens'] as $token) {
                if (strlen($token) >= 3) {
                    $keywordFrequencies[$token] = ($keywordFrequencies[$token] ?? 0) + 1;
                }
            }

            $analyzedList[] = [
                'id'              => $rev->id,
                'nama_pelanggan'  => $rev->nama_pelanggan ?? 'Pelanggan #' . $rev->pelanggan_id,
                'nama_produk'     => $rev->nama_produk ?? 'Produk #' . $rev->produk_id,
                'rating'          => $rev->rating ?? 5,
                'raw_text'        => $rev->review,
                'sentiment'       => $analysis['sentiment'],
                'score'           => $analysis['score'],
                'badge'           => $analysis['badge'],
                'color'           => $analysis['color'],
                'key_phrases'     => $analysis['matched_words'],
                'created_at'      => $rev->created_at ? $rev->created_at->format('d M Y') : '-'
            ];
        }

        $total = count($reviews);
        $csi = round(($positiveCount / $total) * 100, 1);

        arsort($keywordFrequencies);
        $topKeywords = array_slice($keywordFrequencies, 0, 10, true);

        return [
            'total_reviews'    => $total,
            'positive_count'   => $positiveCount,
            'neutral_count'    => $neutralCount,
            'negative_count'   => $negativeCount,
            'positive_pct'     => round(($positiveCount / $total) * 100, 1),
            'neutral_pct'      => round(($neutralCount / $total) * 100, 1),
            'negative_pct'     => round(($negativeCount / $total) * 100, 1),
            'csi'              => $csi, // Customer Satisfaction Index
            'csi_status'       => ($csi >= 80) ? 'Sangat Puas (Excellent)' : (($csi >= 60) ? 'Puas (Good)' : 'Perlu Evaluasi (Action Required)'),
            'top_keywords'     => $topKeywords,
            'reviews_feed'     => $analyzedList
        ];
    }

    /**
     * Menganalisis Teks Satuan
     */
    public function analyzeText($text, $rating = 5)
    {
        if (empty(trim($text))) {
            if ($rating >= 4) {
                return ['sentiment' => 'Positif', 'score' => 0.8, 'badge' => 'success', 'color' => '#28c76f', 'tokens' => [], 'matched_words' => ['Rating ' . $rating . ' Bintang']];
            } elseif ($rating == 3) {
                return ['sentiment' => 'Netral', 'score' => 0.0, 'badge' => 'info', 'color' => '#00cfe8', 'tokens' => [], 'matched_words' => ['Rating 3 Bintang']];
            } else {
                return ['sentiment' => 'Negatif', 'score' => -0.8, 'badge' => 'danger', 'color' => '#ea5455', 'tokens' => [], 'matched_words' => ['Rating Rendah']];
            }
        }

        // Preprocessing: Case Folding & Sanitasi
        $cleaned = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', ' ', $text));
        $words = array_values(array_filter(explode(' ', $cleaned)));

        $score = 0.0;
        $matched = [];
        $isNegated = false;

        $n = count($words);
        for ($i = 0; $i < $n; $i++) {
            $word = $words[$i];

            // Deteksi Negasi ("tidak bagus", "kurang puas")
            if (in_array($word, $this->negationWords)) {
                $isNegated = true;
                continue;
            }

            if (in_array($word, $this->positiveWords)) {
                if ($isNegated) {
                    $score -= 1.0;
                    $matched[] = "tidak {$word} (-)";
                } else {
                    $score += 1.0;
                    $matched[] = "{$word} (+)";
                }
                $isNegated = false;
            } elseif (in_array($word, $this->negativeWords)) {
                if ($isNegated) {
                    $score += 0.5;
                    $matched[] = "tidak {$word} (+)";
                } else {
                    $score -= 1.2;
                    $matched[] = "{$word} (-)";
                }
                $isNegated = false;
            }
        }

        // Bobot tambahan dari rating bintang
        if ($rating >= 4) {
            $score += 0.5;
        } elseif ($rating <= 2) {
            $score -= 0.8;
        }

        // Normalisasi Skor ke rentang [-1.0, 1.0]
        $divisor = max(1, count($matched) + 1);
        $normalizedScore = round(max(-1.0, min(1.0, $score / $divisor)), 2);

        if ($normalizedScore > 0.15) {
            $sentiment = 'Positif';
            $badge = 'success';
            $color = '#28c76f';
        } elseif ($normalizedScore < -0.15) {
            $sentiment = 'Negatif';
            $badge = 'danger';
            $color = '#ea5455';
        } else {
            $sentiment = 'Netral';
            $badge = 'info';
            $color = '#00cfe8';
        }

        return [
            'sentiment'     => $sentiment,
            'score'         => $normalizedScore,
            'badge'         => $badge,
            'color'         => $color,
            'tokens'        => $words,
            'matched_words' => !empty($matched) ? $matched : ['Rating ' . $rating . ' Bintang']
        ];
    }
}
