
<!DOCTYPE html>
<html class="side-header">
	<head>
		
		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>Porto - Responsive HTML5 Template</title>	

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

	</head>
	<body data-plugin-page-transition>
		<div class="body">
			<header id="header" class="side-header d-flex">
				<div class="header-body">
					<div class="header-container container d-flex h-100">
						<div class="header-column flex-row flex-lg-column justify-content-center h-100">
							<div class="header-row flex-row justify-content-start justify-content-lg-center py-lg-5">
								<div class="header-logo">
									<a href="index.html">
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
								<ul class="header-social-icons social-icons d-none d-sm-block social-icons-clean d-sm-0">
									<li class="social-icons-facebook"><a href="https://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
									<li class="social-icons-twitter"><a href="https://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
									<li class="social-icons-linkedin"><a href="https://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
								</ul>
								<p class="d-none d-lg-block text-1 pt-3">© 2021 PORTO. All rights reserved</p>
								<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
									<i class="fas fa-bars"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div role="main" class="main">
				<div>Something...</div>
			</div>
 
			<footer id="footer" class="footer-texts-more-lighten">
				<div class="container">
					<div class="row py-4 my-5">
						<div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
							<h5 class="text-4 text-color-light mb-3">CONTACT INFO</h5>
							<ul class="list list-unstyled">
								<li class="pb-1 mb-2">
									<span class="d-block font-weight-normal line-height-1 text-color-light">ADDRESS</span> 
									1234 Street Name, City, State, USA
								</li>
								<li class="pb-1 mb-2">
									<span class="d-block font-weight-normal line-height-1 text-color-light">PHONE</span>
									<a href="tel:+1234567890">Toll Free (123) 456-7890</a>
								</li>
								<li class="pb-1 mb-2">
									<span class="d-block font-weight-normal line-height-1 text-color-light">EMAIL</span>
									<a href="/cdn-cgi/l/email-protection#610c00080d210419000c110d044f020e0c"><span class="__cf_email__" data-cfemail="abc6cac2c7ebced3cac6dbc7ce85c8c4c6">[email&#160;protected]</span></a>
								</li>
								<li class="pb-1 mb-2">
									<span class="d-block font-weight-normal line-height-1 text-color-light">WORKING DAYS/HOURS </span>
									Mon - Sun / 9:00AM - 8:00PM
								</li>
							</ul>
							<ul class="social-icons social-icons-clean-with-border social-icons-medium">
								<li class="social-icons-instagram">
									<a href="https://www.instagram.com/" class="no-footer-css" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
								</li>
								<li class="social-icons-twitter mx-2">
									<a href="https://www.twitter.com/" class="no-footer-css" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
								</li>
								<li class="social-icons-facebook">
									<a href="https://www.facebook.com/" class="no-footer-css" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
								</li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-2 mb-5 mb-lg-0">
							<h5 class="text-4 text-color-light mb-3">USEFUL LINKS</h5>
							<ul class="list list-unstyled mb-0">
								<li class="mb-0"><a href="contact-us-1.html">Help Center</a></li>
								<li class="mb-0"><a href="about-us.html">About Us</a></li>
								<li class="mb-0"><a href="contact-us.html">Contact Us</a></li>
								<li class="mb-0"><a href="page-careers.html">Careers</a></li>
								<li class="mb-0"><a href="blog-grid-4-columns.html">Blog</a></li>
								<li class="mb-0"><a href="#">Our Location</a></li>
								<li class="mb-0"><a href="#">Privacy Policy</a></li>
								<li class="mb-0"><a href="sitemap.html">Sitemap</a></li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-4 mb-5 mb-md-0">
							<h5 class="text-4 text-color-light mb-3">RECENT NEWS</h5>
							<article class="mb-3">
								<a href="blog-post.html" class="text-color-light text-3-5">Why should I buy a Web Template?</a>
								<p class="line-height-2 mb-0"><a href="#">Nov 25, 2020</a> in <a href="#">Design,</a> <a href="#">Coding</a></p>
							</article>
							<article class="mb-3">
								<a href="blog-post.html" class="text-color-light text-3-5">Creating Amazing Website with Porto</a>
								<p class="line-height-2 mb-0"><a href="#">Nov 25, 2020</a> in <a href="#">Design,</a> <a href="#">Coding</a></p>
							</article>
							<article>
								<a href="blog-post.html" class="text-color-light text-3-5">Best Practices for Top UI Design</a>
								<p class="line-height-2 mb-0"><a href="#">Nov 25, 2020</a> in <a href="#">Design,</a> <a href="#">Coding</a></p>
							</article>
						</div>
						<div class="col-md-6 col-lg-3">
							<h5 class="text-4 text-color-light mb-3">SUBSCRIBE NEWSLETTER</h5>
							<p class="mb-2">Get all the latest information on events, sales and offers. Sign up for newsletter:</p>
							<div class="alert alert-success d-none" id="newsletterSuccess">
								<strong>Success!</strong> You've been added to our email list.
							</div>
							<div class="alert alert-danger d-none" id="newsletterError"></div>
							<form id="newsletterForm" class="form-style-5 opacity-10" action="php/newsletter-subscribe.php" method="POST">
								<div class="row">
									<div class="form-group col">
										<input class="form-control" placeholder="Email Address" name="newsletterEmail" id="newsletterEmail" type="text" />
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<button class="btn btn-primary btn-rounded btn-px-4 btn-py-2 font-weight-bold" type="submit">SUBSCRIBE</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="footer-copyright footer-copyright-style-2 pt-4 pb-5">
						<div class="row">
							<div class="col-12 text-center">
								<p class="mb-0">Porto Template © 2021. All Rights Reserved</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
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
</body>
</html>