@extends('layouts.default')
@section('title', __('Segmentasi Pelanggan RFM K-Means - MVL Koper'))
@section('content')

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); color: #fff; border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <span class="badge bg-success mb-2 px-3 py-2"><i class="bx bx-group me-1"></i> UNSUPERVISED LEARNING & RFM MODEL</span>
                        <h3 class="text-white mb-1" style="font-weight: 700;">Segmentasi Pelanggan K-Means Clustering</h3>
                        <p class="text-light opacity-75 mb-0">Pengelompokan profil pelanggan MVL Koper berdasarkan metrik <strong>Recency (Hari Terakhir Beli)</strong>, <strong>Frequency (Jumlah Transaksi)</strong>, dan <strong>Monetary (Total Nilai Belanja)</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cluster Cards Summary -->
    @foreach($segmentation['segments'] as $seg)
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm" style="border-top: 4px solid {{ $seg['color'] }}; border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-{{ $seg['badge'] }}">Klaster {{ $seg['cluster_id'] }}</span>
                    <span class="fw-bold fs-5" style="color: {{ $seg['color'] }};">{{ $seg['customer_count'] }} Pelanggan</span>
                </div>
                <h6 class="card-title fw-bold mb-1">{{ $seg['name'] }}</h6>
                <p class="small text-muted mb-3">{{ $seg['description'] }}</p>
                
                <div class="bg-light p-2 rounded mb-3 small">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Rata-rata Recency:</span>
                        <span class="fw-bold">{{ $seg['avg_recency'] }} hari lalu</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Rata-rata Frekuensi:</span>
                        <span class="fw-bold">{{ $seg['avg_frequency'] }}x beli</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Rata-rata Nilai:</span>
                        <span class="fw-bold text-success">Rp {{ number_format($seg['avg_monetary'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="border-top pt-2">
                    <small class="fw-bold text-primary"><i class="bx bx-bulb me-1"></i> Strategi Bisnis:</small>
                    <p class="small text-dark mb-0 mt-1">{{ $seg['strategy'] }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Visual Chart & Mathematical Explanation -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-0">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-bar-chart-alt-2 me-1 text-primary"></i> Distribusi Anggota Tiap Segmen</h5>
                <small class="text-muted">Perbandingan jumlah pelanggan pada tiap klaster K-Means</small>
            </div>
            <div class="card-body pt-3">
                <canvas id="segBarChart" style="max-height: 280px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-0">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-code-block me-1 text-info"></i> Metodologi & Formulasi Matematis</h5>
                <small class="text-muted">Dasar komputasi K-Means RFM pada sistem</small>
            </div>
            <div class="card-body pt-3 small">
                <div class="p-3 mb-3 rounded bg-light border">
                    <h6 class="fw-bold text-primary mb-1">1. Normalisasi Fitur (Min-Max Scaling)</h6>
                    <code>X_scaled = (X - X_min) / (X_max - X_min)</code>
                    <p class="text-muted mb-0 mt-1">Menyamakan skala dimensi hari (Recency), jumlah transaksi (Frequency), dan rupiah belanja (Monetary) ke rentang [0.0, 1.0].</p>
                </div>
                <div class="p-3 rounded bg-light border">
                    <h6 class="fw-bold text-primary mb-1">2. Fungsi Objektif K-Means (Minimisasi SSE)</h6>
                    <code>J = &Sigma; &Sigma; || x_i - c_j ||&sup2;</code>
                    <p class="text-muted mb-0 mt-1">Iterasi konvergensi jarak Euclidean antara vektor data pelanggan $x_i$ dengan titik pusat klaster $c_j$.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Member List per Segment -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-table me-1 text-primary"></i> Rincian Data Pelanggan Berdasarkan Klaster</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills mb-3" role="tablist">
                    @foreach($segmentation['segments'] as $idx => $seg)
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $idx == 0 ? 'active' : '' }}" role="tab" data-bs-toggle="tab" data-bs-target="#tab-cluster-{{ $seg['cluster_id'] }}">
                            <span class="badge bg-{{ $seg['badge'] }} me-1">{{ $seg['customer_count'] }}</span> {{ $seg['name'] }}
                        </button>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($segmentation['segments'] as $idx => $seg)
                    <div class="tab-pane fade {{ $idx == 0 ? 'show active' : '' }}" id="tab-cluster-{{ $seg['cluster_id'] }}" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Kontak (Email / No HP)</th>
                                        <th>Recency (Terakhir Belanja)</th>
                                        <th>Frequency</th>
                                        <th>Monetary (Total Belanja)</th>
                                        <th>Rekomendasi Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($seg['customers'] as $cust)
                                    <tr>
                                        <td class="fw-bold">{{ $cust['nama'] }}</td>
                                        <td>{{ $cust['email'] }} <br><small class="text-muted">{{ $cust['no_hp'] }}</small></td>
                                        <td><span class="badge bg-label-info">{{ $cust['recency'] }} Hari Lalu</span></td>
                                        <td><span class="badge bg-label-primary">{{ $cust['frequency'] }}x Transaksi</span></td>
                                        <td class="fw-bold text-success">Rp {{ number_format($cust['monetary'], 0, ',', '.') }}</td>
                                        <td><small class="text-dark">{{ $seg['strategy'] }}</small></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Tidak ada pelanggan pada klaster ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const segLabels = @json($segmentation['chart_data']['labels']);
    const segCounts = @json($segmentation['chart_data']['counts']);
    const segColors = @json($segmentation['chart_data']['colors']);

    const ctxBar = document.getElementById('segBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: segLabels,
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: segCounts,
                backgroundColor: segColors,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>

@endsection
