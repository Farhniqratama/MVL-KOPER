<div class="footer-modern text-white pt-5 pb-1" style="background-color: #050505; color: #ccc;">
	<div class="container mt-4">
		<div class="row">
            <!-- Brand / Newsletter -->
			<div class="col-lg-4 col-sm-12 mb-5 pr-md-5">
				<h2 class="widget-title text-white text-uppercase mb-4" style="font-weight: 800; font-size: 24px; letter-spacing: 2px;">Rendy Koper</h2>
				<p class="mb-4 text-muted" style="line-height: 1.8; font-size: 14px;">Dapatkan akses eksklusif untuk koleksi koper terbaru, tips bepergian, dan penawaran spesial langsung di kotak masuk Anda.</p>
                <form action="#" class="mb-4 d-flex" style="height: 48px;">
                    <input type="email" class="form-control bg-transparent text-white h-100" placeholder="Alamat Email Anda" style="border-radius: 0; border: 1px solid #333; padding: 0 15px; font-size: 13px; margin: 0; outline: none; border-right: none;">
                    <button type="submit" class="btn btn-light h-100 d-flex align-items-center justify-content-center" style="border-radius: 0; font-weight: bold; padding: 0 25px; letter-spacing: 1px; margin: 0; border: none;">DAFTAR</button>
                </form>
			</div>

			<!-- Quick Links -->
			<div class="col-lg-2 col-sm-6 mb-5 offset-lg-1">
				<h4 class="widget-title text-white text-uppercase mb-4" style="font-size: 13px; letter-spacing: 1px;">Layanan Pelanggan</h4>
				<ul class="links list-unstyled" style="font-size: 14px; line-height: 2.2;">
					<li><a href="{{ url('tentang-kami') }}" class="text-decoration-none">Tentang Kami</a></li>
					<li><a href="{{ url('hubungi-kami') }}" class="text-decoration-none">Hubungi Kami</a></li>
					<li><a href="{{ url('garansi') }}" class="text-decoration-none">Garansi 10 Tahun</a></li>
					<li><a href="{{ url('kebijakan-pengembalian') }}" class="text-decoration-none">Kebijakan Pengembalian</a></li>
					<li><a href="{{ url('faq') }}" class="text-decoration-none">FAQ</a></li>
				</ul>
			</div>

			<!-- My Account Section -->
			<div class="col-lg-2 col-sm-6 mb-5">
				<h4 class="widget-title text-white text-uppercase mb-4" style="font-size: 13px; letter-spacing: 1px;">Akun Saya</h4>
				<ul class="links list-unstyled" style="font-size: 14px; line-height: 2.2;">
					@if(!empty(session('auth_user')))
					<li><a href="{{ URL::to('profil') }}" class="text-decoration-none">Profil Saya</a></li>
					<li><a href="{{ url('histori-transaksi') }}" class="text-decoration-none">Riwayat Pesanan</a></li>
					<li><a href="{{ url('lacak-pengiriman') }}" class="text-decoration-none">Lacak Pengiriman</a></li>
					<li><a href="{{ URL::to('logout-user') }}" class="text-decoration-none">Keluar</a></li>
					@else
					<li><a href="{{ URL::to('login-user') }}" class="text-decoration-none">Masuk / Daftar</a></li>
					<li><a href="{{ url('keuntungan-member') }}" class="text-decoration-none">Keuntungan Member</a></li>
					@endif
				</ul>
			</div>

			<!-- Contact / Social -->
			<div class="col-lg-3 col-sm-12 mb-5">
				<h4 class="widget-title text-white text-uppercase mb-4" style="font-size: 13px; letter-spacing: 1px;">Terhubung</h4>
                <ul class="contact-info list-unstyled mb-4" style="font-size: 14px; line-height: 1.8;">
                    <li class="mb-3 d-flex"><i class="fas fa-map-marker-alt mt-1 mr-3 text-muted"></i> <span class="text-muted">Jakarta, Indonesia<br>Eksklusif Online 2026</span></li>
                    <li class="mb-3 d-flex"><i class="fas fa-phone-alt mt-1 mr-3 text-muted"></i> <a href="tel:+6287716816892" class="text-decoration-none text-muted">0877-1681-6892</a></li>
                    <li class="mb-3 d-flex"><i class="fas fa-envelope mt-1 mr-3 text-muted"></i> <a href="mailto:info@rendykoper.com" class="text-decoration-none text-muted">info@rendykoper.com</a></li>
                </ul>
				<div class="social-icons d-flex align-items-center mt-4">
					<a href="https://instagram.com" class="social-icon text-white mr-2" target="_blank"><i class="fab fa-instagram"></i></a>
					<a href="https://www.tiktok.com" class="social-icon text-white mr-2" target="_blank"><i class="fab fa-tiktok"></i></a>
					<a href="https://wa.me/6287716816892" class="social-icon text-white mr-2" target="_blank"><i class="fab fa-whatsapp"></i></a>
				</div>
			</div>
		</div>

		<!-- Footer Bottom -->
		<div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 pb-4 mt-3" style="border-top: 1px solid #1a1a1a;">
			<span class="footer-copyright text-muted" style="font-size: 12px; letter-spacing: 0.5px;">© 2026 Rendy Koper. All Rights Reserved.</span>
            <div class="payment-icons mt-3 mt-md-0">
                <i class="fab fa-cc-visa fa-2x text-muted mr-2" style="opacity: 0.5;"></i>
                <i class="fab fa-cc-mastercard fa-2x text-muted mr-2" style="opacity: 0.5;"></i>
                <i class="fab fa-cc-paypal fa-2x text-muted" style="opacity: 0.5;"></i>
            </div>
		</div>
	</div>
</div>

<style>
    .footer-modern {
        font-family: 'Open Sans', sans-serif;
    }
    .footer-modern .links a {
        color: #888;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .footer-modern .links a:hover {
        color: #fff;
        transform: translateX(5px);
    }
    .footer-modern .form-control:focus {
        border-color: #fff !important;
        box-shadow: none;
        color: #fff;
    }
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #1a1a1a;
        transition: all 0.3s ease !important;
        font-size: 18px;
    }
    .social-icon:hover {
        background: #fff;
        color: #000 !important;
        transform: translateY(-5px);
    }
    .footer-modern .contact-info a:hover {
        color: #fff !important;
    }
</style>