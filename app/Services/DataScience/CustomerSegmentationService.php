<?php

namespace App\Services\DataScience;

use App\Models\Pelanggan;
use App\Models\Transaksi;
use Carbon\Carbon;
use DB;

class CustomerSegmentationService
{
    /**
     * Menjalankan Analisis Segmentasi Pelanggan berbasis Model RFM dan Algoritma K-Means Clustering
     */
    public function getCustomerSegments($k = 4)
    {
        $customers = Pelanggan::all();
        if ($customers->isEmpty()) {
            return ['clusters' => [], 'summary' => [], 'chart_data' => []];
        }

        $now = Carbon::now();
        $rfmData = [];
        $rList = [];
        $fList = [];
        $mList = [];

        foreach ($customers as $cust) {
            $trans = Transaksi::where('user_id', $cust->id)
                ->whereNull('deleted_at')
                ->get();

            $lastOrder = $trans->max('tgl_transaksi');
            $recency = $lastOrder ? max(1, $now->diffInDays(Carbon::parse($lastOrder))) : 180;
            $frequency = $trans->count();
            $monetary = $trans->sum('total_pembayaran');

            $rfmData[] = [
                'id'        => $cust->id,
                'nama'      => $cust->nama,
                'email'     => $cust->email ?? '-',
                'no_hp'     => $cust->no_hp ?? '-',
                'recency'   => $recency,
                'frequency' => $frequency,
                'monetary'  => $monetary,
            ];

            $rList[] = $recency;
            $fList[] = $frequency;
            $mList[] = $monetary;
        }

        // Normalisasi skala Min-Max untuk input K-Means
        $rScaled = DataPipelineService::minMaxScale($rList);
        $fScaled = DataPipelineService::minMaxScale($fList);
        $mScaled = DataPipelineService::minMaxScale($mList);

        $points = [];
        foreach ($rfmData as $idx => $cust) {
            $points[] = [
                'r_norm' => 1 - $rScaled[$idx], // Dibalik: semakin baru belanja (recency kecil), nilainya semakin mendekati 1
                'f_norm' => $fScaled[$idx],
                'm_norm' => $mScaled[$idx],
                'raw'    => $cust
            ];
        }

        // Jalankan K-Means Clustering
        $clusteredResult = $this->runKMeans($points, $k);

        return $this->formatClusterOutput($clusteredResult);
    }

    /**
     * Algoritma K-Means Clustering (Pure PHP implementation)
     */
    private function runKMeans(array $points, $k = 4, $maxIterations = 50)
    {
        $numPoints = count($points);
        if ($numPoints <= $k) {
            // Jika data sedikit, masukkan masing-masing ke grup
            $clusters = [];
            foreach ($points as $i => $pt) {
                $clusters[$i % $k][] = $pt;
            }
            return $clusters;
        }

        // Inisialisasi Centroid
        $centroids = [];
        $step = max(1, floor($numPoints / $k));
        for ($i = 0; $i < $k; $i++) {
            $pickIdx = min($numPoints - 1, $i * $step);
            $centroids[$i] = [
                'r_norm' => $points[$pickIdx]['r_norm'],
                'f_norm' => $points[$pickIdx]['f_norm'],
                'm_norm' => $points[$pickIdx]['m_norm']
            ];
        }

        $assignments = array_fill(0, $numPoints, 0);

        for ($iter = 0; $iter < $maxIterations; $iter++) {
            $changed = false;

            // 1. Tahap Assignment: Pasangkan titik ke centroid terdekat (Euclidean Distance)
            foreach ($points as $idx => $pt) {
                $minDist = PHP_FLOAT_MAX;
                $bestCluster = 0;

                foreach ($centroids as $cIdx => $centroid) {
                    $dist = sqrt(
                        pow($pt['r_norm'] - $centroid['r_norm'], 2) +
                        pow($pt['f_norm'] - $centroid['f_norm'], 2) +
                        pow($pt['m_norm'] - $centroid['m_norm'], 2)
                    );

                    if ($dist < $minDist) {
                        $minDist = $dist;
                        $bestCluster = $cIdx;
                    }
                }

                if ($assignments[$idx] !== $bestCluster) {
                    $assignments[$idx] = $bestCluster;
                    $changed = true;
                }
            }

            // Jika tidak ada perubahan cluster, konvergensi tercapai
            if (!$changed) {
                break;
            }

            // 2. Tahap Update: Hitung ulang posisi centroid
            for ($cIdx = 0; $cIdx < $k; $cIdx++) {
                $cPoints = [];
                foreach ($points as $idx => $pt) {
                    if ($assignments[$idx] === $cIdx) {
                        $cPoints[] = $pt;
                    }
                }

                if (!empty($cPoints)) {
                    $cnt = count($cPoints);
                    $centroids[$cIdx]['r_norm'] = array_sum(array_column($cPoints, 'r_norm')) / $cnt;
                    $centroids[$cIdx]['f_norm'] = array_sum(array_column($cPoints, 'f_norm')) / $cnt;
                    $centroids[$cIdx]['m_norm'] = array_sum(array_column($cPoints, 'm_norm')) / $cnt;
                }
            }
        }

        // Kelompokkan hasil
        $finalClusters = [];
        for ($cIdx = 0; $cIdx < $k; $cIdx++) {
            $finalClusters[$cIdx] = [];
        }

        foreach ($points as $idx => $pt) {
            $cIdx = $assignments[$idx];
            $finalClusters[$cIdx][] = $pt;
        }

        return $finalClusters;
    }

    /**
     * Labeling Segmen Bisnis & Rekomendasi Aksi Pemasaran
     */
    private function formatClusterOutput(array $clusters)
    {
        // Berikan label segmen berdasarkan rata-rata skor gabungan RFM
        $clusterMetrics = [];
        foreach ($clusters as $cIdx => $memberList) {
            if (empty($memberList)) {
                $clusterMetrics[$cIdx] = [
                    'cIdx'          => $cIdx,
                    'avg_recency'   => 0,
                    'avg_frequency' => 0,
                    'avg_monetary'  => 0,
                    'avg_score'     => 0,
                    'count'         => 0,
                    'members'       => []
                ];
                continue;
            }

            $avgR = array_sum(array_column(array_column($memberList, 'raw'), 'recency')) / count($memberList);
            $avgF = array_sum(array_column(array_column($memberList, 'raw'), 'frequency')) / count($memberList);
            $avgM = array_sum(array_column(array_column($memberList, 'raw'), 'monetary')) / count($memberList);
            $avgNormScore = (
                array_sum(array_column($memberList, 'r_norm')) +
                array_sum(array_column($memberList, 'f_norm')) +
                array_sum(array_column($memberList, 'm_norm'))
            ) / (3 * count($memberList));

            $clusterMetrics[$cIdx] = [
                'cIdx'          => $cIdx,
                'avg_recency'   => round($avgR, 1),
                'avg_frequency' => round($avgF, 1),
                'avg_monetary'  => round($avgM, 0),
                'avg_score'     => $avgNormScore,
                'count'         => count($memberList),
                'members'       => array_column($memberList, 'raw')
            ];
        }

        // Urutkan klaster dari nilai tertinggi ke terendah
        usort($clusterMetrics, function ($a, $b) {
            return $b['avg_score'] <=> $a['avg_score'];
        });

        $segmentNames = [
            0 => [
                'label'       => 'Champions (Super Loyal & Royal)',
                'badge'       => 'success',
                'color'       => '#28c76f',
                'description' => 'Pelanggan terbaik dengan frekuensi belanja tinggi, nominal besar, dan transaksi terbaru.',
                'strategy'    => 'Berikan program reward VIP, akses eksklusif produk koper baru, dan penawaran cashback.'
            ],
            1 => [
                'label'       => 'Potential Loyalists (Potensial Berkembang)',
                'badge'       => 'info',
                'color'       => '#00cfe8',
                'description' => 'Pelanggan aktif dengan transaksi rutin dan nilai belanja moderat.',
                'strategy'    => 'Tawarkan program loyalitas, bundling koper + aksesoris, dan diskon repeat order.'
            ],
            2 => [
                'label'       => 'At Risk (Perlu Perhatian Retensi)',
                'badge'       => 'warning',
                'color'       => '#ff9f43',
                'description' => 'Pernah berbelanja dengan nilai baik tetapi sudah lama tidak melakukan transaksi.',
                'strategy'    => 'Kirimkan email/WhatsApp re-engagement, diskon personalisasi "Kami Rindukan Anda", atau voucher ongkir.'
            ],
            3 => [
                'label'       => 'Hibernating / Churn (Tidak Aktif)',
                'badge'       => 'danger',
                'color'       => '#ea5455',
                'description' => 'Pelanggan dengan frekuensi rendah dan sudah sangat lama tidak berinteraksi.',
                'strategy'    => 'Kampanye cuci gudang massal atau survei kepuasan pelanggan untuk memahami alasan ketidakaktifan.'
            ],
        ];

        $formattedSegments = [];
        $chartData = [
            'labels' => [],
            'counts' => [],
            'colors' => []
        ];

        $totalCustomers = Pelanggan::count();

        foreach ($clusterMetrics as $rank => $cm) {
            $def = $segmentNames[$rank] ?? $segmentNames[3];
            $count = $cm['count'] ?? 0;
            $pct = $totalCustomers > 0 ? round(($count / $totalCustomers) * 100, 1) : 0;

            $formattedSegments[] = [
                'cluster_id'    => $rank + 1,
                'name'          => $def['label'],
                'badge'         => $def['badge'],
                'color'         => $def['color'],
                'description'   => $def['description'],
                'strategy'      => $def['strategy'],
                'customer_count'=> $count,
                'percentage'    => $pct,
                'avg_recency'   => $cm['avg_recency'] ?? 0,
                'avg_frequency' => $cm['avg_frequency'] ?? 0,
                'avg_monetary'  => $cm['avg_monetary'] ?? 0,
                'customers'     => $cm['members'] ?? []
            ];

            $chartData['labels'][] = $def['label'];
            $chartData['counts'][] = $count;
            $chartData['colors'][] = $def['color'];
        }

        return [
            'segments'   => $formattedSegments,
            'chart_data' => $chartData
        ];
    }
}
