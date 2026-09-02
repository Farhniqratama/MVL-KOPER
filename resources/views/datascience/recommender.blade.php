@extends('layouts.default')
@section('title', __('Sistem Rekomendasi & Apriori - MVL Koper'))
@section('content')

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4c1d95 0%, #312e81 100%); color: #fff; border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <span class="badge bg-danger mb-2 px-3 py-2"><i class="bx bx-bulb me-1"></i> RECOMMENDER SYSTEM & MARKET BASKET</span>
                        <h3 class="text-white mb-1" style="font-weight: 700;">Sistem Rekomendasi Cerdas & Aturan Asosiasi Apriori</h3>
                        <p class="text-light opacity-75 mb-0">Personalisasi produk koper menggunakan <strong>Item-Based Cosine Similarity</strong> dan analisis pola belanja silang (*cross-selling*) menggunakan algoritma <strong>Apriori</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Explanation Cards -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-2">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-math me-1 text-primary"></i> 1. Formulasi Cosine Similarity</h5>
                <small class="text-muted">Item-Based Collaborative Filtering</small>
            </div>
            <div class="card-body small">
                <div class="p-3 bg-light rounded border mb-3 text-center">
                    <code class="fs-6 fw-bold">Similarity(A, B) = (A &middot; B) / (||A|| &times; ||B||)</code>
                </div>
                <p class="text-muted mb-0">Menghitung sudut kosinus antara vektor transaksi produk $A$ dan produk $B$. Nilai berkisar antara $0.0$ (tidak ada kemiripan) hingga $1.0$ (kemiripan mutlak). Algoritma ini memberi daya pada widget *"Rekomendasi Cerdas"* di halaman detail produk frontend.</p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 10px;">
            <div class="card-header pb-2">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-cart-add me-1 text-danger"></i> 2. Formulasi Asosiasi Apriori</h5>
                <small class="text-muted">Market Basket Analysis</small>
            </div>
            <div class="card-body small">
                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="p-2 bg-light rounded border text-center">
                            <span class="fw-bold text-primary">Support</span>
                            <div class="small">P(A &cap; B)</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded border text-center">
                            <span class="fw-bold text-success">Confidence</span>
                            <div class="small">P(B | A)</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded border text-center">
                            <span class="fw-bold text-danger">Lift Ratio</span>
                            <div class="small">Conf / Supp(B)</div>
                        </div>
                    </div>
                </div>
                <p class="text-muted mb-0">Lift Ratio > 1.0 mengindikasikan bahwa pelanggan yang membeli produk A secara signifikan lebih sering membeli produk B dibanding frekuensi acak.</p>
            </div>
        </div>
    </div>

    <!-- Apriori Rules Table -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-header">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-list-ol me-1 text-danger"></i> Daftar Aturan Asosiasi Apriori (Pola Pembelian Bersama)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item Pendahulu (Antecedent / A)</th>
                                <th>Item Konsekuensi (Consequent / B)</th>
                                <th>Support (%)</th>
                                <th>Confidence (%)</th>
                                <th>Lift Ratio</th>
                                <th>Interpretasi Bisnis & Rekomendasi Bundling</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aprioriRules as $rule)
                            <tr>
                                <td class="fw-bold">{{ $rule['antecedent_name'] }}</td>
                                <td class="fw-bold text-primary">{{ $rule['consequent_name'] }}</td>
                                <td><span class="badge bg-label-info">{{ $rule['support'] }}%</span></td>
                                <td><span class="badge bg-label-success">{{ $rule['confidence'] }}%</span></td>
                                <td><span class="badge bg-danger fs-6">{{ $rule['lift'] }}x</span></td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $rule['interpretation'] }}</span>
                                    <br><small class="text-muted">Buat paket bundling diskon 5% untuk kedua koper ini di keranjang belanja.</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Belum ada aturan asosiasi yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Cosine Similarity Product Matrix Table -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-header">
                <h5 class="card-title fw-bold mb-0"><i class="bx bx-grid-alt me-1 text-primary"></i> Matriks Kemiripan Cosine Similarity Antar Produk</h5>
                <small class="text-muted">Skor kemiripan produk berbasis transaksi dan kategori [0.000 - 1.000]</small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 450px;">
                    <table class="table table-sm table-bordered text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start" style="min-width: 180px;">Produk Koper</th>
                                @foreach($matrixData['products'] as $p)
                                <th style="font-size: 0.75rem; min-width: 90px;">{{ Str::limit($p->nama_produk, 12) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matrixData['products'] as $p1)
                            <tr>
                                <td class="text-start fw-bold small">{{ $p1->nama_produk }}</td>
                                @foreach($matrixData['products'] as $p2)
                                @php 
                                    $score = $matrixData['matrix'][$p1->id][$p2->id] ?? 0;
                                    $bgColor = ($score == 1) ? '#e0e7ff' : (($score >= 0.6) ? '#dcfce7' : '#f8fafc');
                                    $textColor = ($score >= 0.6) ? '#166534' : '#64748b';
                                @endphp
                                <td style="background-color: {{ $bgColor }}; color: {{ $textColor }}; font-weight: bold; font-size: 0.8rem;">
                                    {{ number_format($score, 2) }}
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
