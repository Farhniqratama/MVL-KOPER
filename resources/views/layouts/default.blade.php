<!DOCTYPE html>

<html lang="en" class="light-style layout-compact layout-navbar-fixed layout-menu-fixed     " dir="ltr" data-theme="theme-default" data-assets-path="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/" data-base-url="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo-1" data-framework="laravel" data-template="vertical-menu-theme-default-light">

	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
	  	<meta charset="utf-8" />
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	  	<title>@yield('title')</title>
	  	<meta name="description" content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
	  	<meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
	  	<!-- laravel CRUD token -->
	  	<meta name="csrf-token" content="MYGKgtXso8bPbF1SgZ3fYRD2FCsbt819LvDCES9p">
	  	<!-- Canonical SEO -->
	  	<link rel="canonical" href="https://themeselection.com/item/sneat-bootstrap-laravel-admin-template/">
	  	<!-- Favicon -->
	  	<link rel="icon" type="image/x-icon" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/favicon/favicon.ico" />

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com/">
		<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300&display=swap" rel="stylesheet">

		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/fonts/boxiconsc4a7.css?id=87122b3a3900320673311cebdeb618da" />
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/fonts/fontawesome8a69.css?id=a2997cb6a1c98cc3c85f4c99cdea95b5" />
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/fonts/flag-icons80a8.css?id=121bcc3078c6c2f608037fb9ca8bce8d" />
		<!-- Core CSS -->
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/css/rtl/corea8ac.css?id=55b2a9dfaa009c41df62ca8d16e913a8" class="template-customizer-core-css" />
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/css/rtl/theme-default4c4b.css?id=9182924a7b965439eca5e189ba43eba1" class="template-customizer-theme-css" />
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/css/demob77a.css?id=69dfc5e48fce5a4ff55ff7b593cdf93d" />
		<!-- Vendors CSS -->
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/libs/perfect-scrollbar/perfect-scrollbare482.css?id=73d641bb8db2475ecafc6c68461ed01b" />
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/libs/typeahead-js/typeahead05d2.css?id=de339ead5e9c9e36f12e46cbef7aaffd" />
		<!-- Vendor Styles -->
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
		<!-- Vendor Styles -->
		<link rel="stylesheet" href="{{ asset('demo-1') }}/demo/assets/vendor/libs/apex-charts/apex-charts.css">

		<script src="{{ asset('demo-1') }}/demo/assets/vendor/js/helpers.js"></script>
	  	<script src="{{ asset('demo-1') }}/demo/assets/vendor/js/template-customizer.js"></script>
	  	<script src="{{ asset('demo-1') }}/demo/assets/js/config.js"></script>

	  	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	  	<style type="text/css">
	  		body {
			    font-family: 'Inter';
			}
			.btn-primary{
                background-color: #233876 !important;
                border-color: #233876 !important;
                box-shadow: 0 0.125rem 0.25rem 0 rgb(35 56 118) !important;
            }
            .btn-primary:hover {
                background-color: #233876 !important;
                border-color: #233876 !important;
            }
            .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
                color: #233876 !important;
                font-weight: bold;
            }
            .form-label{
                color: #233876 !important;
                font-weight: bold;
            }
            p{
                color: #233876 !important;
            }
            span{
                color: #233876 !important;
            }
            .badge{
            	font-weight: bold;
            }
            .bg-menu-theme .menu-inner>.menu-item.active>.menu-link {
			    background-color: #ebf5ff!important;
			    color: #233876 !important;
			}

			.app-brand .layout-menu-toggle {
    			background-color: #233876;
    		}
    		.bg-menu-theme .menu-inner>.menu-item.active:before {
			    background: #233876;
			}
			.btn-danger{
				background-color: #C81E1E !important;
			}
			.btn-danger:hover {
			    background-color: #C81E1E !important;
			    border-color: #C81E1E !important;
			}
			.btn-success{
				background-color: #1ee0ac;
			}
			.btn-success:hover {
			    background-color: #1ee0ac !important;
			    border-color: #1ee0ac !important;
			}
			.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
			    color: white !important;
			    border: 1px solid rgb(0 0 0 / 0%) !important;
			    background: #233876 !important;
			    border-radius: 5px;
			}
			.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			    color: #233876 !important;
			    border: 1px solid #233876 !important;
			    background: transparent;
			    border-radius: 5px;
			}
			.dataTables_wrapper .dataTables_paginate .paginate_button:active {
			    outline: none;
			    background: #fff !important;
			    border-radius: 5px;
			}
			.form-control {
				border: 1px solid #233876;
				color: #233876;
			}
			.form-control:focus, .form-select:focus {
			    border-color: #233876!important;
			}
			.table{
				color: #233876 !important;
			}
			.form-control:focus, .form-select:focus {
			    border-color: #233876 !important;
			}
			.input-group:focus-within .form-control, .input-group:focus-within .input-group-text {
			    border-color: #233876!important;
			}
			.col-form-label, .form-label {
				text-transform: none !important;
			}
	  	</style>
	</head>

	<body style="background: #EBF5FF;">
	  	<!-- Layout Content -->
	  	<div class="layout-wrapper layout-content-navbar ">
	  		<div class="layout-container">
	        	<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	        		@include('layouts.partials.sidebars')
				</aside>
			    <!-- Layout page -->
			    <div class="layout-page">
	      			<!-- BEGIN: Navbar-->
	        		<!-- Navbar -->
					<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
	    				@include('layouts.partials.topNavbar')
				      	<!--  Brand demo (display only for navbar-full and hide on below xl) -->
	        		</nav>
	  				<!-- / Navbar -->
	      			<!-- Content wrapper -->
	      			<div class="content-wrapper">
	        			<!-- Content -->
	        			
	                  	<div class="container-xxl flex-grow-1 container-p-y">
				            @yield('content')
							<!--/ Footer-->
	          				<div class="content-backdrop fade"></div>
	        			</div>
	        			<!--/ Content wrapper -->
			      	</div>
			      	<!-- / Layout page -->
	    		</div>

	        	<!-- Overlay -->
			    <div class="layout-overlay layout-menu-toggle"></div>
			        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
			    <div class="drag-target"></div>
	  		</div>
	  	</div>
  		<!-- / Layout wrapper -->

		<script src="{{ asset('demo-1') }}/demo/assets/vendor/libs/jquery/jquery1e84.js?id=0f7eb1f3a93e3e19e8505fd8c175925a"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/vendor/libs/popper/popper0a73.js?id=baf82d96b7771efbcc05c3b77135d24c"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/vendor/js/bootstrapcfc4.js?id=4648227467e3fd3f4cf976cfb0e43aea"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar6188.js?id=44b8e955848dc0c56597c09f6aebf89a"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/vendor/libs/hammer/hammer2de0.js?id=0a520e103384b609e3c9eb3b732d1be8"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/vendor/libs/typeahead-js/typeahead60e7.js?id=f6bda588c16867a6cc4158cb4ed37ec6"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/vendor/js/menu2dc9.js?id=c6ce30ded4234d0c4ca0fb5f2a2990d8"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/vendor/libs/apex-charts/apexcharts.js"></script>
		<script src="{{ asset('demo-1') }}/demo/assets/js/maind63d.js?id=6bea3f2e092d5fe7327c226f3242f31b"></script>

		<script src="{{ asset('demo-1') }}/demo/assets/js/dashboards-analytics.js"></script>

		<script src="{{ asset('demo-1') }}/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
	<!-- END: Page JS-->
		<script type="text/javascript" src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGyRC7G8ubY0WxBq0WCtyYXP0-YQpFNt4&callback=initialize&libraries=places" async defer loading="lazy"></script>
		<script type="text/javascript">
			$(document).ready( function () {
			    $('#myTable').DataTable();
			} );
			$(document).ready( function () {
			    $('#myTable-1').DataTable();
			} );
			$(document).ready( function () {
			    $('#myTable-2').DataTable();
			} );
			$(document).ready( function () {
			    $('#myTable-3').DataTable();
			} );
			$(document).ready( function () {
			    $('#myTable-4').DataTable();
			} );
			$(document).ready( function () {
			    $('#myTable-5').DataTable();
			} );

		</script>
	</body>
</html>
