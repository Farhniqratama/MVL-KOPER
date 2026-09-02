<style>
	/* Set the same font size for both icons */
	.mobile-menu-toggler i,
	.cart-toggle i {
		font-size: 24px;
		line-height: 1;
		vertical-align: middle;
	}

	/* Ensure both icons are positioned consistently */
	.mobile-menu-toggler,
	.cart-dropdown {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 40px;
		height: 40px;
	}

	/* Hide hamburger menu (fa-bars) by default (for larger screens) */
	.mobile-menu-toggler {
		display: none;
	}

	/* Show hamburger menu only on mobile screens (max-width: 991px) */
	@media (max-width: 991px) {
		.mobile-menu-toggler {
			display: flex !important;
			align-items: center;
			justify-content: center;
		}

		.main-nav {
			display: none !important;
			/* Hide navigation menu on mobile */
		}
	}

	/* Ensure desktop menu is only visible on large screens */
	@media (min-width: 992px) {
		.header-dropdowns {
			display: flex !important;
		}
	}

	.cart-toggle {
		margin-left: 15px;
	}

	/* Ensure the cart count badge is properly positioned */
	.cart-count {
		position: absolute;
		top: -5px;
		right: -5px;
		font-size: 12px;
		width: 16px;
		height: 16px;
		display: flex;
		align-items: center;
		justify-content: center;
		background-color: red;
		color: white;
		border-radius: 50%;
	}

	/* Custom Flexbox Styling for Header */
	.header-middle {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 10px 20px;
	}

	.logo-container {
		display: flex;
		align-items: center;
		white-space: nowrap;
		margin-top: 5px;
		/* Moves the logo slightly downward */
	}

	.main-nav {
		display: flex;
		align-items: center;
		justify-content: center;
		flex-grow: 1;
		margin-left: 50px;
	}

	.menu {
		display: flex;
		gap: 15px;
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.menu li a {
		text-decoration: none;
		color: #333;
		font-weight: bold;
	}
</style>

<div class="header-middle sticky-header">
	<div class="container-fluid d-flex align-items-center justify-content-between">
		<!-- LOGO (Left) - Moved Slightly Down -->
		<div class="logo-container">
			<a href="{{ URL::to('/') }}" class="logo logo-transition">
				<h2 style="font-weight: 800; letter-spacing: 2px; margin: 0; color: #222;">MVL KOPER</h2>
			</a>
		</div>

		<!-- NAVIGATION (Hidden on Mobile) -->
		<nav class="main-nav">
			<ul class="menu ls-n-10">
				<li><a href="{{ URL::to('/') }}">Beranda</a></li>
				<li><a href="{{ URL::to('list-produk') }}">Produk</a></li>
				<li>
					<a href="#" class="sf-with-ul">Kategori</a>
					@php $dataCategories = getKategori(); @endphp
					<ul style="display: none;">
						@foreach ($dataCategories as $dc)
						<li><a href="{{ URL::to('produk-by-kategori/'.$dc->id) }}">{{ $dc->nama_kategori }}</a></li>
						@endforeach
					</ul>
				</li>
				@if(!empty(session('auth_user')))
				<li><a href="{{ URL::to('histori-transaksi') }}">Pesanan</a></li>
				@endif
			</ul>
		</nav>

		<!-- RIGHT SECTION (Cart & Login/Logout) -->
		<div class="header-right d-flex align-items-center">
			<!-- Mobile Menu Toggle Button -->
			<button class="mobile-menu-toggler" type="button">
				<i class="fas fa-bars"></i>
			</button>

			<!-- Profile & Authentication Links -->
			<div class="header-dropdowns d-none d-xl-flex">
				<div class="header-dropdown">
					@if(!empty(session('auth_user')))
					<a href="{{ URL::to('profil') }}" class="">PROFIL</a>
					<a href="{{ URL::to('logout-user') }}" class="">LOGOUT</a>
					@else
					<a href="{{ URL::to('login-user') }}" class="">MASUK</a>
					@endif
				</div>
			</div>

			<!-- Cart Section -->
			<div class="dropdown cart-dropdown">
				<a href="#" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false" data-display="static">
					<i class="icon-cart-thick"></i>
					@php
					$authUser = session('auth_user') ?? null;
					$pelangganId = $authUser && isset($authUser['pelanggan_id']) ? $authUser['pelanggan_id'] : null;
					$dataCartNya = $pelangganId ? getCart($pelangganId) ?? [] : [];
					$cartCount = is_array($dataCartNya) ? count($dataCartNya) : 0;
					@endphp

					<span class="cart-count badge-circle" @if($cartCount===0) style="display: none;" @endif>
						{{ $cartCount }}
					</span>
				</a>

				<div class="cart-overlay"></div>

				<div class="dropdown-menu mobile-cart">
					<a href="#" title="Close (Esc)" class="btn-close">×</a>

					<div class="dropdownmenu-wrapper custom-scrollbar">
						<div class="dropdown-cart-header">Keranjang</div>

						@if(!empty(session('auth_user')) && isset(session('auth_user')['pelanggan_id']))
						@php $dataCartNya = getCart(session('auth_user')['pelanggan_id']); @endphp
						@else
						@php $dataCartNya = []; @endphp
						@endif
						@php $total = 0; @endphp
						@foreach ($dataCartNya as $valCartNya)
						@php $total += $valCartNya->harga * $valCartNya->qty; @endphp
						<div class="dropdown-cart-products">
							<div class="product">
								<div class="product-details">
									<h4 class="product-title">
										<a href="{{ URL::to('produk-detail/'.$valCartNya->produk_id) }}">{{
											$valCartNya->nama_produk }}</a>
									</h4>

									<span class="cart-product-info">
										<span class="cart-product-qty">{{ $valCartNya->qty }}</span> × {{
										$valCartNya->harga }}
									</span>
								</div>

								<figure class="product-image-container">
									<a href="{{ URL::to('produk-detail/'.$valCartNya->produk_id) }}"
										class="product-image">
										<img src="{{ asset('upload/produk/'.$valCartNya->gambar) }}" alt="product"
											width="80" height="80">
									</a>

									<a href="{{ URL::to('delete-cart/'.$valCartNya->id) }}" class="btn-remove"
										title="Remove Product"><span>×</span></a>
								</figure>
							</div>
						</div>
						@endforeach

						<div class="dropdown-cart-total">
							<span>SUBTOTAL:</span>
							<span class="cart-total-price float-right">{{ number_format($total, 0, ',', '.') }}</span>
						</div>

						<div class="dropdown-cart-action">
							<a href="{{ URL::to('cart') }}" class="btn btn-gray btn-block view-cart">Lihat Keranjang</a>
							<a href="{{ URL::to('checkout') }}" class="btn btn-dark btn-block">Kasir</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>