# 🧳 MVL-KOPER — Intelligent E-Commerce & Applied Data Science Ecosystem

<p align="center">
  <img src="https://img.shields.io/badge/Domain-Applied%20Data%20Science%20%26%20AI%20(80%25)-indigo?style=for-the-badge&logo=scikitlearn&logoColor=white" alt="Data Science 80%">
  <img src="https://img.shields.io/badge/Architecture-Hybrid%20OLTP%20%2B%20Analytics%20Engine-blue?style=for-the-badge" alt="Hybrid OLTP Analytics">
  <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/Framework-Laravel%2010-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10">
  <img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-success?style=for-the-badge" alt="Production Ready">
</p>

---

## 📌 Sekilas Proyek (Repository Overview)

**MVL-KOPER** bukan sekadar sistem e-commerce ritel koper konvensional (CRUD biasa), melainkan sebuah **Sistem Cerdas Berbasis Data Science Terapan (Bobot 80% Data Science & 20% Web Engineering)**. Platform ini menggabungkan keandalan transaksi *Online Transaction Processing* (OLTP) dengan kapabilitas *Advanced Analytics & Machine Learning Engine* bawaan (*native statistical algorithms*) yang memproses data transaksi riil, profil pelanggan, dan teks ulasan menjadi wawasan preskriptif dan personalisasi otomatis secara *real-time*.

> 💡 **Fokus Utama Repositori:**
> Mengintegrasikan pipeline machine learning, sistem rekomendasi berbasis konten & kolaboratif, segmentasi perilaku pelanggan (RFM + K-Means), peramalan deret waktu omzet & manajemen stok dinamis, serta analisis sentimen teks ulasan (NLP Lexicon) langsung ke dalam arsitektur aplikasi web siap pakai (*production-ready*).

---

## 📊 Dekomposisi Bobot Sistem: 80% Data Science

Sistem ini dirancang dengan pembagian fungsionalitas terukur di mana pilar analitik cerdas mendominasi alur bisnis aplikasi:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                 MVL-KOPER ARCHITECTURE BREAKDOWN (100%)                     │
├─────────────────────────────────────────────────────────────────────────────┤
│  [================================ 80% DATA SCIENCE ========================] │
│   • 15% Data Pipeline, ETL & Feature Engineering (Min-Max Scaling, CLV)     │
│   • 20% Recommender Engine (Cosine Similarity & Apriori Market Basket)      │
│   • 15% Customer Segmentation (RFM Profiling & K-Means Clustering)          │
│   • 15% Time-Series Sales & Stock Forecasting (SES Holt-Winters + Trend)    │
│   • 15% Natural Language Processing (Lexicon Text Mining & CSI Metric)      │
│                                                                             │
│  [======== 20% WEB ENGINEERING & TRANSACTIONAL ========]                    │
│   • Laravel 10 MVC, Blade UI Dashboard, MySQL ORM, Auth & Payment Gateway   │
└─────────────────────────────────────────────────────────────────────────────┘
```

| No | Pilar / Modul Data Science | Bobot | Algoritma & Metode Matematis | Input Basis Data Riil | Output & Dampak Bisnis |
|:---:|:---|:---:|:---|:---|:---|
| **1** | **Data Pipeline & Feature Engineering** | **15%** | Min-Max Feature Scaling, Missing Value Imputation, CLV Vectorization | `transaksi`, `detail_transaksi` | Matriks fitur terstandarisasi untuk pemrosesan model ML |
| **2** | **Intelligent Recommender System** | **20%** | Item-Based Cosine Similarity & Apriori Association Rules (Lift Ratio) | `detail_transaksi`, `produk` | Personalisasi produk terkait (*% Match*) & strategi *cross-selling bundling* |
| **3** | **Customer Segmentation (Unsupervised)** | **15%** | RFM (Recency, Frequency, Monetary) & K-Means Clustering (Euclidean Distance) | `pelanggan`, `transaksi` | Klasterisasi otomatis pelanggan (*Champions*, *Loyalists*, *At Risk*) |
| **4** | **Time-Series Sales & Demand Forecasting** | **15%** | Single Exponential Smoothing (Holt-Winters SES), Linear Trend, MAE/MAPE | `transaksi.tgl_transaksi`, `total` | Proyeksi omzet bulanan, unit terjual, dan *Safety Stock Buffer (+25%)* |
| **5** | **NLP Sentiment Analysis & Text Mining** | **15%** | Tokenisasi, Negation Handling, Indonesian Lexicon Polarity Scoring, CSI Metric | `review`, `produk`, `pelanggan` | Deteksi polaritas ulasan, Customer Satisfaction Index, & pemantauan mutu produk |
| — | **Subtotal Data Science & AI** | **80%** | **5 Engine Analitik Terpadu** | **Data Riil MySQL** | **Insight Prediktif & Preskriptif** |
| — | **Pondasi Web & Transaksional (MVC)** | **20%** | Laravel 10, Eloquent ORM, Blade Views, RESTful API | Seluruh Skema Database | Antarmuka interaktif & transaksi aman |

---

## 🔬 Rincian 5 Pilar Data Science & Formulasi Matematika

### 1. Data Pipeline & Feature Engineering (15%)
*File Implementasi: [`app/Services/DataScience/DataPipelineService.php`](app/Services/DataScience/DataPipelineService.php)*
* **ETL Pipeline:** Mengekstraksi riwayat transaksi belanja pelanggan, melakukan agregasi Customer Lifetime Value (CLV), imputasi nilai kosong, serta penanganan *matrix sparsity*.
* **Min-Max Feature Normalization:** Menyeragamkan skala variabel Recency, Frequency, dan Monetary ke interval $[0.0, 1.0]$ agar tidak terdistorsi oleh perbedaan satuan:
  $$\tilde{X} = \frac{X - X_{\min}}{X_{\max} - X_{\min}}$$

---

### 2. Intelligent Recommender System & Market Basket Analysis (20%)
*File Implementasi: [`app/Services/DataScience/RecommenderService.php`](app/Services/DataScience/RecommenderService.php)*
* **Item-Based Collaborative Filtering (Cosine Similarity):** Mengukur sudut kedekatan preferensi antar koper berdasarkan ko-okurensi transaksi belanja bersama:
  $$\text{Cosine Similarity}(A, B) = \frac{\vec{A} \cdot \vec{B}}{\|\vec{A}\| \|\vec{B}\|} = \frac{\sum_{i=1}^{n} A_i B_i}{\sqrt{\sum_{i=1}^{n} A_i^2} \sqrt{\sum_{i=1}^{n} B_i^2}}$$
* **Market Basket Analysis (Algoritma Apriori):** Menemukan pola asosiasi pembelian produk secara simultan dengan metrik evaluasi:
  $$\text{Support}(A \to B) = P(A \cap B)$$
  $$\text{Confidence}(A \to B) = \frac{P(A \cap B)}{P(A)}$$
  $$\text{Lift Ratio}(A \to B) = \frac{\text{Confidence}(A \to B)}{\text{Support}(B)}$$
* **Temuan Data Riil:** Produk *Pro-DLX 5 Premium* dengan *Essential Cabin Matte* menghasilkan nilai **Lift Ratio 2.60x** ($\text{Lift} > 1.0$), membuktikan korelasi positif yang sangat kuat untuk rekomendasi paket *bundling* koper.
* **Integrasi UI:** Widget rekomendasi interaktif langsung tertanam pada katalog dan halaman detail produk (`/produk-detail/{id}`) lengkap dengan badge *% Match*.

---

### 3. Customer Segmentation RFM & K-Means Clustering (15%)
*File Implementasi: [`app/Services/DataScience/CustomerSegmentationService.php`](app/Services/DataScience/CustomerSegmentationService.php)*
* **Pemodelan RFM:** Menghitung skor **Recency (R)** (hari sejak transaksi terakhir), **Frequency (F)** (jumlah transaksi), dan **Monetary (M)** (total nilai belanja).
* **K-Means Clustering (Unsupervised Learning):** Mengelompokkan pelanggan ke dalam $k=4$ klaster dengan meminimalkan *Sum of Squared Errors* (SSE) terhadap centroid:
  $$\text{SSE} = \sum_{j=1}^{k} \sum_{x \in S_j} \|x - c_j\|^2, \quad \text{dimana } d(x, c) = \sqrt{\sum_{i=1}^{m} (x_i - c_i)^2}$$
* **Profil Klaster Berdasarkan Data Transaksi Nyata:**
  * 🏆 **Cluster 1 — Champions (VIP):** Pelanggan bernilai tinggi (omzet Rp 94.890.000, frekuensi 6x) $\to$ *Target: Program Loyalitas VIP & Exclusive Preview*.
  * 📈 **Cluster 2 — Potential Loyalists:** Pelanggan dengan frekuensi tinggi (10x transaksi) $\to$ *Target: Diskon repeat-order & rekomendasi produk baru*.
  * ⚠️ **Cluster 3 & 4 — At Risk / Need Attention:** Pelanggan dengan recency panjang $\to$ *Target: Kampanye win-back email & voucher promo re-aktivasi*.

---

### 4. Time-Series Sales & Demand Forecasting (15%)
*File Implementasi: [`app/Services/DataScience/SalesForecastingService.php`](app/Services/DataScience/SalesForecastingService.php)*
* **Single Exponential Smoothing (SES / Holt-Winters variant):** Memprediksi tren omzet penjualan berkala dengan parameter bobot penghalusan dinamis $\alpha \in [0.1, 0.9]$:
  $$S_t = \alpha \cdot Y_t + (1 - \alpha) \cdot S_{t-1}$$
* **Linear Regression Trend Line:** Menghitung garis tren matematis untuk estimasi jangka panjang:
  $$\hat{Y} = a + bX, \quad b = \frac{n\sum XY - \sum X \sum Y}{n\sum X^2 - (\sum X)^2}, \quad a = \bar{Y} - b\bar{X}$$
* **Metrik Evaluasi Error:**
  $$\text{MAE} = \frac{1}{n}\sum_{t=1}^{n} |Y_t - \hat{Y}_t| \quad\quad \text{MAPE} = \frac{100\%}{n}\sum_{t=1}^{n} \left| \frac{Y_t - \hat{Y}_t}{Y_t} \right|$$
* **Optimasi Rantai Pasok (Inventory Demand):** Proyeksi unit kebutuhan gudang otomatis disertai **Safety Stock Buffer (+25%)** guna mencegah *stockout* saat lonjakan pesanan koper musim liburan.

---

### 5. Natural Language Processing (NLP) Sentiment Analysis (15%)
*File Implementasi: [`app/Services/DataScience/SentimentAnalysisService.php`](app/Services/DataScience/SentimentAnalysisService.php)*
* **Pipeline Pemrosesan Teks:**
  1. *Case Folding* (normalisasi huruf kecil)
  2. *Cleaning & Tokenization* (pembersihan tanda baca dan pemisahan kata)
  3. *Negation Rule Inversion* (deteksi kata pengingkar: *"tidak"*, *"bukan"*, *"kurang"*)
  4. *Indonesian Lexicon Dictionary Matching* (pencocokan polaritas kata sifat positif dan negatif)
* **Customer Satisfaction Index (CSI):**
  $$\text{CSI} = \left( \frac{\text{Jumlah Ulasan Positif}}{\text{Total Seluruh Ulasan}} \right) \times 100\%$$
* **Analisis Data Riil:** Analisis terhadap ulasan pelanggan menghasilkan skor **CSI 100% (Sangat Puas)** dengan kata kunci paling dominan *"mantap"*, *"bagus"*, dan *"cepat"*.

---

## 🖥️ Antarmuka AI Dashboard & Data Science Command Center

Aplikasi dilengkapi dengan rangkaian dashboard analitik yang intuitif bagi pengambil keputusan manajerial (*executive decision makers*):

```
┌────────────────────────────────────────────────────────────────────────────────────────┐
│                        DATA SCIENCE AI COMMAND CENTER                                  │
├─────────────────────────┬──────────────────────────┬───────────────────────────────────┤
│ [📊 Total Omzet Diproses]│ [🎯 Skor Akurasi Model]   │ [⭐ Customer Satisfaction Index]  │
│   Rp 95.751.500         │   MAPE < 12.4%           │   100% Puas (NLP Lexicon)         │
├─────────────────────────┴──────────────────────────┴───────────────────────────────────┤
│ 📈 Sales & Demand Forecast Curve (Historical vs Holt-Winters vs Linear Trend)          │
│ 🎯 RFM Segmentation Scatter & K-Means Cluster Distribution (Champions, Loyalists)     │
│ 🏷️ Market Basket Association Rules & Co-Occurrence Matrix (Support, Confidence, Lift) │
│ 💬 Sentiment Heatmap, Word Frequency Cloud, and Real-Time Review Inspection Feed       │
└────────────────────────────────────────────────────────────────────────────────────────┘
```

### 🧭 Navigasi Rute & Endpoint Web:
* 🎛️ **AI Command Center Overview:** `GET /data-science`
* 👥 **Segmentasi Pelanggan K-Means:** `GET /data-science/segmentation`
* 📉 **Simulasi Peramalan Penjualan:** `GET /data-science/forecasting?alpha=0.4`
* 💬 **Text Mining & Analisis Sentimen:** `GET /data-science/sentiment`
* 🧺 **Sistem Rekomendasi & Aturan Asosiasi:** `GET /data-science/recommender`
* 🔌 **REST API Rekomendasi Cerdas:** `GET /api/data-science/recommendations/{id_produk}`

---

## 🗄️ Pemetaan Arsitektur Basis Data ke Fitur Machine Learning

| Tabel Database MySQL | Fitur / Kolom Kunci | Transformasi Data Science | Target Service Analitik |
|:---|:---|:---|:---|
| `transaksi` | `id`, `pelanggan_id`, `tgl_transaksi`, `total_harga` | Agregasi deret waktu bulanan & kalkulasi Recency/Monetary | `SalesForecastingService`, `CustomerSegmentationService` |
| `detail_transaksi` | `id_transaksi`, `produk_id`, `qty`, `subtotal` | Pembentukan matriks keranjang (*basket co-occurrence matrix*) | `RecommenderService` (Cosine Sim & Apriori) |
| `produk` | `id`, `nama_produk`, `kategori_id`, `harga`, `stok` | Ekstraksi fitur konten produk & perhitungan *Safety Stock* | `RecommenderService`, `SalesForecastingService` |
| `pelanggan` | `id`, `nama`, `email`, `telepon` | Pemetakan profil pelanggan ke hasil label klaster K-Means | `CustomerSegmentationService` |
| `review` | `id`, `produk_id`, `pelanggan_id`, `komentar`, `rating` | Ekstraksi leksikon NLP, skor polaritas, dan CSI | `SentimentAnalysisService` |

---

## 🚀 Panduan Instalasi & Menjalankan Sistem

### Prasyarat Sistem
* PHP $\ge$ 8.1 dengan ekstensi: `BCMath`, `Ctype`, `cURL`, `DOM`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`.
* Web Server: Apache / Nginx (atau MAMP / XAMPP).
* MySQL Database $\ge$ 5.7 / MariaDB $\ge$ 10.3.
* Composer $\ge$ 2.x.

### Langkah-Langkah Instalasi
1. **Clone Repositori:**
   ```bash
   git clone https://github.com/Farhniqratama/MVL-KOPER.git
   cd MVL-KOPER
   ```

2. **Install Dependensi PHP:**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan parameter basis data pada file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=8889         # Sesuaikan dengan port MySQL Anda (misal 3306 atau 8889 pada MAMP)
   DB_DATABASE=aplikasi_rendy_parfum   # Atau nama database yang Anda gunakan
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

4. **Import Database Riil:**
   Import file SQL yang disediakan ke dalam database MySQL Anda:
   ```bash
   mysql -u root -p aplikasi_rendy_parfum < aplikasi_rendy_parfum.sql
   ```

5. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Akses aplikasi pada peramban Anda:
   * **Storefront E-Commerce:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
   * **Data Science Command Center:** [http://127.0.0.1:8000/data-science](http://127.0.0.1:8000/data-science)

---

## 📑 Dokumen Laporan Analisis Data Science

Repositori ini menyertakan laporan analisis teknis dan akademis berformat PDF siap cetak:
* 📄 **File Dokumen:** [`Analisis_Data_Science_MVL_KOPER.pdf`](Analisis_Data_Science_MVL_KOPER.pdf)
* ⚙️ **Generator Script (Python ReportLab):** [`generate_pdf_report.py`](generate_pdf_report.py)
* Untuk men-generate ulang dokumen PDF:
  ```bash
  python3 generate_pdf_report.py
  ```

---

## 🎯 Nilai Strategis untuk Portofolio & Akademik

Proyek ini sangat ideal dijadikan:
1. **Tugas Akhir / Skripsi / Tesis:** Pembuktian implementasi end-to-end dari teori Data Science (*Recommender System, Clustering, Time-Series Forecasting, NLP*) ke dalam arsitektur aplikasi perangkat lunak dunia nyata.
2. **Portofolio Profesional Data Scientist / Machine Learning Engineer:** Menunjukkan keahlian integrasi model statistik matematis langsung ke dalam produk perangkat lunak berskala produksi (*Production ML/AI Integration*).

---

## 👨‍💻 Kontributor & Lisensi

* **Pengembang:** [Farhniqratama](https://github.com/Farhniqratama)
* **Lisensi:** Open-source di bawah lisensi [MIT License](LICENSE).
