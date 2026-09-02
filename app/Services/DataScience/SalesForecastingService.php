<?php

namespace App\Services\DataScience;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
use DB;

class SalesForecastingService
{
    /**
     * Menjalankan Analisis Peramalan Penjualan Murni Berbasis Data Transaksi Nyata di Database
     */
    public function getSalesForecast($monthsAhead = 4, $alpha = 0.4)
    {
        // Ambil data riil dari tabel transaksi
        $monthlyData = $this->getMonthlyHistoricalData();

        if (empty($monthlyData)) {
            return [
                'historical' => ['labels' => [], 'revenues' => [], 'units' => [], 'smoothed' => []],
                'forecast'   => ['labels' => [], 'revenues' => [], 'units' => []],
                'metrics'    => ['mae' => 0, 'mape' => '0%', 'rmse' => 0, 'accuracy' => '100%'],
                'summary'    => [
                    'next_month_revenue' => 0,
                    'next_month_units'   => 0,
                    'trend_direction'    => 'Data Belum Tersedia',
                    'growth_rate'        => 0,
                    'safety_stock_rec'   => 0
                ]
            ];
        }

        $periods = count($monthlyData);
        $actualRevenues = array_column($monthlyData, 'revenue');
        $actualUnits = array_column($monthlyData, 'units');
        $labels = array_column($monthlyData, 'month_name');

        // 1. Model Exponential Smoothing
        $expSmoothed = $this->exponentialSmoothing($actualRevenues, $alpha);

        // 2. Model Linear Regression Trend
        $linearTrend = $this->linearRegressionTrend($actualRevenues);

        // 3. Proyeksi Masa Depan (Future Forecasts)
        $futureMonths = [];
        $futureRevenues = [];
        $futureUnits = [];
        
        $lastDateStr = end($monthlyData)['date'] ?? date('Y-m-01');
        $lastDate = Carbon::parse($lastDateStr);

        $slope = $linearTrend['slope'];
        $intercept = $linearTrend['intercept'];
        $lastExpVal = end($expSmoothed) ?: end($actualRevenues);

        for ($i = 1; $i <= $monthsAhead; $i++) {
            $nextDate = $lastDate->copy()->addMonths($i);
            $futureMonths[] = $nextDate->format('M Y');

            // Proyeksi tren regresi linear matematis dari data riil
            $trendForecast = $intercept + ($slope * ($periods + $i));
            $expForecast = $lastExpVal + ($slope * $i);
            
            // Bobot kombinasi ensemble model
            $ensembleVal = round(($trendForecast * 0.6) + ($expForecast * 0.4), 0);
            $finalForecastVal = max(0, $ensembleVal);

            $futureRevenues[] = $finalForecastVal;
            
            // Hitung estimasi unit koper (berdasarkan harga rata-rata riil dari transaksi database)
            $avgPrice = $this->getAverageItemPrice();
            $futureUnits[] = max(1, (int) round($finalForecastVal / max(1, $avgPrice)));
        }

        // 4. Hitung Metrik Evaluasi Akurasi (MAE, MAPE, RMSE)
        $metrics = $this->calculateErrorMetrics($actualRevenues, $expSmoothed);

        $lastActual = end($actualRevenues);
        $growthRate = $lastActual > 0 ? round(($slope / $lastActual) * 100, 2) : 0;

        return [
            'historical' => [
                'labels'   => $labels,
                'revenues' => $actualRevenues,
                'units'    => $actualUnits,
                'smoothed' => $expSmoothed
            ],
            'forecast'   => [
                'labels'   => $futureMonths,
                'revenues' => $futureRevenues,
                'units'    => $futureUnits,
            ],
            'metrics'    => $metrics,
            'summary'    => [
                'next_month_revenue' => $futureRevenues[0] ?? 0,
                'next_month_units'   => $futureUnits[0] ?? 0,
                'trend_direction'    => $slope >= 0 ? 'Kenaikan Tren (Positif)' : 'Penurunan Tren (Negatif)',
                'growth_rate'        => $growthRate,
                'safety_stock_rec'   => round(($futureUnits[0] ?? 1) * 1.25) // Buffer stock +25%
            ]
        ];
    }

    /**
     * Ambil data transaksi bulanan langsung dari basis data tanpa modifikasi/dummy
     */
    private function getMonthlyHistoricalData()
    {
        $raw = Transaksi::whereNotNull('tgl_transaksi')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('DATE_FORMAT(tgl_transaksi, "%Y-%m-01") as month_date'),
                DB::raw('SUM(total_pembayaran) as revenue'),
                DB::raw('COUNT(id) as total_tx')
            )
            ->groupBy('month_date')
            ->orderBy('month_date', 'asc')
            ->get();

        $result = [];
        $avgPrice = $this->getAverageItemPrice();

        foreach ($raw as $r) {
            $dt = Carbon::parse($r->month_date);
            $rev = (float) $r->revenue;
            $result[] = [
                'date'       => $r->month_date,
                'month_name' => $dt->format('M Y'),
                'revenue'    => $rev,
                'units'      => max(1, (int) round($rev / max(1, $avgPrice)))
            ];
        }

        return $result;
    }

    /**
     * Dapatkan rata-rata harga produk nyata dari detail transaksi / produk
     */
    private function getAverageItemPrice()
    {
        $avgFromProducts = DB::table('produk')->whereNull('deleted_at')->avg('harga');
        return $avgFromProducts ? (float) $avgFromProducts : 3500000;
    }

    /**
     * Single Exponential Smoothing: S_t = alpha * Y_t + (1 - alpha) * S_{t-1}
     */
    private function exponentialSmoothing(array $actuals, $alpha = 0.4)
    {
        $smoothed = [];
        if (empty($actuals)) return $smoothed;

        $smoothed[0] = $actuals[0];
        for ($i = 1; $i < count($actuals); $i++) {
            $smoothed[$i] = round(($alpha * $actuals[$i]) + ((1 - $alpha) * $smoothed[$i - 1]), 0);
        }

        return $smoothed;
    }

    /**
     * Linear Regression Trend Model: Y = a + bX
     */
    private function linearRegressionTrend(array $actuals)
    {
        $n = count($actuals);
        if ($n < 2) {
            return ['slope' => 0, 'intercept' => $actuals[0] ?? 0];
        }

        $xSum = 0;
        $ySum = 0;
        $xySum = 0;
        $x2Sum = 0;

        for ($i = 1; $i <= $n; $i++) {
            $x = $i;
            $y = $actuals[$i - 1];

            $xSum += $x;
            $ySum += $y;
            $xySum += ($x * $y);
            $x2Sum += ($x * $x);
        }

        $denominator = (($n * $x2Sum) - ($xSum * $xSum));
        $slope = ($denominator != 0) ? ((($n * $xySum) - ($xSum * $ySum)) / $denominator) : 0;
        $intercept = ($ySum - ($slope * $xSum)) / $n;

        return [
            'slope'     => $slope,
            'intercept' => $intercept
        ];
    }

    /**
     * Evaluasi Metrik Akurasi Peramalan (MAE, MAPE, RMSE)
     */
    private function calculateErrorMetrics(array $actuals, array $predicted)
    {
        $n = count($actuals);
        if ($n <= 1) {
            return ['mae' => 0, 'mape' => '0.00%', 'rmse' => 0, 'accuracy' => '100%'];
        }

        $absErrors = [];
        $pctErrors = [];
        $sqErrors = [];

        for ($i = 1; $i < $n; $i++) {
            $err = abs($actuals[$i] - $predicted[$i]);
            $absErrors[] = $err;
            if ($actuals[$i] > 0) {
                $pctErrors[] = ($err / $actuals[$i]) * 100;
            }
            $sqErrors[] = pow($err, 2);
        }

        $mae = count($absErrors) > 0 ? array_sum($absErrors) / count($absErrors) : 0;
        $mape = count($pctErrors) > 0 ? array_sum($pctErrors) / count($pctErrors) : 0;
        $rmse = count($sqErrors) > 0 ? sqrt(array_sum($sqErrors) / count($sqErrors)) : 0;

        return [
            'mae'        => round($mae, 0),
            'mape'       => round($mape, 2) . '%',
            'rmse'       => round($rmse, 0),
            'accuracy'   => round(max(0, 100 - $mape), 2) . '%'
        ];
    }
}
