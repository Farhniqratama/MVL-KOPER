@extends('layouts.default')
@section('title', __('Analisis Sentimen Ulasan (NLP) - MVL Koper'))
@section('content')

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <span class="badge bg-light text-primary mb-2 px-3 py-2"><i class="bx bx-message-square-detail me-1"></i> NATURAL LANGUAGE PROCESSING (NLP)</span>
                        <h3 class="text-white mb-1" style="font-weight: 700;">Analisis Sentimen Teks Ulasan Pelanggan</h3>
                        <p class="text-light opacity-75 mb-0">Pemrosesan bahasa alami (NLP Lexicon Mining) untuk mengekstrak polaritas ulasan, mendeteksi keluhan, dan menghitung <strong>Customer Satisfaction Index (CSI)</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 Metrics Card -->
    <div class="col-md-4 mb-4">
        <div class="card card-border-shadow-success h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="avatar-initial rounded bg-label-success p-2"><i class="bx bx-smile bx-md text-success"></i></span>
                    <span class="badge bg-label-success fs-6">{{ $sentiment['positive_pct'] }}%</span>
                </div>
                <h4 class="fw-bold mb-1">{{ $sentiment['positive_count'] }} Ulasan Positif</h4>
                <p class="small text-muted mb-0">Ulasan dengan sentimen puas, apresiasi kualitas koper, dan rekomendasi pembelian.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card card-border-shadow-info h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="avatar-initial rounded bg-label-info p-2"><i class="bx bx-meh bx-md text-info"></i></span>
                    <span class="badge bg-label-info fs-6">{{ $sentiment['neutral_pct'] }}%</span>
                </div>
                <h4 class="fw-bold mb-1">{{ $sentiment['neutral_count'] }} Ulasan Netral</h4>
                <p class="small text-muted mb-0">Ulasan standar atau masukan fungsional tanpa ekspresi emosi dominan.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card card-border-shadow-danger h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="avatar-initial rounded bg-label-danger p-2"><i class="bx bx-frown bx-md text-danger"></i></span>
                    <span class="badge bg-label-danger fs-6">{{ $sentiment['negative_pct'] }}%</span>
                </div>
                <h4 class="fw-bold mb-1">{{ $sentiment['negative_count'] }} Ulasan Negatif</h4>
                <p class="small text-muted mb-0">Ulasan yang memuat keluhan terkait ekspedisi, lecet barang, atau kendala resleting.</p>
            </div>
        </div>
    </div>

    <!-- Sentiment Visualizations -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-0">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-pie-chart me-1 text-primary"></i> Rasio Polaritas Sentimen Pelanggan</h5>
            </div>
            <div class="card-body pt-3 text-center">
                <div style="max-height: 250px; position: relative;">
                    <canvas id="nlpPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-0">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-tag me-1 text-info"></i> Ekstraksi Kata Kunci Dominan (Text Tokens)</h5>
            </div>
            <div class="card-body pt-3">
                <p class="small text-muted mb-3">Kata-kata yang paling sering muncul dari hasil tokenisasi ulasan teks:</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($sentiment['top_keywords'] as $word => $count)
                    <div class="p-2 border rounded bg-light d-flex align-items-center">
                        <span class="fw-bold text-primary me-2">#{{ $word }}</span>
                        <span class="badge bg-primary rounded-pill">{{ $count }}x</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Feed Ulasan yang Dianalisis oleh Model NLP -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-header">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-list-check me-1 text-primary"></i> Feed Hasil Klasifikasi NLP Tiap Ulasan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Rating</th>
                                <th style="width: 35%;">Teks Ulasan Asli</th>
                                <th>Klasifikasi NLP</th>
                                <th>Skor Polaritas</th>
                                <th>Kata Kunci Terdeteksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sentiment['reviews_feed'] as $rf)
                            <tr>
                                <td class="fw-bold">{{ $rf['nama_pelanggan'] }}</td>
                                <td class="text-truncate" style="max-width: 140px;">{{ $rf['nama_produk'] }}</td>
                                <td>
                                    <span class="text-warning">
                                        @for($i=1; $i<=$rf['rating']; $i++) &#9733; @endfor
                                    </span>
                                </td>
                                <td>"{{ $rf['raw_text'] }}"</td>
                                <td><span class="badge bg-{{ $rf['badge'] }}">{{ $rf['sentiment'] }}</span></td>
                                <td class="fw-bold">{{ $rf['score'] }}</td>
                                <td>
                                    @foreach($rf['key_phrases'] as $phrase)
                                    <span class="badge bg-label-secondary small me-1">{{ $phrase }}</span>
                                    @endforeach
                                </td>
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
    const ctxNLP = document.getElementById('nlpPieChart').getContext('2d');
    new Chart(ctxNLP, {
        type: 'doughnut',
        data: {
            labels: ['Positif', 'Netral', 'Negatif'],
            datasets: [{
                data: [{{ $sentiment['positive_count'] }}, {{ $sentiment['neutral_count'] }}, {{ $sentiment['negative_count'] }}],
                backgroundColor: ['#28c76f', '#00cfe8', '#ea5455'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%'
        }
    });
});
</script>

@endsection
