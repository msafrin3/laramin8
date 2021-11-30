
<!DOCTYPE html>
<html class="side-header">
	<head>
		
		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>LA8 - @yield('title')</title>	

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ url('') }}/porto/img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{ url('') }}/porto/img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ url('') }}/porto/css/theme.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/css/theme-elements.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/css/theme-blog.css">
		<link rel="stylesheet" href="{{ url('') }}/porto/css/theme-shop.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="{{ url('') }}/porto/vendor/circle-flip-slideshow/css/component.css">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="{{ url('') }}/porto/css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ url('') }}/porto/css/custom.css">

		<!-- Head Libs -->
		<script src="{{ url('') }}/porto/vendor/modernizr/modernizr.min.js"></script>


		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-SEP1T05Z5V"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-SEP1T05Z5V');
		</script>

		{{-- DataTable --}}
		<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="{{ url('') }}/plugins/dataTables/dataTables.checkboxes.css">
        <link rel="stylesheet" href="//cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css">

		<style>
			.table {
				color: unset !important;
			}
			.table tr {
				background: unset !important;
			}
			.table>:not(caption)>*>* {
				border-bottom-width: 1px !important;
			}
		</style>

	</head>
	{{-- <body class="loading-overlay-showing" data-loading-overlay data-plugin-options="{'hideDelay': 500, 'effect': 'cubes'}"> --}}
	<body>
		<div class="body">
			<header id="header" class="side-header d-flex">
				<div class="header-body">
					<div class="header-container container d-flex h-100">
						<div class="header-column flex-row flex-lg-column justify-content-center h-100">
							<div class="header-row flex-row justify-content-start justify-content-lg-center py-lg-5">
								<div class="header-logo">
									<a href="{{ url('admin') }}">
										{{-- <img alt="Porto" width="100" height="48" src="{{ url('') }}/porto/img/logo-default-slim.png"> --}}
										Laravel Admin 8
									</a>
								</div>
							</div>
							<div class="header-row header-row-side-header flex-row h-100 pb-lg-5">
								<div class="header-nav header-nav-links header-nav-links-side-header header-nav-links-vertical header-nav-links-vertical-dropdown align-self-start">
									<div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-effect-4 header-nav-main-sub-effect-1">
										<nav class="collapse">
											<ul class="nav nav-pills" id="mainNav">
												@include('layouts.sidebar')
											</ul>
										</nav>
									</div>
								</div>
							</div>
							<div class="header-row justify-content-end pb-lg-3">
								<button type="button" class="btn btn-block btn-primary" onclick="toggleTheme()"><i class="fa fa-moon"></i></button>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div role="main" class="main">
				@yield('content')
			</div>
		</div>

		{{-- <a class="style-switcher-open-loader" href="#" data-base-path="" data-skin-src="" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="right" title="Style Switcher"><i class="fas fa-cogs"></i><div class="style-switcher-tooltip"><strong>Style Switcher</strong><p>Check out different color options and styles.</p></div></a>
		
		<a class="envato-buy-redirect" href="https://themeforest.net/checkout/from_item/4106987?license=regular&support=bundle_6month&ref=Okler" target="_blank" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="right" title="Buy Porto"><i class="fas fa-shopping-cart"></i></a>
		<a class="demos-redirect" href="index.html#demos" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="right" title="Demos"><img src="img/icons/demos-redirect.png" class="img-fluid" /></a> --}}
		

		<!-- Vendor -->
		{{-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
        <script src="{{ url('') }}/porto/vendor/jquery/jquery.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/jquery.cookie/jquery.cookie.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/jquery.validation/jquery.validate.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/lazysizes/lazysizes.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/isotope/jquery.isotope.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/vide/jquery.vide.min.js"></script>
		<script src="{{ url('') }}/porto/vendor/vivus/vivus.min.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="{{ url('') }}/porto/js/theme.js"></script>

		<!-- Circle Flip Slideshow Script -->
		<script src="{{ url('') }}/porto/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
		<!-- Current Page Views -->
		<script src="{{ url('') }}/porto/js/views/view.home.js"></script>

		<!-- Theme Initialization Files -->
		<script src="{{ url('') }}/porto/js/theme.init.js"></script>

		<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v64f9daad31f64f81be21cbef6184a5e31634941392597" integrity="sha512-gV/bogrUTVP2N3IzTDKzgP0Js1gg4fbwtYB6ftgLbKQu/V8yH2+lrKCfKHelh4SO3DPzKj4/glTO+tNJGDnb0A==" data-cf-beacon='{"rayId":"6b05eb8d6aaa28a7","version":"2021.11.0","r":1,"token":"03fa3b9eb60b49789931c4694c153f9b","si":100}' crossorigin="anonymous"></script>

		<script>
			function toggleTheme() {
				$("html").toggleClass("dark");
			}

			function setTheme(theme) {
				$.ajax({
					url: "{{ url('setTheme') }}",
					type: "POST",
					data: "_token={{ csrf_token() }}&theme=" + theme,
					success: function(response) {
						console.log(response);
					},
					error: function(err) {
						console.log(err);
					}
				});
			}
		</script>

		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		{{-- DataTables --}}
		<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
        <script src="{{ url('') }}/plugins/dataTables/dataTables.checkboxes.min.js"></script>

		@yield('footerScripts')
</body>
</html>