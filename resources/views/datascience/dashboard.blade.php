@extends('layouts.default')
@section('title', __('Data Science & AI Command Center - MVL Koper'))
@section('content')

<div class="row">
    <!-- Header Banner -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary me-2 px-3 py-2" style="font-size: 0.85rem; letter-spacing: 1px;">
                                <i class="bx bx-brain me-1"></i> AI & DATA SCIENCE ENGINE
                            </span>
                            <span class="badge bg-success px-3 py-2" style="font-size: 0.85rem;">
                                <i class="bx bx-check-circle me-1"></i> BOBOT 80% DATA SCIENCE
                            </span>
                        </div>
                        <h3 class="text-white mb-1" style="font-weight: 700;">MVL KOPER Intelligent Analytics Platform</h3>
                        <p class="text-light opacity-75 mb-0">Arsitektur terintegrasi Machine Learning, RFM Customer Clustering, Time-Series Forecasting, Item-Based Collaborative Filtering, dan NLP Sentiment Analysis.</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <span class="badge bg-dark border border-secondary px-3 py-2 text-info">
                            <i class="bx bx-sync me-1"></i> Status: {{ $pipelineSummary['health_status'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 KPI Metrics Card -->
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-primary h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-primary p-2"><i class="bx bx-group bx-sm text-primary"></i></span>
                    </div>
                    <h5 class="ms-1 mb-0" style="font-weight: 700;">{{ $pipelineSummary['total_customers'] }}</h5>
                </div>
                <p class="mb-1 text-muted small fw-semibold">Pelanggan Tersegmentasi</p>
                <div class="d-flex align-items-center">
                    <small class="text-success fw-bold"><i class="bx bx-check"></i> K-Means 4 Clusters</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-warning h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-warning p-2"><i class="bx bx-trending-up bx-sm text-warning"></i></span>
                    </div>
                    <h5 class="ms-1 mb-0" style="font-weight: 700;">Rp {{ number_format($forecasting['summary']['next_month_revenue'], 0, ',', '.') }}</h5>
                </div>
                <p class="mb-1 text-muted small fw-semibold">Proyeksi Penjualan Bulan Depan</p>
                <div class="d-flex align-items-center">
                    <small class="text-info fw-bold"><i class="bx bx-line-chart"></i> Akurasi Model: {{ $forecasting['metrics']['accuracy'] }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-success h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-success p-2"><i class="bx bx-smile bx-sm text-success"></i></span>
                    </div>
                    <h5 class="ms-1 mb-0" style="font-weight: 700;">{{ $sentiment['csi'] }}%</h5>
                </div>
                <p class="mb-1 text-muted small fw-semibold">Customer Satisfaction Index (CSI)</p>
                <div class="d-flex align-items-center">
                    <small class="text-success fw-bold"><i class="bx bx-like"></i> {{ $sentiment['csi_status'] }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-danger h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-danger p-2"><i class="bx bx-package bx-sm text-danger"></i></span>
                    </div>
                    <h5 class="ms-1 mb-0" style="font-weight: 700;">{{ $forecasting['summary']['safety_stock_rec'] }} Unit</h5>
                </div>
                <p class="mb-1 text-muted small fw-semibold">Rekomendasi Safety Stock</p>
                <div class="d-flex align-items-center">
                    <small class="text-muted fw-bold"><i class="bx bx-shield-quarter"></i> Buffer Stock (+25%)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 1: Sales Forecasting (Historis vs Forecast) -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div>
                    <h5 class="card-title mb-1" style="font-weight: 700;"><i class="bx bx-line-chart me-1 text-primary"></i> Peramalan Penjualan (Time-Series Holt-Winters & Linear Trend)</h5>
                    <small class="text-muted">Kombinasi data penjualan aktual, smoothing filter, dan proyeksi omzet masa depan.</small>
                </div>
                <a href="{{ URL::to('/data-science/forecasting') }}" class="btn btn-sm btn-outline-primary">Detail Model</a>
            </div>
            <div class="card-body pt-3">
                <canvas id="forecastChart" style="max-height: 320px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 2: Customer Segmentation Donut -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div>
                    <h5 class="card-title mb-1" style="font-weight: 700;"><i class="bx bx-pie-chart-alt me-1 text-success"></i> Segmen Pelanggan RFM</h5>
                    <small class="text-muted">Proporsi klaster K-Means</small>
                </div>
                <a href="{{ URL::to('/data-science/segmentation') }}" class="btn btn-sm btn-outline-success">Lihat Segmen</a>
            </div>
            <div class="card-body pt-3 text-center">
                <div style="max-height: 230px; position: relative;">
                    <canvas id="segmentDonutChart"></canvas>
                </div>
                <div class="mt-3 text-start small">
                    @foreach($segmentation['segments'] as $seg)
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span><i class="bx bxs-circle me-1" style="color: {{ $seg['color'] }}; font-size: 0.65rem;"></i> {{ $seg['name'] }}</span>
                        <span class="fw-bold">{{ $seg['customer_count'] }} ({{ $seg['percentage'] }}%)</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- NLP Sentiment Breakdown & Top Market Basket Rules -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-1" style="font-weight: 700;"><i class="bx bx-message-square-detail me-1 text-info"></i> Analisis Sentimen Ulasan (NLP)</h5>
                    <small class="text-muted">Distribusi sentimen teks ulasan pelanggan</small>
                </div>
                <a href="{{ URL::to('/data-science/sentiment') }}" class="btn btn-sm btn-outline-info">Detail NLP</a>
            </div>
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-5 text-center">
                        <canvas id="sentimentPieChart" style="max-height: 160px;"></canvas>
                    </div>
                    <div class="col-7">
                        <div class="p-2 mb-2 rounded bg-light">
                            <div class="d-flex justify-content-between">
                                <span class="text-success fw-bold"><i class="bx bx-smile"></i> Positif</span>
                                <span class="fw-bold">{{ $sentiment['positive_count'] }} ulasan ({{ $sentiment['positive_pct'] }}%)</span>
                            </div>
                        </div>
                        <div class="p-2 mb-2 rounded bg-light">
                            <div class="d-flex justify-content-between">
                                <span class="text-info fw-bold"><i class="bx bx-meh"></i> Netral</span>
                                <span class="fw-bold">{{ $sentiment['neutral_count'] }} ulasan ({{ $sentiment['neutral_pct'] }}%)</span>
                            </div>
                        </div>
                        <div class="p-2 rounded bg-light">
                            <div class="d-flex justify-content-between">
                                <span class="text-danger fw-bold"><i class="bx bx-frown"></i> Negatif</span>
                                <span class="fw-bold">{{ $sentiment['negative_count'] }} ulasan ({{ $sentiment['negative_pct'] }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-muted small fw-bold">Kata Kunci Populer (Word Tokens):</span>
                    <div class="d-flex flex-wrap gap-1 mt-1">
                        @foreach($sentiment['top_keywords'] as $word => $count)
                        <span class="badge bg-label-primary px-2 py-1" style="font-size: 0.75rem;">#{{ $word }} ({{ $count }})</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-1" style="font-weight: 700;"><i class="bx bx-cart-alt me-1 text-danger"></i> Market Basket Analysis (Apriori)</h5>
                    <small class="text-muted">Pola produk yang sering dibeli bersamaan</small>
                </div>
                <a href="{{ URL::to('/data-science/recommender') }}" class="btn btn-sm btn-outline-danger">Eksplorasi Aturan</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Jika Membeli (A)</th>
                                <th>Maka Membeli (B)</th>
                                <th>Support</th>
                                <th>Confidence</th>
                                <th>Lift Ratio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($recommender, 0, 4) as $rule)
                            <tr>
                                <td class="fw-semibold text-truncate" style="max-width: 130px;">{{ $rule['antecedent_name'] }}</td>
                                <td class="fw-semibold text-truncate text-primary" style="max-width: 130px;">{{ $rule['consequent_name'] }}</td>
                                <td><span class="badge bg-label-info">{{ $rule['support'] }}%</span></td>
                                <td><span class="badge bg-label-success">{{ $rule['confidence'] }}%</span></td>
                                <td><span class="badge bg-label-danger fw-bold">{{ $rule['lift'] }}x</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Forecast Line Chart
    const histLabels = @json($forecasting['historical']['labels']);
    const histRevenues = @json($forecasting['historical']['revenues']);
    const histSmoothed = @json($forecasting['historical']['smoothed']);
    const futureLabels = @json($forecasting['forecast']['labels']);
    const futureRevenues = @json($forecasting['forecast']['revenues']);

    const allLabels = histLabels.concat(futureLabels);
    const actualDataPadded = histRevenues.concat(Array(futureLabels.length).fill(null));
    const smoothedDataPadded = histSmoothed.concat(Array(futureLabels.length).fill(null));
    
    // Sambungkan titik terakhir aktual ke garis proyeksi
    const lastHistVal = histRevenues[histRevenues.length - 1];
    const forecastDataPadded = Array(histLabels.length - 1).fill(null).concat([lastHistVal]).concat(futureRevenues);

    const ctxForecast = document.getElementById('forecastChart').getContext('2d');
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
                    borderWidth: 2.5,
                    pointRadius: 4,
                    tension: 0.3
                },
                {
                    label: 'Exponential Smoothed (Rp)',
                    data: smoothedDataPadded,
                    borderColor: '#00cfe8',
                    borderDash: [4, 4],
                    borderWidth: 2,
                    pointRadius: 0,
                    fill: false,
                    tension: 0.3
                },
                {
                    label: 'Proyeksi Forecast (Rp)',
                    data: forecastDataPadded,
                    borderColor: '#ff9f43',
                    backgroundColor: 'rgba(255, 159, 67, 0.15)',
                    borderWidth: 2.5,
                    pointRadius: 5,
                    pointBackgroundColor: '#ff9f43',
                    borderDash: [6, 4],
                    fill: true,
                    tension: 0.3
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

    // 2. Customer Segmentation Donut Chart
    const segLabels = @json($segmentation['chart_data']['labels']);
    const segCounts = @json($segmentation['chart_data']['counts']);
    const segColors = @json($segmentation['chart_data']['colors']);

    const ctxDonut = document.getElementById('segmentDonutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: segLabels,
            datasets: [{
                data: segCounts,
                backgroundColor: segColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            cutout: '70%'
        }
    });

    // 3. Sentiment Pie Chart
    const ctxSentiment = document.getElementById('sentimentPieChart').getContext('2d');
    new Chart(ctxSentiment, {
        type: 'pie',
        data: {
            labels: ['Positif', 'Netral', 'Negatif'],
            datasets: [{
                data: [{{ $sentiment['positive_count'] }}, {{ $sentiment['neutral_count'] }}, {{ $sentiment['negative_count'] }}],
                backgroundColor: ['#28c76f', '#00cfe8', '#ea5455'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>

@endsection
