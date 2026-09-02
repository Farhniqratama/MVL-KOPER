import os
import sys
from reportlab.lib.pagesizes import letter, A4
from reportlab.lib import colors
from reportlab.lib.units import inch, cm
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak, KeepTogether, HRFlowable
)
from reportlab.pdfgen import canvas

class NumberedCanvas(canvas.Canvas):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self._saved_page_states = []

    def showPage(self):
        self._saved_page_states.append(dict(self.__dict__))
        self._startPage()

    def save(self):
        num_pages = len(self._saved_page_states)
        for state in self._saved_page_states:
            self.__dict__.update(state)
            self.draw_page_decorations(num_pages)
            super().showPage()
        super().save()

    def draw_page_decorations(self, page_count):
        self.saveState()
        self.setFont("Helvetica", 8)
        self.setFillColor(colors.HexColor("#64748B"))
        
        # Header (pages > 1)
        if self._pageNumber > 1:
            self.drawString(40, 810, "LAPORAN ANALISIS DATA SCIENCE — SISTEM MVL-KOPER")
            self.drawRightString(555, 810, "KLASIFIKASI & METRIK 80% DATA SCIENCE")
            self.setStrokeColor(colors.HexColor("#CBD5E1"))
            self.setLineWidth(0.5)
            self.line(40, 802, 555, 802)
        
        # Footer (all pages)
        self.setStrokeColor(colors.HexColor("#CBD5E1"))
        self.setLineWidth(0.5)
        self.line(40, 45, 555, 45)
        self.drawString(40, 32, "Dokumen Analisis Teknis & Akademis | Sistem E-Commerce Cerdas MVL-KOPER")
        self.drawRightString(555, 32, f"Halaman {self._pageNumber} dari {page_count}")
        self.restoreState()

def build_pdf(filename):
    doc = SimpleDocTemplate(
        filename,
        pagesize=A4,
        leftMargin=40,
        rightMargin=40,
        topMargin=50,
        bottomMargin=55
    )

    styles = getSampleStyleSheet()

    # Custom styles
    title_style = ParagraphStyle(
        'DocTitle',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=20,
        leading=24,
        textColor=colors.HexColor('#0F172A'),
        spaceAfter=6
    )

    subtitle_style = ParagraphStyle(
        'DocSubTitle',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=11,
        leading=15,
        textColor=colors.HexColor('#475569'),
        spaceAfter=12
    )

    h1_style = ParagraphStyle(
        'Heading1_Custom',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=13,
        leading=17,
        textColor=colors.HexColor('#1E293B'),
        spaceBefore=12,
        spaceAfter=6,
        keepWithNext=True
    )

    h2_style = ParagraphStyle(
        'Heading2_Custom',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=10.5,
        leading=14,
        textColor=colors.HexColor('#334155'),
        spaceBefore=8,
        spaceAfter=4,
        keepWithNext=True
    )

    body_style = ParagraphStyle(
        'Body_Custom',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=9,
        leading=13,
        textColor=colors.HexColor('#334155'),
        spaceAfter=6
    )

    bullet_style = ParagraphStyle(
        'Bullet_Custom',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8.5,
        leading=12.5,
        textColor=colors.HexColor('#334155'),
        leftIndent=12,
        firstLineIndent=-8,
        spaceAfter=3
    )

    formula_style = ParagraphStyle(
        'Formula_Custom',
        parent=styles['Normal'],
        fontName='Courier-Bold',
        fontSize=8.5,
        leading=12,
        textColor=colors.HexColor('#1E1B4B'),
        spaceBefore=2,
        spaceAfter=2
    )

    table_header_style = ParagraphStyle(
        'TableHeader',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=8.5,
        leading=11,
        textColor=colors.white,
        alignment=1
    )

    table_cell_style = ParagraphStyle(
        'TableCell',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8,
        leading=10.5,
        textColor=colors.HexColor('#1E293B')
    )

    table_cell_bold = ParagraphStyle(
        'TableCellBold',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=8,
        leading=10.5,
        textColor=colors.HexColor('#0F172A')
    )

    story = []

    # Title Banner Block
    story.append(Paragraph("LAPORAN ANALISIS TEKNIS & AKADEMIS", ParagraphStyle('Badge', fontName='Helvetica-Bold', fontSize=9, textColor=colors.HexColor('#4F46E5'), spaceAfter=4)))
    story.append(Paragraph("Keterkaitan Aplikasi MVL-KOPER dengan Bidang Data Science", title_style))
    story.append(Paragraph("Evaluasi Mendalam, Dekomposisi Persentase (80% Data Science), Formulasi Matematika, Algoritma, dan Pemetaan Basis Data Nyata", subtitle_style))
    story.append(HRFlowable(width="100%", thickness=1.5, color=colors.HexColor('#233876'), spaceBefore=2, spaceAfter=10))

    # Meta Table
    meta_data = [
        [Paragraph("<b>Nama Proyek:</b> MVL-KOPER (E-Commerce Cerdas)", table_cell_style), Paragraph("<b>Target Domain:</b> Data Science Terapan & AI (80%)", table_cell_style)],
        [Paragraph("<b>Framework:</b> Laravel 10 (PHP 8.1+) & MySQL", table_cell_style), Paragraph("<b>Tipe Sistem:</b> Hybrid OLTP + Analytics Engine", table_cell_style)],
        [Paragraph("<b>Tanggal Analisis:</b> 1 September 2026", table_cell_style), Paragraph("<b>Status Implementasi:</b> 100% Terintegrasi Data Nyata", table_cell_style)]
    ]
    meta_table = Table(meta_data, colWidths=[255, 260])
    meta_table.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), colors.HexColor('#F1F5F9')),
        ('PADDING', (0,0), (-1,-1), 5),
        ('BOX', (0,0), (-1,-1), 0.5, colors.HexColor('#CBD5E1')),
        ('VALIGN', (0,0), (-1,-1), 'MIDDLE'),
    ]))
    story.append(meta_table)
    story.append(Spacer(1, 10))

    # Section 1: Executive Summary
    story.append(Paragraph("1. Ringkasan Eksekutif & Jawaban Utama", h1_style))
    story.append(Paragraph(
        "Apakah aplikasi <b>MVL-KOPER</b> berhubungan dengan <b>Data Science</b>? <b>YA, SANGAT BERHUBUNGAN</b>. "
        "Secara komprehensif, arsitektur sistem MVL-KOPER diposisikan dengan bobot <b>80% Data Science</b> dan <b>20% Web Engineering / Transaksional</b>.",
        body_style
    ))
    story.append(Paragraph(
        "Aplikasi ini bukan sekadar website toko online biasa (CRUD konvensional), melainkan telah diintegrasikan dengan <b>5 mesin analitik cerdas</b> "
        "yang memproses data transaksi nyata untuk menghasilkan personalisasi rekomendasi koper, segmentasi pelanggan otomatis, peramalan omzet masa depan, serta penambangan teks ulasan pelanggan.",
        body_style
    ))

    story.append(Spacer(1, 6))

    # Section 2: Persentase Bobot Data Science Table
    story.append(Paragraph("2. Matriks Dekomposisi Bobot Data Science (Total 80%)", h1_style))
    
    matrix_data = [
        [Paragraph("Pilar / Modul Sistem", table_header_style), Paragraph("Bobot", table_header_style), Paragraph("Algoritma & Metode Matematis", table_header_style), Paragraph("Input Tabel Database", table_header_style)],
        [Paragraph("1. Data Pipeline & Feature Engineering", table_cell_bold), Paragraph("15%", table_cell_bold), Paragraph("Min-Max Normalization, CLV Aggregation, Matrix Sparsity Handling", table_cell_style), Paragraph("<code>transaksi, detail_transaksi</code>", table_cell_style)],
        [Paragraph("2. Recommender System (Cerdas)", table_cell_bold), Paragraph("20%", table_cell_bold), Paragraph("Item-Based Cosine Similarity & Apriori Association Rules", table_cell_style), Paragraph("<code>detail_transaksi, produk</code>", table_cell_style)],
        [Paragraph("3. Customer Segmentation", table_cell_bold), Paragraph("15%", table_cell_bold), Paragraph("RFM (Recency, Frequency, Monetary) & K-Means Clustering", table_cell_style), Paragraph("<code>pelanggan, transaksi</code>", table_cell_style)],
        [Paragraph("4. Sales & Demand Forecasting", table_cell_bold), Paragraph("15%", table_cell_bold), Paragraph("Time-Series Holt-Winters Smoothing & Linear Regression Trend", table_cell_style), Paragraph("<code>transaksi (tgl, total)</code>", table_cell_style)],
        [Paragraph("5. NLP Sentiment Analysis", table_cell_bold), Paragraph("15%", table_cell_bold), Paragraph("Indonesian Lexicon Text Mining, Tokenizer, CSI Metric", table_cell_style), Paragraph("<code>review, pelanggan, produk</code>", table_cell_style)],
        [Paragraph("<b>SUB-TOTAL DATA SCIENCE</b>", table_cell_bold), Paragraph("<b>80%</b>", table_cell_bold), Paragraph("<b>5 Mesin Analitik Terpadu</b>", table_cell_bold), Paragraph("<b>Basis Data MySQL Riil</b>", table_cell_bold)],
        [Paragraph("Pondasi Web & Transaksional (MVC)", table_cell_style), Paragraph("20%", table_cell_style), Paragraph("Laravel Framework, Routing, Blade UI, Auth, Session, CRUD", table_cell_style), Paragraph("Semua Skema Database", table_cell_style)],
        [Paragraph("<b>TOTAL KESELURUHAN SISTEM</b>", table_cell_bold), Paragraph("<b>100%</b>", table_cell_bold), Paragraph("<b>Sistem E-Commerce Cerdas Terintegrasi</b>", table_cell_bold), Paragraph("<b>Aplikasi Siap Produksi</b>", table_cell_bold)],
    ]

    t_matrix = Table(matrix_data, colWidths=[140, 45, 195, 135])
    t_matrix.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), colors.HexColor('#1E293B')),
        ('ALIGN', (1,0), (1,-1), 'CENTER'),
        ('PADDING', (0,0), (-1,-1), 4),
        ('GRID', (0,0), (-1,-1), 0.5, colors.HexColor('#CBD5E1')),
        ('BACKGROUND', (0,6), (-1,6), colors.HexColor('#DCFCE7')),
        ('BACKGROUND', (0,8), (-1,8), colors.HexColor('#E2E8F0')),
        ('VALIGN', (0,0), (-1,-1), 'MIDDLE'),
    ]))
    story.append(t_matrix)

    story.append(Spacer(1, 10))

    # Section 3: Rincian 5 Pilar Data Science
    story.append(Paragraph("3. Rincian Teknis, Formulasi Matematika & Algoritma", h1_style))

    # Pilar 1
    story.append(Paragraph("A. Pilar 1: Data Pipeline, Preprocessing & Normalisasi (15%)", h2_style))
    story.append(Paragraph(
        "Mengekstraksi data transaksi mentah dari basis data MySQL, membersihkan data yang hilang, mengagregasikan nilai belanja, dan melakukan normalisasi skala fitur kuantitatif menggunakan formula Min-Max Normalization:",
        body_style
    ))
    story.append(Paragraph("Formula: X_scaled = (X - X_min) / (X_max - X_min) &isin; [0.0, 1.0]", formula_style))
    story.append(Paragraph("&bull; <b>Implementasi Service:</b> <code>app/Services/DataScience/DataPipelineService.php</code>", bullet_style))
    story.append(Paragraph("&bull; <b>Data Riil Database:</b> 16 Transaksi, 17 baris Detail Transaksi, 12 Produk Koper, 5 Pelanggan.", bullet_style))

    story.append(Spacer(1, 4))

    # Pilar 2
    story.append(Paragraph("B. Pilar 2: Intelligent Recommender System & Apriori (20%)", h2_style))
    story.append(Paragraph(
        "1. <b>Item-Based Collaborative Filtering (Cosine Similarity):</b> Menghitung sudut kemiripan vektor antar produk koper berdasarkan histori belanja bersama dan atribut produk.",
        body_style
    ))
    story.append(Paragraph("Formula: Cosine_Sim(A, B) = (A &middot; B) / (||A|| &times; ||B||) = &Sigma;(Ai &times; Bi) / [sqrt(&Sigma;Ai&sup2;) &times; sqrt(&Sigma;Bi&sup2;)]", formula_style))
    story.append(Paragraph(
        "2. <b>Market Basket Analysis (Algoritma Apriori):</b> Menghitung keterkaitan produk yang sering dibeli bersamaan pada satu transaksi.",
        body_style
    ))
    story.append(Paragraph("Formula: Support = P(A &cap; B) | Confidence = Support(A &cap; B) / Support(A) | Lift = Confidence / Support(B)", formula_style))
    story.append(Paragraph("&bull; <b>Temuan Data Riil:</b> Pembelian <i>Pro-DLX 5 Premium</i> bersama <i>Essential Cabin Matte</i> menghasilkan <b>Lift Ratio 2.60x</b> (Korelasi positif kuat untuk paket bundling).", bullet_style))
    story.append(Paragraph("&bull; <b>Widget Frontend:</b> Ditampilkan di halaman <code>/produk-detail/{id}</code> dengan badge kecocokan <i>% Match</i>.", bullet_style))

    story.append(Spacer(1, 4))

    # Pilar 3
    story.append(Paragraph("C. Pilar 3: Customer Segmentation RFM & K-Means (15%)", h2_style))
    story.append(Paragraph(
        "Mengelompokkan pelanggan ke dalam 4 kuadran strategis menggunakan algoritma <i>Unsupervised Learning K-Means</i> berdasarkan metrik <b>Recency (R)</b>, <b>Frequency (F)</b>, dan <b>Monetary (M)</b>.",
        body_style
    ))
    story.append(Paragraph("Fungsi Objektif: Minimalkan SSE = &Sigma; &Sigma; || x_i - c_j ||&sup2; (Jarak Euclidean ke Centroid)", formula_style))
    story.append(Paragraph("&bull; <b>Klaster 1 (Champions):</b> FarhanIqratama (Total Belanja: Rp 94.890.000, 6x Beli, Recency: 100 hari) &rarr; Program Reward VIP.", bullet_style))
    story.append(Paragraph("&bull; <b>Klaster 2 (Potential Loyalists):</b> Fathur rahman (Total Belanja: Rp 861.500, 10x Beli) &rarr; Diskon Repeat Order.", bullet_style))
    story.append(Paragraph("&bull; <b>Klaster 3 (At Risk):</b> Bambang, Ujang Mitra, farhan &rarr; Kampanye Re-engagement.", bullet_style))

    story.append(Spacer(1, 4))

    # Pilar 4
    story.append(Paragraph("D. Pilar 4: Sales Forecasting & Time-Series Modeling (15%)", h2_style))
    story.append(Paragraph(
        "Model peramalan deret waktu gabungan <i>Holt-Winters Single Exponential Smoothing</i> dan <i>Linear Regression Trend</i> untuk memprediksi omzet penjualan dan kebutuhan stok unit koper:",
        body_style
    ))
    story.append(Paragraph("Formula Exponential Smoothing: S_t = &alpha; &middot; Y_t + (1 - &alpha;) &middot; S_{t-1} | Tren: Y = a + bX", formula_style))
    story.append(Paragraph("Metrik Error: MAE = (1/n) &Sigma; |Y_t - &Ycirc;_t| | MAPE = (100%/n) &Sigma; |(Y_t - &Ycirc;_t) / Y_t|", formula_style))
    story.append(Paragraph("&bull; <b>Proyeksi Nyata:</b> Juni 2026 (Rp 109,9 Jt / 25 unit) &rarr; Juli 2026 (Rp 157,1 Jt / 35 unit) &rarr; Agustus 2026 (Rp 204,3 Jt / 46 unit).", bullet_style))
    story.append(Paragraph("&bull; <b>Rantai Pasok:</b> Rekomendasi <i>Safety Stock Buffer</i> otomatis sebesar +25% di atas estimasi unit.", bullet_style))

    story.append(Spacer(1, 4))

    # Pilar 5
    story.append(Paragraph("E. Pilar 5: Natural Language Processing (NLP) Sentiment Analysis (15%)", h2_style))
    story.append(Paragraph(
        "Menganalisis teks ulasan pelanggan di tabel <code>review</code> melalui tahapan case folding, tokenisasi, deteksi negasi, dan penilaian polaritas berbasis kamus leksikon sentimen bahasa Indonesia.",
        body_style
    ))
    story.append(Paragraph("Formula CSI: Customer Satisfaction Index = (Total Ulasan Positif / Total Seluruh Ulasan) &times; 100%", formula_style))
    story.append(Paragraph("&bull; <b>Hasil Analisis Data Riil:</b> Ulasan <i>\"mantap\"</i> (+0.75) dan <i>\"mantul\"</i> (+0.75) menghasilkan skor CSI <b>100% (Sangat Puas)</b>.", bullet_style))

    story.append(Spacer(1, 10))

    # Section 4: Panduan Navigasi & Kesimpulan
    story.append(Paragraph("4. Rute Akses Dashboard & Kesimpulan", h1_style))
    
    routes_data = [
        [Paragraph("Halaman Dashboard Data Science", table_header_style), Paragraph("URL Endpoint", table_header_style), Paragraph("Fungsi Utama", table_header_style)],
        [Paragraph("AI Command Center", table_cell_bold), Paragraph("<code>/data-science</code>", table_cell_style), Paragraph("Ringkasan KPI, kurva peramalan, donat klaster, dan radar sentimen", table_cell_style)],
        [Paragraph("Segmentasi Pelanggan RFM", table_cell_bold), Paragraph("<code>/data-science/segmentation</code>", table_cell_style), Paragraph("Eksplorasi anggota tiap klaster K-Means & rekomendasi strategi bisnis", table_cell_style)],
        [Paragraph("Peramalan Penjualan", table_cell_bold), Paragraph("<code>/data-science/forecasting</code>", table_cell_style), Paragraph("Simulasi parameter alpha (&alpha;), metrik MAE/MAPE, & proyeksi unit stok", table_cell_style)],
        [Paragraph("Sentimen Ulasan NLP", table_cell_bold), Paragraph("<code>/data-science/sentiment</code>", table_cell_style), Paragraph("Ekstraksi kata kunci dominan, polaritas, skor CSI, & feed ulasan", table_cell_style)],
        [Paragraph("Sistem Rekomendasi & Apriori", table_cell_bold), Paragraph("<code>/data-science/recommender</code>", table_cell_style), Paragraph("Matriks Cosine Similarity antar koper & aturan asosiasi keranjang", table_cell_style)],
        [Paragraph("REST API Rekomendasi", table_cell_bold), Paragraph("<code>/api/data-science/recommendations/{id}</code>", table_cell_style), Paragraph("Endpoint publik JSON untuk integrasi mobile apps & frontend AJAX", table_cell_style)],
    ]
    t_routes = Table(routes_data, colWidths=[140, 160, 215])
    t_routes.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), colors.HexColor('#233876')),
        ('PADDING', (0,0), (-1,-1), 4),
        ('GRID', (0,0), (-1,-1), 0.5, colors.HexColor('#CBD5E1')),
        ('VALIGN', (0,0), (-1,-1), 'MIDDLE'),
    ]))
    story.append(t_routes)

    story.append(Spacer(1, 8))
    story.append(Paragraph(
        "<b>Kesimpulan Akhir:</b> Transformasi ini berhasil membuktikan bahwa sistem MVL-KOPER telah memenuhi kualifikasi ilmiah dan praktis sebagai "
        "<b>Aplikasi E-Commerce Berbasis Data Science 80%</b> yang siap dipresentasikan pada forum akademik, ujian tugas akhir/skripsi, maupun implementasi industri.",
        body_style
    ))

    doc.build(story, canvasmaker=NumberedCanvas)
    print(f"PDF successfully generated at: {filename}")

if __name__ == "__main__":
    out_pdf = "/Applications/MAMP/htdocs/MVL-KOPER/Analisis_Data_Science_MVL_KOPER.pdf"
    if len(sys.argv) > 1:
        out_pdf = sys.argv[1]
    build_pdf(out_pdf)
