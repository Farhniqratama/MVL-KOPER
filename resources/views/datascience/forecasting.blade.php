@extends('layouts.default')
@section('title', __('Peramalan Penjualan & Forecasting - MVL Koper'))
@section('content')

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color: #fff; border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <span class="badge bg-warning text-dark mb-2 px-3 py-2"><i class="bx bx-trending-up me-1"></i> TIME-SERIES & PREDICTIVE MODELING</span>
                        <h3 class="text-white mb-1" style="font-weight: 700;">Peramalan Penjualan & Kebutuhan Stok</h3>
                        <p class="text-light opacity-75 mb-0">Model time-series gabungan <strong>Holt-Winters Exponential Smoothing</strong> dan <strong>Linear Regression Trend</strong> untuk memproyeksikan omzet dan unit stok koper.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Parameter Tuning & Metrics -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-2">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-slider me-1 text-primary"></i> Parameter Smoothing (&alpha;)</h5>
                <small class="text-muted">Atur tingkat sensitivitas peramalan</small>
            </div>
            <div class="card-body">
                <form action="{{ URL::to('/data-science/forecasting') }}" method="GET" class="mb-4">
                    <label class="form-label fw-bold">Alpha Smoothing Factor: <span class="text-primary fs-6" id="alphaVal">{{ $alpha }}</span></label>
                    <input type="range" class="form-range" min="0.1" max="0.9" step="0.1" name="alpha" value="{{ $alpha }}" oninput="document.getElementById('alphaVal').innerText = this.value">
                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2"><i class="bx bx-refresh me-1"></i> Hitung Ulang Prediksi</button>
                </form>

                <h6 class="fw-bold border-top pt-3 mb-2"><i class="bx bx-check-shield text-success me-1"></i> Metrik Akurasi Model</h6>
                <div class="bg-light p-2 rounded small mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Akurasi Model (100 - MAPE):</span>
                        <span class="fw-bold text-success">{{ $forecasting['metrics']['accuracy'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Mean Absolute Error (MAE):</span>
                        <span class="fw-bold">Rp {{ number_format($forecasting['metrics']['mae'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">MAPE Error Rate:</span>
                        <span class="fw-bold text-warning">{{ $forecasting['metrics']['mape'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">RMSE:</span>
                        <span class="fw-bold">Rp {{ number_format($forecasting['metrics']['rmse'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forecasting Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-0">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-line-chart me-1 text-primary"></i> Visualisasi Kurva Historis vs Proyeksi Masa Depan</h5>
                <small class="text-muted">Garis oranye putus-putus menunjukkan estimasi omzet 6 bulan ke depan.</small>
            </div>
            <div class="card-body pt-3">
                <canvas id="mainForecastChart" style="max-height: 320px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Future Projections Table -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-header">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-calendar-event me-1 text-primary"></i> Tabel Estimasi Penjualan & Kebutuhan Stok Unit Masa Depan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Periode Bulan</th>
                                <th>Status Proyeksi</th>
                                <th>Estimasi Omzet Penjualan</th>
                                <th>Estimasi Kebutuhan Unit (Koper)</th>
                                <th>Rekomendasi Buffer Safety Stock (+25%)</th>
                                <th>Aksi Rantai Pasok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forecasting['forecast']['labels'] as $idx => $mLabel)
                            <tr>
                                <td class="fw-bold text-primary">{{ $mLabel }}</td>
                                <td><span class="badge bg-label-warning"><i class="bx bx-time-five me-1"></i> Proyeksi Model AI</span></td>
                                <td class="fw-bold text-success fs-6">Rp {{ number_format($forecasting['forecast']['revenues'][$idx], 0, ',', '.') }}</td>
                                <td class="fw-bold">{{ $forecasting['forecast']['units'][$idx] }} Unit</td>
                                <td><span class="badge bg-label-info fw-bold">{{ round($forecasting['forecast']['units'][$idx] * 1.25) }} Unit</span></td>
                                <td><small class="text-dark">Siapkan PO stok koper dari vendor sebelum awal bulan {{ $mLabel }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const histLabels = @json($forecasting['historical']['labels']);
    const histRevenues = @json($forecasting['historical']['revenues']);
    const histSmoothed = @json($forecasting['historical']['smoothed']);
    const futureLabels = @json($forecasting['forecast']['labels']);
    const futureRevenues = @json($forecasting['forecast']['revenues']);

    const allLabels = histLabels.concat(futureLabels);
    const actualDataPadded = histRevenues.concat(Array(futureLabels.length).fill(null));
    const smoothedDataPadded = histSmoothed.concat(Array(futureLabels.length).fill(null));
    
    const lastHistVal = histRevenues[histRevenues.length - 1];
    const forecastDataPadded = Array(histLabels.length - 1).fill(null).concat([lastHistVal]).concat(futureRevenues);

    const ctxForecast = document.getElementById('mainForecastChart').getContext('2d');
    new Chart(ctxForecast, {
        type: 'line',
        data: {
            labels: allLabels,
            datasets: [
                {
                    label: 'Penjualan Aktual (Rp)',
                    data: actualDataPadded,
                    borderColor: '#233876',
                    backgroundColor: 'rgba(35, 56, 118, 0.1)',
                    borderWidth: 3,
                    pointRadius: 4,
                    tension: 0.25
                },
                {
                    label: 'Exponential Smoothed (Rp)',
                    data: smoothedDataPadded,
                    borderColor: '#00cfe8',
                    borderDash: [4, 4],
                    borderWidth: 2,
                    pointRadius: 0,
                    fill: false,
                    tension: 0.25
                },
                {
                    label: 'Proyeksi Forecasting (Rp)',
                    data: forecastDataPadded,
                    borderColor: '#ff9f43',
                    backgroundColor: 'rgba(255, 159, 67, 0.18)',
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#ff9f43',
                    borderDash: [6, 4],
                    fill: true,
                    tension: 0.25
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + ' Jt';
                        }
                    }
                }
            }
        }
    });
});
</script>

@endsection
