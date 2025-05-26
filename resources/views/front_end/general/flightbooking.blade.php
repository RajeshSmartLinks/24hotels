<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="{{asset('frontEnd/images/favicon.png')}}" rel="icon" />
		<meta name="keywords" content="Travel, Flights, Hotels, Booking, Flight Reservations, Hotel Reservations, Travel Agency, Vacation, Holidays, Air Travel, Accommodation">
		<meta name="author" content="24Flights">
		<meta name="description" content="Book your flights and hotel accommodations with ease through our travel services. Explore exciting destinations and plan your perfect vacation.">
		<meta property="og:title" content="24Flights - Book Flights and Hotels">
		<meta property="og:description" content="Book your flights and hotel accommodations with ease through our travel services. Explore exciting destinations and plan your perfect vacation.">
		<meta property="og:type" content="website">

		<meta property="og:image" content="{{asset('frontEnd/flightBookPage/assets/images/common/og-image.jpg')}}">

		<link rel="stylesheet" href="{{asset('frontEnd/flightBookPage/assets/vendors/liquid-icon/lqd-essentials/lqd-essentials.min.css')}}">
		<link rel="stylesheet" href="{{asset('frontEnd/flightBookPage/assets/css/theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('frontEnd/flightBookPage/assets/css/utility.min.css')}}">
		<link rel="stylesheet" href="{{ asset('frontEnd/flightBookPage/assets/css/demo/start-hub-3.css') }}">

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&family=Rubik:wght@600&display=swap" rel="stylesheet">

		<title>24Flights - Flight Booking</title>
	</head>

	<body data-lqd-cc="true" data-mobile-nav-breakpoint="1199" data-mobile-nav-style="minimal" data-mobile-nav-scheme="gray" data-mobile-nav-trigger-alignment="right" data-mobile-header-scheme="light" data-mobile-logo-alignment="default" data-overlay-onmobile="false" data-disable-animations-onmobile="true">
		<div id="wrap" class="bg-white">

			<div class="lqd-sticky-placeholder hidden"></div>
			<header id="site-header" class="main-header" data-sticky-header="true" data-sticky-values-measured="false">
			<section class="lqd-section lqd-hide-onstuck bg-no-repeat bg-top-right bg-darkpurple transition-all pt-10 lg:hidden" style="background-image: url('{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/header-ball1.png') }}');">

					<div class="flex items-center justify-center">
						<div class="rounded-4 mr-20 ld-fancy-heading relative bg-pink-100">
							<p class="ld-fh-element relative text-black text-11 px-10 font-medium m-0">Limited Offer</p>
						</div>
						<div class="ld-fancy-heading relative">
							<p class="ld-fh-element relative text-13 font-medium leading-1em mr-10 mb-0 text-white-60">Sign up and receive best discount on checkout. </p>
						</div>
						<a href="{{ route('home')}}" class="btn-underlined border-thin text-13 font-medium leading-1em text-white">
							<span class="btn-txt" data-text="Join 24Flights">Book with 24Flights</span>
						</a>
					</div>
					<div class="bg-white mt-10 border-bottom border-black-10 rounded-25 rounded-bottom-0 transition-all">
						<div class="w-full flex justify-between items-center">
							<div class="w-50percent flex items-center justify-start p-10">
								<div class="lqd-fancy-menu lqd-custom-menu relative lqd-menu-td-none ml-30 link-13 transition-opacity link-black">
									<ul class="reset-ul inline-ul">
										<li class="mr-10 mb-10">
											<a href="{{ url('Privacy-Policy')}}" class="tracking-0/1 leading-16"><span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span> Privacy Policy </a>
										</li>
										<li>
											<a href="{{ url('contact-us')}}" class="tracking-0/1 leading-16"><span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span> Contact </a>
										</li>
									</ul>
								</div>
							</div>
							<div class="w-50percent flex items-center justify-end p-10">
								<div class="flex justify-end">
									<div class="flex gap-25 mr-30 text-center w-auto">
										<span class="grid-item flex">
											<a href="https://www.facebook.com/24Flights" target="_blank" class="rounded-10 bg-transparent icon leading-20 text-20 text-slate-300 transition-text hover:text-black" target="_blank">
												<span class="sr-only">Facebook-square</span>
												<svg class="text-slate-300 w-1em h-1em text-19" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
													<path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z" fill="currentColor" />
												</svg>
											</a>
										</span>
										<span class="grid-item flex">
										    <a href="https://www.instagram.com/24_flights/" target="_blank" class="rounded-10 bg-transparent icon leading-20 text-20 text-slate-300 transition-text hover:text-black" target="_blank">
										        <span class="sr-only">Instagram</span>
										        <svg class="text-slate-300 w-1em h-1em text-19" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
										            <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
										        </svg>
										    </a>
										</span>

										<!-- <span class="grid-item flex">
											<a href="#" class="rounded-10 bg-transparent icon leading-20 text-20 text-slate-300 transition-text hover:text-black" target="_blank">
												<span class="sr-only">Github</span>
												<svg class="text-slate-300 w-1em h-1em text-19" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 496 512">
													<path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z" fill="currentColor" />
												</svg>
											</a>
										</span> -->
									</div>
									<!-- <div class="ld-dropdown-menu flex relative mr-30 link-15 link-black" role="menubar">
										<span class="ld-module-trigger text-black" role="button" data-ld-toggle="true" data-bs-toggle="collapse" data-bs-target="#dropdown-language" aria-controls="dropdown-language" aria-expanded="false" data-toggle-options='{ "type":  "hoverFade"}'>
											<span class="text-13 ld-module-trigger-txt">🇺🇸 English <i class="lqd-icn-ess icon-ion-ios-arrow-down"></i></span>
										</span>
										<div class="link-16 ld-module-dropdown left collapse absolute" id="dropdown-language" aria-expanded="false" role="menuitem">
											<div class="ld-dropdown-menu-content">
												<ul>
													<li>
														<a href="#" target="_blank">Dutch</a>
													</li>
													<li>
														<a href="#" target="_blank">French</a>
													</li>
												</ul>
											</div>
										</div>
									</div> -->
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="lqd-section bg-white border-bottom border-black-10 transition-all px-20 lg:hidden">
					<div class="container-fluid p-0">
						<div class="flex flex-wrap justify-between link-medium">
							<div class="pl-15 py-25 module-logo flex navbar-brand-plain w-20percent">
								<a class="navbar-brand flex p-0 relative" href="{{ url('/')}}" rel="home">
									<span class="navbar-brand-inner post-rel">
										<img width="171" class="logo-default" src="{{asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/logo/Logo1.png')}}" alt="24Flights">
									</span>
								</a>
							</div>
							<div class="flex items-center justify-end w-80percent">
								<div class="module-primary-nav flex">
									<div class="navbar-collapse inline-flex p-0 lqd-submenu-default-style link-14 mr-110 link-medium" id="main-header-collapse" aria-expanded="false" role="navigation">
										<ul class="main-nav flex reset-ul inline-ul lqd-menu-counter-right lqd-menu-items-inline main-nav-hover-fade-inactive" data-submenu-options='{"toggleType": "fade", "handler": "mouse-in-out"}' data-localscroll="true" data-localscroll="true" data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
											<li class="menu-item-has-children">
												<a class="text-blue-600" href="#features">
													<span>Features</span>
													<!-- <span class="submenu-expander bg-transparent">
														<svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewbox="0 0 21 32" style="width: 1em; height: 1em;">
															<path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path>
														</svg>
													</span> -->
													<!-- <span class="link-icon inline-flex hide-if-empty right-icon">
														<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
													</span> -->
												</a>
											</li>
											<li>
												<a class="text-blue-600" href="#payments">How to Book<span class="link-badge text-badge">Try</span></a>
											</li>
											<!-- <li>
												<a class="text-blue-600" href="#solutions">Solutions<span class="link-icon inline-flex hide-if-empty right-icon">
														<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
													</span>
												</a>
											</li> -->
											<li>
												<a class="text-blue-600" href="#testimonials">Testimonials</a>
											</li>
											<li>
												<a class="text-blue-600" href="{{ url('/')}}">Book Now</a>
											</li>
										</ul>
									</div>
								</div>
								<a href="https://onelink.to/36p3q9" target="_blank" class="btn btn-solid btn-sm btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y btn-icon-right text-13 rounded-4 text-white bg-primary" data-localscroll="true">
									<span class="btn-txt" data-text="Download" data-split-text="true" data-split-options='{"type": "chars, words"}'>Get the App</span>
									<span class="btn-icon text-1/5em -rotate-45">
										<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-arrow-round-forward"></i>
									</span>
								</a>
							</div>
						</div>
					</div>
				</section>
				<section class="lqd-section lqd-stickybar-wrap lqd-stickybar-left pointer-events-none lg:hidden">
					<div class="w-full h-full static flex flex-grow-1 vertical-lr">
						<div class="w-full static flex flex-grow-1">
							<div class="w-full static flex flex-grow-1 flex-col p-10">
								<div class="w-full static flex items-center justify-center -rotate-180">
									<div class="w-auto">
										<a href="https://onelink.to/36p3q9" target="_blank" class="btn btn-underlined border-thin box-shadow-none pointer-events-auto horizontal-tb rotate-90 font-medium text-14 leading-1/6em text-black" data-lqd-interactive-color="true" data-localscroll="true">
											<span class="btn-txt" data-text="Download 24Flights App">Download Our App</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="lqd-section lqd-stickybar-wrap lqd-stickybar-right pointer-events-none lg:hidden">
					<div class="flex items-center justify-center w-full h-full flex-grow-1 vertical-lr -rotate-180">
						<div class="lqd-scrl-indc flex whitespace-nowrap lqd-scrl-indc-style-dot" data-lqd-scroll-indicator="true">
							<a class="pointer-events-auto text-black" href="#wrap" data-localscroll="true" data-lqd-interactive-color="true">
								<span class="lqd-scrl-indc-inner flex items-center text-inherit">
									<span class="lqd-scrl-indc-txt">scroll</span>
									<span class="lqd-scrl-indc-line w-1 h-60 relative text-inherit bg-black-30">
										<span class="lqd-scrl-indc-el absolute -top-5 -left-5 rounded-8 inline-block w-10 h-10 bg-current-color"></span>
									</span>
								</span>
							</a>
						</div>
					</div>
				</section>
				<div class="lqd-mobile-sec relative xxl:hidden d-lg-flex">
					<div class="bg-white lqd-mobile-sec-inner navbar-header flex items-stretch w-full">
						<div class="lqd-mobile-modules-container empty"></div>
						<button type="button" class="navbar-toggle collapsed nav-trigger style-mobile flex relative items-center justify-end p-0 bg-transparent border-none text-13" data-ld-toggle="true" data-bs-toggle="collapse" data-bs-target="#lqd-mobile-sec-nav" aria-expanded="false" data-toggle-options='{ "changeClassnames":  {"html":  "mobile-nav-activated"} }'>
							<span class="sr-only">Menu</span>
							<span class="bars inline-block relative z-1">
								<span class="bars-inner flex flex-col w-full h-full">
									<span class="bar inline-block"></span>
									<span class="bar inline-block"></span>
									<span class="bar inline-block"></span>
								</span>
							</span>
						</button>
						<a class="navbar-brand flex relative" href="{{url('/')}}">
							<span class="navbar-brand-inner">
								<img width="171" class="logo-default" src="{{asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/logo/Logo1.png')}}" alt="24Flights">
							</span>
						</a>
					</div>
					<div class="lqd-mobile-sec-nav w-full absolute z-10">
						<div class="mobile-navbar-collapse navbar-collapse collapse w-full" id="lqd-mobile-sec-nav" aria-expanded="false" role="navigation">
							<ul id="mobile-primary-nav" class="reset-ul lqd-mobile-main-nav main-nav nav" data-localscroll="true" data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
								<li class="menu-item-has-children">
									<a href="#features">
										<span>Features</span>
										<span class="submenu-expander">
											<svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewbox="0 0 21 32" style="width: 1em; height: 1em;">
												<path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path>
											</svg>
										</span>
										<span class="link-icon inline-flex hide-if-empty right-icon">
											<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
										</span>
									</a>
								</li>
								<li>
									<a href="#payments">For Business<span class="link-badge text-badge">Hot</span></a>
								</li>
								<li>
									<a href="#solutions">Solutions<span class="link-icon inline-flex hide-if-empty right-icon">
											<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
										</span>
									</a>
								</li>
								<li>
									<a href="#testimonials">Testimonials</a>
								</li>
								<li>
									<a href="#faq">FAQ</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</header>

			<main class="content bg-white" id="lqd-site-content">
				<div id="qd-contents-wrap">

					<!-- Start Banner -->
					<section class="lqd-section banner pt-100" id="banner" style="background-image: linear-gradient(180deg, #fff 0%, #F1EAFF 100%);">
						<div class="background-overlay bg-no-repeat bg-cover opacity-100 transition-all" style="background-image: url('{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/banner/BG.png') }}');"></div>

						<div class="lqd-particles-bg-wrap lqd-overlay flex pointer-events-none"></div>
						<div class="ld-particles-container lqd-particles-as-bg lqd-overlay flex">
							<div class="ld-particles-inner lqd-overlay flex pointer-events-none" id="lqd-particle-banner" data-particles="true" data-particles-options='{"particles": {"number": {"value" : 4} , "color": {"value" : ["#FDA44C", "#604CFD", "#F85976", "#0FBBB4"]} , "shape": {"type" : ["circle"]} , "opacity": {"value" : 1} , "size": {"value" : 4}} , "interactivity" : [], "retina_detect": true}'></div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col col-12 col-xl-6 text-center xxl:text-start" data-custom-animations="true" data-ca-options='{"animationTarget": ".btn, h1, p", "ease": "power4.out", "initValues": {"y": "40px", "rotationY" : 53, "opacity" : 0} , "animations": {"y": "0px", "rotationY" : 0, "opacity" : 1}}'>
									<a href="https://youtu.be/yMhrHtQxQIk" class="btn btn-naked btn-icon-left btn-icon-circle btn-icon-custom-size btn-icon-bordered btn-icon-border-thicker text-15 leading-3em text-primary fresco">
										<span class="btn-txt" data-text="See how it works">See how you Book</span>
										<span class="btn-icon mr-10 w-45 h-45 border-2">
											<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-play"></i>
										</span>
									</a>
									<div class="spacer w-full">
										<div class="h-30"></div>
									</div>
									<div class="ld-fancy-heading relative">
										<h1 class="mb-25 ld-fh-element relative">
											<span>24Flights</span>
											<br>
											<span class="gradient-word" style="background-image: linear-gradient(to left, #E6A042, #FA6E30, #E7BABB, #AC99E3, #8296D6);">Flights&Hotels </span>
										</h1>
									</div>
									<div class="ld-fancy-heading relative">
										<p class="font-medium mb-25 pr-30percent ld-fh-element relative">Introducing our user-friendly online flight booking app – your ultimate travel companion-</p>
									</div>
									<div class="flex flex-wrap justify-start lg:justify-center">
										<a href="https://apps.apple.com/kw/app/24-flights/id1466042184" target="_blank" class="btn btn-solid btn-hover-txt-liquid-x btn-icon-left text-15 leading-1em text-white rounded-6 bg-gray-900 hover:bg-white hover:text-primary" data-localscroll="true">
											<span class="btn-txt text-start" data-text='Available on the Apple Store' data-split-text="true" data-split-options='{"type":  "chars, words"}'> <small>Available on the</small>
												<span>Apple Store</span>
											</span>
											<span class="btn-icon text-24">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
													<path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z" />
												</svg>
											</span>
										</a>
										<div style="margin: 3px;"></div>

										<a href="https://play.google.com/store/apps/details?id=com.ni.tfflights" target="_blank" class="btn btn-solid btn-hover-txt-liquid-x btn-icon-left text-15 leading-1em text-white rounded-6 bg-gray-900 hover:bg-white hover:text-primary" data-localscroll="true">
									    <span class="btn-txt text-start" data-text='Available on the Apple Store' data-split-text="true" data-split-options='{"type":  "chars, words"}'> <small>Available on the</small>
									        <span>Google Store</span>
									    </span>
									    <span class="btn-icon text-24">
									        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
									            <rect width="256" height="256" fill="none"></rect>
									            <path d="M223.6,114.2,55.9,18.1a16.2,16.2,0,0,0-16.2.1,15.8,15.8,0,0,0-7.9,13.7V224.1a16,16,0,0,0,16,15.9,16.9,16.9,0,0,0,8.1-2.1l167.7-96.1a15.7,15.7,0,0,0,0-27.6ZM144,139.3l18.9,18.9L74.7,208.6Zm-69.3-92,88.2,50.5L144,116.7ZM177.2,149.9,155.3,128l21.9-21.9L215.6,128Z" fill="currentColor"></path>
									        </svg>
									    </span>
									</a>

									<style>
									    .btn:hover .btn-icon svg path {
									        fill: black;
									    }
									</style>


										<!-- <a href="#contact-modal" class="btn btn-naked btn-icon-right btn-hover-swp ml-30 text-14 text-slate-400" data-lity="#contact-modal">
											<span class="btn-txt" data-text="Sign up — It's Free">Sign up — It's Free</span>
											<span class="btn-icon">
												<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
											</span>
											<span class="btn-icon">
												<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
											</span>
										</a> -->
									</div>
								</div>
								<div class="col col-12 col-xl-6 sm:hidden">
									<div class="relative flex w-full h-full transition-bg justify-start lg:justify-center module-img">
										<div class="relative w-400 px-0">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
												<figure class="w-full relative" data-stacking-factor="1">
													<img width="795" height="1182" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/Image-7501.png')}}" alt="3D shape">
												</figure>
											</div>
										</div>
										<div class="absolute w-auto max-w-100 bottom-100 right-120">
											<div class="lqd-imggrp-single block relative">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="163" height="114" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/Lines.svg')}}" alt="3D shape">
													</figure>
												</div>
											</div>
										</div>
										<div class="absolute w-auto top-15percent -right-80percent">
											<div class="lqd-imggrp-single block relative" data-float="ease">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="467" height="467" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/Image-764.png')}}" alt="3D shape">
													</figure>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Banner -->

					<!-- Start Fixed Navigation -->
					<!-- <section class="lqd-section fixed-navigation bg-white shadow-top transition-all">
						<div class="container">
							<div class="row">
								<div class="col col-12">
									<div class="lqd-fancy-menu lqd-custom-menu lqd-menu-td-none lqd-sticky-menu lqd-sticky-menu-floating bg-white link-black link-14" data-inview="true" data-inview-options='{ "toggleBehavior":  "toggleInView"}'>
										<ul class="reset-ul inline-ul" data-localscroll="true" data-localscroll-options='{"itemsSelector":">li > a", "trackWindowScroll": true, "includeParentAsOffset": true, "offsetElements": "[data-sticky-header] .lqd-head-sec-wrap:not(.lqd-hide-onstuck), body .main-header[data-sticky-header] >section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap), body .main-header[data-sticky-header] section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap)"}'>
											<li>
												<a href="#features">
													Features
												</a>
											</li>
											<li>
												<a href="#payments">
													Payments
												</a>
											</li>
											<li>
												<a href="#pricing">
													Pricing
												</a>
											</li>
											<li>
												<a href="#download">
													Download
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</section> -->
					<!-- End Fixed Navigation -->

					<!-- Start Clients -->
					<section class="lqd-section clients transition-all z-0 bg-white pb-50 pt-110">
						<div class="container">
							<div class="row">
								<div class="col col-12">
									<div class="row items-center text-start lg:text-center m-0">
										<div class="col col-12 text-center xxl:text-start p-0">
											<div class="ld-fancy-heading relative">
												<h6 class="text-14 m-0 text-text ld-fh-element relative">Book with Major Airlines at 24Flights.com</h6>
											</div>
										</div>
										<div class="col col-12 p-0">
											<div class="spacer w-full">
												<div class="w-full h-50"></div>
											</div>
										</div>
										<div class="col col-6 col-md-4 col-xl-2 p-0">
											<div class="lqd-imggrp-single block relative opacity-100">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="111" height="33" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Jazeera-1-2.svg')}}" alt="clients">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-6 col-md-4 col-xl-2 p-0">
											<div class="lqd-imggrp-single block relative opacity-100 module-img">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="65" height="23" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Qatar Airways.svg')}}" alt="clients">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-6 col-md-4 col-xl-2 p-0">
											<div class="lqd-imggrp-single block relative opacity-100">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="75" height="17" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Emirates Logo.svg')}}" alt="clients">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-6 col-md-4 col-xl-2 p-0">
											<div class="lqd-imggrp-single block relative opacity-100 module-img">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="88" height="23" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/AirArabia.svg')}}" alt="clients">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-6 col-md-4 col-xl-2 p-0">
											<div class="lqd-imggrp-single block relative opacity-100">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="96" height="37" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Turkish_airlines.svg')}}" alt="clients">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-6 col-md-4 col-xl-2 p-0">
											<div class="lqd-imggrp-single block relative opacity-100 module-img">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="85" height="25" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/KuwaitAirways.svg')}}" alt="clients">
													</figure>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Clients -->

					<!-- Start Features -->
					<section class="lqd-section features bg-white bg-no-repeat bg-cover bg-center text-start py-100" id="features" style="background-image: url('{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/features/Group-35762.svg')}}" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "opacity" : 0} , "animations": {"y": "0px", "opacity" : 1}}'>
						<div class="container">
							<div class="row">
								<div class="col col-12 col-xl-6 animation-element">
									<div class="flex flex-wrap flex-col mr-45percent ml-5percent">
										<div class="lqd-imggrp-single block relative">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="38" height="6" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/dash.svg')}}" alt="features">
												</figure>
											</div>
										</div>
										<div class="ld-fancy-heading relative">
											<h2 class="text-50 ld-fh-element mb-0/5em inline-block relative" data-text-rotator="true">
												<span>24Flights.com</span>
												<span class="txt-rotate-keywords">
													<span class="txt-rotate-keyword active">
														<span>Cheaper</span>
													</span>
													<span class="txt-rotate-keyword">
														<span>flexible</span>
													</span>
													<span class="txt-rotate-keyword">
														<span>affordable</span>
													</span>
												</span>
											</h2>
										</div>
										<div class="lqd-imggrp-single relative xs:hidden lg:hidden xxl:block" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "bottom+=0px top"}' data-parallax-from='{"x": "200px", "y": "-100px", "rotationZ" : 0}' data-parallax-to='{"x": "400px", "y": "0px", "rotationZ" : -90}'>
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="95" height="95" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/Image-760.svg')}}" alt="">
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="col col-12 col-xl-6 animation-element">
									<div class="lqd-iconbox-scale rounded-10 p-20 mb-30 transition-all mr-25percent">
										<div class="iconbox iconbox-side iconbox-heading-arrow-onhover flex flex-grow-1 relative">
											<div class="iconbox-icon-wrap">
												<div class="text-60 iconbox-icon-container inline-flex">
													<svg xmlns="http://www.w3.org/2000/svg" id="Notes" width="59" height="59" viewbox="0 0 59 59">
														<circle id="Oval-1" cx="29.5" cy="29.5" r="29.5" fill="#b7eef5"></circle>
														<path id="Combined_Shape-25" data-name="Combined Shape" d="M0,22.054A2.323,2.323,0,0,0,2.322,24.38H20.9a2.326,2.326,0,0,0,2.322-2.327V2.327A2.323,2.323,0,0,0,20.9,0H2.322A2.326,2.326,0,0,0,0,2.327Z" transform="translate(14.225 20.166)" fill="#008aba"></path>
														<path id="Combined_Shape-26" data-name="Combined Shape" d="M23.219,2.327A2.323,2.323,0,0,0,20.9,0H2.322A2.326,2.326,0,0,0,0,2.327V22.054A2.323,2.323,0,0,0,2.322,24.38H20.9a2.326,2.326,0,0,0,2.322-2.327Z" transform="translate(21.337 14.235)" fill="#6abbd7"></path>
														<path id="Shape-12" d="M9.237,11.8H1.152a1.18,1.18,0,0,1,0-2.36H9.237a1.18,1.18,0,0,1,0,2.36Zm-.58-4.72h-7.5a1.18,1.18,0,0,1,0-2.36h7.5a1.18,1.18,0,0,1,0,2.36ZM12.12,2.36H1.155A1.169,1.169,0,0,1,0,1.18,1.169,1.169,0,0,1,1.155,0H12.12a1.169,1.169,0,0,1,1.155,1.18A1.169,1.169,0,0,1,12.12,2.36Z" transform="translate(26.236 18.73)" fill="#b7eef5"></path>
													</svg>
												</div>
											</div>
											<div class="contents">
												<h3 class="lqd-iconbox-heading text-18 text-primary leading-1em">
													<span>Flight Bookings</span>
													<svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewbox="0 0 12 32">
														<path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path>
													</svg>
												</h3>
												<p>Discover a wide range of flights to destinations across the globe, all in one place.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col col-12 col-xl-6 animation-element">
									<div class="lqd-iconbox-scale rounded-10 p-20 mb-30 transition-all mr-25percent">
										<div class="iconbox iconbox-side iconbox-heading-arrow-onhover flex flex-grow-1 relative">
											<div class="iconbox-icon-wrap">
												<div class="text-60 iconbox-icon-container inline-flex">
													<svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" viewbox="0 0 58 58">
														<g id="Help" transform="translate(0 0)">
															<circle id="Oval-2" cx="29" cy="29" r="29" transform="translate(0 0)" fill="#ffe0ab"></circle>
															<path id="Shape-3" d="M18.422,36.975A18.517,18.517,0,0,1,11.2,35.527a18.373,18.373,0,0,1-9.766-9.715A17.854,17.854,0,0,1,0,18.79,18.9,18.9,0,0,1,5.346,5.453,18.155,18.155,0,0,1,18.422,0a16.92,16.92,0,0,1,6.883,1.458,17.805,17.805,0,0,1,5.673,4,18.742,18.742,0,0,1,3.852,5.966,19.55,19.55,0,0,1,1.42,7.371,18.013,18.013,0,0,1-1.42,7.021A18.456,18.456,0,0,1,30.978,31.6a18.06,18.06,0,0,1-5.673,3.929A17.07,17.07,0,0,1,18.422,36.975Zm-.3-27.153a8.358,8.358,0,0,0-6.008,2.538,8.789,8.789,0,0,0,0,12.255,8.379,8.379,0,0,0,12.015,0,8.789,8.789,0,0,0,0-12.255A8.357,8.357,0,0,0,18.125,9.822Z" transform="translate(10.5 10.15)" fill="#fbc774"></path>
															<path id="Shape-4" data-name="Shape-4" d="M18.642,37a19.338,19.338,0,0,1-6.092-1.026.672.672,0,0,1-.353-.646l1.042-9.375a.49.49,0,0,1,.249-.375,8.676,8.676,0,0,0,10.025,0,.48.48,0,0,1,.248.375L24.8,35.328a.683.683,0,0,1-.438.682A18.88,18.88,0,0,1,18.642,37ZM35.388,24.805a.539.539,0,0,1-.059,0l-9.375-1.041a.48.48,0,0,1-.375-.248,8.676,8.676,0,0,0,0-10.025.49.49,0,0,1,.375-.249L35.328,12.2a.561.561,0,0,1,.061,0,.684.684,0,0,1,.584.356A19.338,19.338,0,0,1,37,18.642a18.878,18.878,0,0,1-.99,5.722A.687.687,0,0,1,35.388,24.805Zm-33.775,0a.686.686,0,0,1-.622-.441A18.875,18.875,0,0,1,0,18.642a19.18,19.18,0,0,1,1.041-6.119.682.682,0,0,1,.57-.329.561.561,0,0,1,.061,0l9.374,1.042a.49.49,0,0,1,.376.25,8.677,8.677,0,0,0,0,10.023.478.478,0,0,1-.376.249L1.672,24.8A.54.54,0,0,1,1.612,24.805ZM13.489,11.422h0a.49.49,0,0,1-.249-.376L12.2,1.672a.68.68,0,0,1,.326-.631A19.18,19.18,0,0,1,18.642,0a18.873,18.873,0,0,1,5.722.99.682.682,0,0,1,.438.682l-1.041,9.374a.479.479,0,0,1-.249.376,8.677,8.677,0,0,0-10.022,0Z" transform="translate(10 10)" fill="#f5a623"></path>
														</g>
													</svg>
												</div>
											</div>
											<div class="contents">
												<h3 class="lqd-iconbox-heading text-18 text-primary leading-1em">
													<span>Hotel Bookings</span>
													<svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewbox="0 0 12 32">
														<path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path>
													</svg>
												</h3>
												<p>Our intuitive online hotel booking platform – your passport to effortless accommodation planning.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col col-12 col-xl-6 animation-element">
									<div class="lqd-iconbox-scale rounded-10 p-20 mb-30 transition-all mr-25percent">
										<div class="iconbox iconbox-side iconbox-heading-arrow-onhover flex flex-grow-1 relative">
											<div class="iconbox-icon-wrap">
												<div class="text-60 iconbox-icon-container inline-flex">
													<svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewbox="0 0 55 55">
														<g id="Network" transform="translate(0 -0.101)">
															<circle id="Oval-3" cx="27.5" cy="27.5" r="27.5" transform="translate(0 0.101)" fill="#b6ccf9"></circle>
															<path id="Shape-5" d="M16.792,37.125a3.325,3.325,0,1,1,3.25-3.324A3.291,3.291,0,0,1,16.792,37.125Zm14.625-5.541a4.389,4.389,0,0,1-4.333-4.433,4.54,4.54,0,0,1,.154-1.175l-10.382-5.31L7.473,26.774a4,4,0,0,1,.11.932,3.84,3.84,0,0,1-3.792,3.878,3.88,3.88,0,0,1,0-7.757,3.736,3.736,0,0,1,2.58,1.036l8.581-5.586L6.512,12.144a4.258,4.258,0,0,1-2.179.6A4.389,4.389,0,0,1,0,8.312,4.389,4.389,0,0,1,4.333,3.879,4.389,4.389,0,0,1,8.667,8.312a4.506,4.506,0,0,1-.608,2.265l8.291,7.006L22.344,7.123a4.173,4.173,0,0,1-1.219-2.968,4.064,4.064,0,1,1,8.125,0,4.115,4.115,0,0,1-4.062,4.156,3.977,3.977,0,0,1-.949-.114l-6.1,10.646L28.32,24.051a4.254,4.254,0,0,1,3.1-1.333,4.434,4.434,0,0,1,0,8.865Z" transform="translate(10.694 9.038)" fill="#79a0ee"></path>
															<circle id="Oval-4" data-name="Oval-4" cx="6.875" cy="6.875" r="6.875" transform="translate(20.275 21.774)" fill="#4577d8"></circle>
														</g>
													</svg>
												</div>
											</div>
											<div class="contents">
												<h3 class="lqd-iconbox-heading text-18 text-primary leading-1em">
													<span>Travel Packages</span>
													<svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewbox="0 0 12 32">
														<path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path>
													</svg>
												</h3>
												<p>Experience travel simplified with our curated travel packages. Our offers combine convenience and value.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Features -->

					<!-- Start Payments -->
					<section class="lqd-section payments pt-100 pb-80" id="payments">
						<div class="container">
							<div class="row">
								<div class="col col-12 col-xl-6 sm:hidden">
									<div class="sticky top-130">
										<div class="-mb-150 lqd-imggrp-single block relative" data-float="ease-in-out">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="566" height="553" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/payments/bg.svg')}}" alt="">
												</figure>
											</div>
										</div>
										<div class="absolute top-20 w-190 module-icon-1" data-parallax="true" data-parallax-options=' {"start": "top bottom", "end": "top center"}' data-parallax-from='{"x": "305px", "y": "250px"}' data-parallax-to='{"x": "0px", "y": "0px"}'>
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1">
														<img width="384" height="384" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/payments/hotels-signup.png')}}" alt="hotel booking">
													</figure>
												</div>
											</div>
										</div>
										<div class="absolute top-40 w-110 module-icon-2" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "bottom center"}' data-parallax-from='{"y": "200px"}' data-parallax-to='{"y": "0px"}'>
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1">
														<img width="232" height="216" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/payments/signup.png')}}" alt="SignUp Flights">
													</figure>
												</div>
											</div>
										</div>
										<div class="absolute w-110 top-230 module-icon-3" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "top center"}' data-parallax-from='{"x": "220px", "y": "-30px"}' data-parallax-to='{"x": "0px", "y": "0px"}'>
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1">
														<img width="232" height="216" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/payments/Book.png')}}" alt="twitter payment">
													</figure>
												</div>
											</div>
										</div>
										<div class="absolute w-110 top-230 module-icon-4" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "top center"}' data-parallax-from='{"x": "-194px", "y": "-30px"}' data-parallax-to='{"x": "0px", "y": "0px"}'>
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1">
														<img width="228" height="216" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/payments/Flight-search.png')}}" alt="Seaarch Flights">
													</figure>
												</div>
											</div>
										</div>
										<div class="absolute w-190 top-180 z-4 module-icon-5">
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1">
														<img width="470" height="470" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/payments/Flights-search.png')}}" alt="Flights Search">
													</figure>
												</div>
											</div>
										</div>
										<div class="absolute w-190 top-20 module-icon-6" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "top center"}' data-parallax-from='{"x": "-270px", "y": "270px"}' data-parallax-to='{"x": "0px", "y": "0px"}'>
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1">
														<img width="384" height="384" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/payments/fly-icon.png')}}" alt="Flights">
													</figure>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col col-12 col-xl-6 lg:order-first" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element, .iconbox", "startDelay" : 300, "ease": "power4.out", "initValues": {"y": "40px", "opacity" : 0} , "animations": {"y": "0px", "opacity" : 1}}'>
									<div class="mr-40 ml-130 flex flex-col lg:m-0">
										<div class="mb-40 iconbox flex flex-grow-1 relative items-center animation-element">
											<div class="iconbox-icon-wrap relative mr-25">
												<div class="w-40 text-40 iconbox-icon-container inline-flex">
													<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewbox="0 0 40 40">
														<g id="Message" transform="translate(0 -0.386)">
															<circle id="Oval-5" cx="20" cy="20" r="20" transform="translate(0 0.386)" fill="#b7eef5"></circle>
															<path id="Shape-6" d="M9.071,17.759l-.19,0a8.839,8.839,0,0,1-4.936-1.5L1.849,17.521c-.766.46-1.261.122-1.106-.757l.57-3.233A8.881,8.881,0,0,1,14.6,2.088,9.285,9.285,0,0,0,9.071,17.759Z" transform="translate(7.266 9.706)" fill="#6abbd7"></path>
															<path id="Shape-7" data-name="Shape-7" d="M0,9a9,9,0,1,1,16.669,4.713l.591,3.348c.149.847-.329,1.179-1.068.735L14,16.483A9,9,0,0,1,0,9Z" transform="translate(14 11.386)" fill="#008aba"></path>
														</g>
													</svg>
												</div>
											</div>
											<h3 class="text-18 font-normal mb-0 lqd-iconbox-heading">
												<strong>— How to Book</strong>&nbsp;on 24Flighs.com
											</h3>
										</div>
										<div class="ld-fancy-heading relative animation-element">
											<h2 class="ld-fh-element mb-0/5em inline-block relative">Search & Book.</h2>
										</div>
										<div class="ld-fancy-heading relative animation-element">
											<p class="text-18 font-normal mr-2em mb-0/5em ld-fh-element relative">
												<span class="text-black">Download the 24Flights app today and embark on a journey where advantages in travel are just a tap away.</span>
												<span>Your adventure begins here!</span>
											</p>
										</div>
										<div class="spacer w-full animation-element">
											<div class="w-full h-60"></div>
										</div>
										<div class="iconbox flex flex-grow-1 relative z-2 iconbox-circle iconbox-icon-linked mb-45 text-start">
											<div class="iconbox-icon-wrap relative mr-20">
												<div class="iconbox-icon-container relative z-1 text-15 w-50 h-50 text-blue-300 bg-blue-100 rounded-full shadow-lg">
													<i aria-hidden="true" class="lqd-icn-ess icon-num-1"></i>
												</div>
											</div>
											<div class="contents">
												<h3 class="text-20 mb-15 lqd-iconbox-heading">Sign Up & Register</h3>
												<p class="text-16 leading-1/6em text-text">Sign up to unlock a world of possibilities! Join our community and gain access to exclusive features.</p>
											</div>
										</div>
										<div class="iconbox flex flex-grow-1 relative z-2 iconbox-circle iconbox-icon-linked mb-45 text-start">
											<div class="iconbox-icon-wrap relative mr-20">
												<div class="iconbox-icon-container relative z-1 text-15 w-50 h-50 text-blue-300 bg-blue-100 rounded-full shadow-lg">
													<i aria-hidden="true" class="lqd-icn-ess icon-num-2"></i>
												</div>
											</div>
											<div class="contents">
												<h3 class="text-20 mb-15 lqd-iconbox-heading">Search Flights & Hotels </h3>
												<p class="text-16 leading-1/6em text-text">Find your wings with our flight search! Discover the perfect travel options tailored to your preferences.</p>
											</div>
										</div>
										<div class="iconbox flex flex-grow-1 relative z-2 iconbox-circle iconbox-icon-linked mb-45 text-start">
											<div class="iconbox-icon-wrap relative mr-20">
												<div class="iconbox-icon-container relative z-1 text-15 w-50 h-50 text-blue-300 bg-blue-100 rounded-full shadow-lg">
													<i aria-hidden="true" class="lqd-icn-ess icon-num-3"></i>
												</div>
											</div>
											<div class="contents">
												<h3 class="text-20 mb-15 lqd-iconbox-heading">Book & Pay </h3>
												<p class="text-16 leading-1/6em text-text">Book and pay with confidence and privacy. Our secure booking platform ensures your personal information is protected.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Payments -->

					<!-- Start Carousel Text LG -->
					<section class="lqd-section carousel-text-lg bg-white transition-all">
						<div class="ld-particles-container w-full lqd-particles-as-bg lqd-overlay flex">
							<div class="ld-particles-inner lqd-overlay flex pointer-events-none" id="lqd-particle-text-carousel" data-particles="true" data-particles-options='{"particles": {"number": {"value" : 4} , "color": {"value" : ["#604CFD", "#FDA44C", "#0FBBB4", "#F85976"]} , "shape": {"type" : ["circle"]} , "opacity": {"value" : 1} , "size": {"value" : 4, "random": true} , "move": {"enable": true, "direction": "none", "random": true, "out_mode": "out"}} , "interactivity" : [], "retina_detect": true}'></div>
						</div>
						<div class="container-fluid p-0">
							<div class="row m-0">
								<div class="col col-12 p-0">
									<div class="carousel-container relative carousel-nav-shaped" id="carousel-text">
										<div class="carousel-items relative -mr-30 -ml-30" data-lqd-flickity='{"percentPosition": false, "columnsAutoWidth": true, "marquee": true, "pauseAutoPlayOnHover": false}'>
											<div class="carousel-item flex flex-col justify-center px-30">
												<div class="carousel-item-inner relative w-full">
													<div class="carousel-item-content relative w-full font-bold leading-1/2em module-title-top">
														<h2 class="m-0 text-inherit leading-inherit pb-0/1em text-size-inherit">
															<strong>Online Flight Bookings </strong>
														</h2>
													</div>
												</div>
											</div>
											<div class="carousel-item flex flex-col justify-center px-30">
												<div class="carousel-item-inner relative w-full">
													<div class="carousel-item-content relative w-full font-bold leading-1/2em module-title-top">
														<h2 class="m-0 text-inherit leading-inherit pb-0/1em text-size-inherit">
															<strong>Online Hotel Bookings </strong>
														</h2>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col col-12 p-0">
									<div class="carousel-container relative carousel-nav-shaped">
										<div class="carousel-items relative -mr-30 -ml-30 " data-lqd-flickity='{"percentPosition": false, "columnsAutoWidth": true, "marquee": true, "rightToLeft": true, "pauseAutoPlayOnHover": false}'>
											<div class="carousel-item flex flex-col justify-center px-30">
												<div class="carousel-item-inner relative w-full">
													<div class="carousel-item-content relative w-full font-bold leading-1/2em  module-title-bottom">
														<h2 class="m-0 leading-inherit pb-0/1em text-transparent text-size-inherit"><strong> Travel Packages - Exclusive offers -</strong></h2>
													</div>
												</div>
											</div>
											<div class="carousel-item flex flex-col justify-center px-30">
												<div class="carousel-item-inner relative w-full">
													<div class="carousel-item-content relative w-full font-bold leading-1/2em  module-title-bottom">
														<h2 class="m-0 leading-inherit pb-0/1em text-transparent text-size-inherit"><strong> Travel Packages - Exclusive offers -</strong></h2>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Carousel Text LG -->

					<!-- Start Solutions -->
					<!-- <section class="lqd-section solutions bg-white transition-all lqd-section-scroll-activated" id="solutions" data-lqd-section-scroll="true" data-section-scroll-options='{"itemsSelector":  ".lqd-section-scroll-inner"}'>
						<div class="container p-0">
							<div class="lqd-section-scroll-inner module-img-1">
								<div class="container">
									<div class="row min-h-100vh items-center">
										<div class="col col-12 col-xl-6">
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1" data-reveal="true" data-reveal-options='{"direction": "tb"}'>
														<img width="1048" height="1006" src="./assets/images/demo/start-hub-3/tab-scroll/ss-1.jpg" alt="social media">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-12 col-xl-6 p-0" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "rotationY" : -35, "opacity" : 0} , "animations": {"y": "0px", "rotationY" : 0, "opacity" : 1}}'>
											<div class="flex flex-wrap py-10 pr-160 pl-80 module-col">
												<div class="ld-fancy-heading relative animation-element">
													<p class="text-18 mb-15 text-dark ld-fh-element relative"><strong>— 87.6</strong>&nbsp;Customer Satisfaction</p>
												</div>
												<div class="ld-fancy-heading relative animation-element">
													<h2 class="text-48 tracking-1 ld-fh-element mb-0/5em inline-block relative" data-inview="true" data-transition-delay="true" data-delay-options=' {"elements": ".lqd-highlight-inner", "delayType": "transition"}'>
														<mark class="lqd-highlight">
															<span class="lqd-highlight-txt">Social</span>
															<span class="bottom-0 left-0 lqd-highlight-inner bg-purple-200"></span>
														</mark>
														Media Management
													</h2>
												</div>
												<div class="ld-fancy-heading relative animation-element">
													<p class="text-16 tracking-0 ld-fh-element mb-0/5em inline-block relative">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </p>
												</div>
												<div class="spacer w-full animation-element">
													<div class="w-full h-50"></div>
												</div>
												<div class="w-full animation-element">
													<a href="#pricing" class="btn btn-solid btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y btn-custom-size btn-icon-right text-13 w-240 h-55 rounded-6 bg-purple-200 text-purple-500 hover:text-white hover:bg-primary" data-localscroll="true">
														<span class="btn-txt" data-text="Limited Time Offer" data-split-text="true" data-split-options='{"type":  "chars, words"}'>Select Premium Plan</span>
														<span class="btn-icon text-1em">
															<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
														</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lqd-section-scroll-inner module-img-2">
								<div class="container">
									<div class="row min-h-100vh items-center">
										<div class="col col-12 col-xl-6">
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1" data-reveal="true" data-reveal-options='{"direction": "tb"}'>
														<img width="1048" height="1006" src="./assets/images/demo/start-hub-3/tab-scroll/ss-2.jpg" alt="mobile Development">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-12 col-xl-6 p-0" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "rotationY" : -35, "opacity" : 0} , "animations": {"y": "0px", "rotationY" : 0, "opacity" : 1}}'>
											<div class="flex flex-wrap py-10 pr-160 pl-80 module-col">
												<div class="ld-fancy-heading relative animation-element">
													<p class="text-18 mb-15 ld-fh-element mb-0/5em inline-block relative"><strong>— 87.6</strong>&nbsp;Customer Satisfaction</p>
												</div>
												<div class="ld-fancy-heading relative animation-element">
													<h2 class="text-48 tracking-1  ld-fh-element mb-0/5em inline-block relative" data-inview="true" data-transition-delay="true" data-delay-options=' {"elements": ".lqd-highlight-inner", "delayType": "transition"}'>
														<mark class="lqd-highlight">
															<span class="lqd-highlight-txt">Mobile</span>
															<span class="bottom-0 left-0 lqd-highlight-inner bg-blue-200"></span>
														</mark> Development
													</h2>
												</div>
												<div class="ld-fancy-heading relative animation-element">
													<p class="text-16 tracking-0 ld-fh-element mb-0/5em inline-block relative">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </p>
												</div>
												<div class="spacer w-full animation-element">
													<div class="w-full h-50"></div>
												</div>
												<div class="w-full animation-element">
													<a href="#pricing" class="btn btn-solid btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y btn-custom-size btn-icon-right text-13 w-240 h-55 rounded-6 bg-blue-200 text-blue-500 hover:text-white hover:bg-primary" data-localscroll="true">
														<span class="btn-txt" data-text="Limited Time Offer" data-split-text="true" data-split-options='{"type":  "chars, words"}'>Select Premium Plan</span>
														<span class="btn-icon text-1em">
															<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
														</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lqd-section-scroll-inner module-img-3">
								<div class="container">
									<div class="row min-h-100vh items-center">
										<div class="col col-12 col-xl-6">
											<div class="lqd-imggrp-single block relative perspective" data-hover3d="true">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center transform-style-3d">
													<figure class="w-full relative" data-stacking-factor="1" data-reveal="true" data-reveal-options='{"direction": "tb"}'>
														<img width="1048" height="1006" src="./assets/images/demo/start-hub-3/tab-scroll/ss-3.jpg" alt="ecommerce solutions">
													</figure>
												</div>
											</div>
										</div>
										<div class="col col-12 col-xl-6 p-0" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "rotationY" : -35, "opacity" : 0} , "animations": {"y": "0px", "rotationY" : 0, "opacity" : 1}}'>
											<div class="flex flex-wrap py-10 pr-160 pl-80 module-col">
												<div class="ld-fancy-heading relative animation-element">
													<p class="text-18 mb-15 text-dark ld-fh-element relative"><strong>— 87.6</strong>&nbsp;Customer Satisfaction</p>
												</div>
												<div class="ld-fancy-heading relative animation-element">
													<h2 class="text-48 tracking-1  ld-fh-element mb-0/5em inline-block relative" data-inview="true" data-transition-delay="true" data-delay-options=' {"elements": ".lqd-highlight-inner", "delayType": "transition"}'>
														<mark class="lqd-highlight">
															<span class="lqd-highlight-txt">eCommerce</span>
															<span class="bottom-0 left-0 lqd-highlight-inner bg-red-200"></span>
														</mark> Solutions
													</h2>
												</div>
												<div class="ld-fancy-heading relative animation-element">
													<p class="text-16 tracking-0 ld-fh-element mb-0/5em inline-block relative">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </p>
												</div>
												<div class="spacer w-full animation-element">
													<div class="w-full h-50"></div>
												</div>
												<div class="w-full animation-element">
													<a href="#pricing" class="btn btn-solid btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y btn-custom-size btn-icon-right text-13 w-240 h-55 rounded-6 bg-red-200 text-red-500 hover:text-white hover:bg-primary" data-localscroll="true">
														<span class="btn-txt" data-text="Limited Time Offer" data-split-text="true" data-split-options='{"type":  "chars, words"}'>Select Premium Plan</span>
														<span class="btn-icon text-1em">
															<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
														</span>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section> -->
					<!-- End Solutions -->

					<!-- Start Subscribe -->
					<section class="lqd-section subscribe transition-all bg-transparent pb-120" style="background-image: linear-gradient(180deg, #DBE4FE 0%, #fff 100%);">
						<div class="lqd-shape lqd-shape-top" data-negative="false">
							<svg class="h-60" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 1000 100" preserveaspectratio="none">
								<path class="lqd-shape-fill" d="M738,99l262-93V0H0v5.6L738,99z" fill="#fff"></path>
							</svg>
						</div>
						<div class="container">
							<div class="row">
								<div class="col col-12 p-0" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "bottom+=0px top"}' data-parallax-from='{"y": "100px", "scaleX" : 1, "scaleY" : 1}' data-parallax-to='{"y": "-100px", "scaleX" : 1.1, "scaleY" : 1.1}'>
									<div class="py-40 px-70 flex flex-wrap transition-all box-shadow-bottom w-full bg-no-repeat bg-center bg-white bg-contain relative rounded-10 rounded-bottom-0 module-section" style="background-image: url('{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/subscribe/shape.svg')}}");">
										<div class="w-60percent relative flex p-10 sm:w-full">
											<p class="text-18 text-accent ld-fh-element mb-0/5em inline-block relative">Your adventure begins here! </p>
										</div>
										<div class="w-40percent relative flex justify-end items-center p-10 sm:w-full sm:justify-center">
											<a href="{{ url('/')}}" class="btn btn-solid btn-md btn-icon-right btn-hover-swp text-15 rounded-4 bg-primary text-white sm:w-full" data-lity="#contact-modal">
												<span class="btn-txt" data-text="Sign up free">Book on 24Flights.com</span>
												<span class="btn-icon text-1em">
													<i aria-hidden="true" class="lqd-icn-ess icon-md-arrow-forward"></i>
												</span>
												<span class="btn-icon mr-10 text-1em">
													<i aria-hidden="true" class="lqd-icn-ess icon-md-arrow-forward"></i>
												</span>
											</a>
										</div>
									</div>
									<div class="w-full relative flex items-center mb-0 module-lines">
										<div class="divider w-25percent py-15 relative">
											<span class="divider-separator w-full flex m-0"></span>
										</div>
										<div class="divider w-45percent py-15 relative">
											<span class="divider-separator w-full flex m-0"></span>
										</div>
										<div class="divider w-20percent py-15 relative">
											<span class="divider-separator w-full flex m-0"></span>
										</div>
										<div class="divider w-10percent py-15 relative">
											<span class="divider-separator w-full flex m-0"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Subscribe -->

					<!-- Start Tab Box -->
					<!-- <section class="lqd-section tab-box bg-white transition-all py-50" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "opacity" : 0} , "animations": {"y": "0px", "opacity" : 1}}'>
						<div class="container animation-element">
							<div class="row justify-center">
								<div class="col col-12 col-md-10 col-lg-8 text-center pb-50 pt-20">
									<div class="ld-fancy-heading relative">
										<h2 class="ld-fh-element mb-0/5em inline-block relative ld-gradient-heading lqd-highlight-classic lqd-highlight-grow-left lqd-highlight-reset-onhover text-44 bg-transparent" data-inview="true" data-transition-delay="true" data-delay-options=' {"elements": ".lqd-highlight-inner", "delayType": "transition"}' style="background-image: linear-gradient(250deg, #4452F2 0%, #749FEF 100%);">
											<span>Built-in froud</span>
											<mark class="lqd-highlight">
												<span class="lqd-highlight-txt">protection.</span>
												<span class="lqd-highlight-inner h-20 -bottom-5 left-0 bg-slate-100"></span>
											</mark>
										</h2>
									</div>
									<div class="px-10percent ld-fancy-heading relative">
										<p class="ld-fh-element mb-0/5em inline-block relative text-18">Use customer data to build great and solid product experiences that convert.</p>
									</div>
								</div>
								<div class="col col-12 py-0">
									<div class="flex">
										<div class="lqd-tabs lqd-tabs-style-13 flex lqd-tabs-nav-items-not-expanded flex-row-reverse lqd-nav-underline-" data-tabs-options='{"trigger": "click"}'>
											<nav class="lqd-tabs-nav-wrap">
												<ul class="reset-ul lqd-tabs-nav flex flex-col relative" role="tablist">
													<li role="presentation">
														<a class="bg-transparent rounded-12 block mb-0/5em active" href="#lqd-tab-box-one" aria-expanded="true" aria-controls="lqd-tab-box-one" role="tab" data-bs-toggle="tab">
															<span class="block lqd-tabs-nav-txt">Visual Site Editor</span>
															<span class="lqd-tabs-nav-ext">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </span>
														</a>
													</li>
													<li role="presentation">
														<a class="bg-transparent rounded-12 block mb-0/5em" href="#lqd-tab-box-two" aria-expanded="false" aria-controls="lqd-tab-box-two" role="tab" data-bs-toggle="tab">
															<span class="block lqd-tabs-nav-txt">Responsive Settings</span>
															<span class="lqd-tabs-nav-ext">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </span>
														</a>
													</li>
													<li role="presentation">
														<a class="bg-transparent rounded-12 block mb-0/5em" href="#lqd-tab-box-three" aria-expanded="false" aria-controls="lqd-tab-box-three" role="tab" data-bs-toggle="tab">
															<span class="block lqd-tabs-nav-txt">Live Theme Customizer</span>
															<span class="lqd-tabs-nav-ext">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </span>
														</a>
													</li>
													<li role="presentation">
														<a class="bg-transparent rounded-12 block mb-0/5em" href="#lqd-tab-box-four" aria-expanded="false" aria-controls="lqd-tab-box-four" role="tab" data-bs-toggle="tab">
															<span class="block lqd-tabs-nav-txt">Hub Collection</span>
															<span class="lqd-tabs-nav-ext">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </span>
														</a>
													</li>
													<li role="presentation">
														<a class="bg-transparent rounded-12 block mb-0/5em" href="#lqd-tab-five" aria-expanded="false" aria-controls="lqd-tab-five" role="tab" data-bs-toggle="tab">
															<span class="block lqd-tabs-nav-txt">Light and Dark Modes</span>
															<span class="lqd-tabs-nav-ext">Adjust your design through a wide range of theme options in the WordPress Customizer and see the changes instantly. </span>
														</a>
													</li>
												</ul>
											</nav>
											<div class="lqd-tabs-content pr-2em relative">
												<div id="lqd-tab-box-one" role="tabpanel" class="lqd-tabs-pane fade active in">
													<img src="./assets/images/demo/start-hub-3/tab-box/tab-img1-e1636554722912.png" alt="tab box" width="1773" height="1121">
												</div>
												<div id="lqd-tab-box-two" role="tabpanel" class="lqd-tabs-pane fade">
													<img src="./assets/images/demo/start-hub-3/tab-box/tab-img1-e1636554722912.png" alt="tab box" width="1773" height="1121">
												</div>
												<div id="lqd-tab-box-three" role="tabpanel" class="lqd-tabs-pane fade">
													<img src="./assets/images/demo/start-hub-3/tab-box/tab-img1-e1636554722912.png" alt="tab box" width="1773" height="1121">
												</div>
												<div id="lqd-tab-box-four" role="tabpanel" class="lqd-tabs-pane fade">
													<p><img src="./assets/images/demo/start-hub-3/tab-box/tab-img1-e1636554722912.png" alt="tab box" width="1773" height="1121">
												</div>
												<div id="lqd-tab-five" role="tabpanel" class="lqd-tabs-pane fade">
													<p><img src="./assets/images/demo/start-hub-3/tab-box/tab-img1-e1636554722912.png" alt="tab box" width="1773" height="1121">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col col-12 pt-0">
									<div class="w-full relative flex flex-wrap items-center">
										<div class="w-25percent flex flex-col lg:w-50percent">
											<div class="text-primary lqd-counter relative left lqd-counter-default">
												<div class="lqd-counter-element relative h1" data-enable-counter="true" data-counter-options='{"targetNumber": "4m+"}'>
													<span class="block">4m+</span>
												</div>
											</div>
											<div class="mb-15 lqd-imggrp-single block relative">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="107" height="15" src="./assets/images/demo/start-hub-3/3D/stars.svg" alt="stars">
													</figure>
												</div>
											</div>
											<div class="mb-10 ld-fancy-heading relative">
												<p class="m-0 text-accent ld-fh-element relative">Installations</p>
											</div>
											<div class="ld-fancy-heading relative">
												<p class="m-0 text-gradient-start ld-fh-element relative">Application Store</p>
											</div>
										</div>
										<div class="w-25percent flex flex-col lg:w-50percent">
											<div class="text-primary lqd-counter relative left lqd-counter-default">
												<div class="lqd-counter-element relative h1" data-enable-counter="true" data-counter-options='{"targetNumber": "4.88"}'>
													<span class="block">4.88</span>
												</div>
											</div>
											<div class="mb-15 lqd-imggrp-single block relative">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="107" height="15" src="./assets/images/demo/start-hub-3/3D/stars.svg" alt="stars">
													</figure>
												</div>
											</div>
											<div class="mb-10 ld-fancy-heading relative">
												<p class="m-0 text-accent ld-fh-element relative">Installations</p>
											</div>
											<div class="ld-fancy-heading relative">
												<p class="m-0 text-gradient-start ld-fh-element relative">Application Store</p>
											</div>
										</div>
										<div class="w-50percent relative flex flex-wrap justify-between pr-100 module-clients lg:w-full lg:pr-0">
											<div class="w-auto lqd-imggrp-single block relative">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="101" height="30" src="./assets/images/demo/start-hub-3/clients/Jazeera-1-2.svg" alt="clients">
													</figure>
												</div>
											</div>
											<div class="w-auto lqd-imggrp-single block relative">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="66" height="21" src="./assets/images/demo/start-hub-3/clients/hulu-2.svg" alt="clients">
													</figure>
												</div>
											</div>
											<div class="w-auto lqd-imggrp-single block relative">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="96" height="37" src="./assets/images/demo/start-hub-3/clients/Turkish airlines.svg" alt="clients">
													</figure>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section> -->
					<!-- End Tab Box -->

					<!-- Start Pricing -->
					<!-- <section class="lqd-section pricing bg-tarnsparent transition-all pt-100 pb-120" id="pricing" style="background-image: linear-gradient(180deg, #DBFEF1 0%, #fff 25%);">
						<div class="lqd-shape lqd-shape-top" data-negative="false">
							<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 1000 100" preserveaspectratio="none">
								<path class="lqd-shape-fill" d="M738,99l262-93V0H0v5.6L738,99z" fill="#fff"></path>
							</svg>
						</div>
						<div class="flex flex-col relative w-full">
							<div class="absolute w-auto -top-100 sm:hidden module-shape-1" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "bottom+=0px top"}' data-parallax-from='{"x": "-40px", "y": "-50px", "rotationZ" : 0}' data-parallax-to='{"x": "0px", "y": "20px", "rotationZ" : 360}'>
								<div class="lqd-imggrp-single block relative">
									<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
										<figure class="w-full relative">
											<img width="95" height="95" src="./assets/images/demo/start-hub-3/3D/Image-760.svg" alt="3D shape">
										</figure>
									</div>
								</div>
							</div>
							<div class="absolute w-45 bottom-0 lg:hidden module-shape-2" data-parallax="true" data-parallax-options='{"start": "top bottom", "end": "bottom+=0px top"}' data-parallax-from='{"y": "0px"}' data-parallax-to='{"y": "-1000px"}'>
								<div class="lqd-imggrp-single block relative">
									<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
										<figure class="w-full relative">
											<img width="86" height="558" src="./assets/images/demo/start-hub-3/3D/ballon.png" alt="ballon 3D shape">
										</figure>
									</div>
								</div>
							</div>
							<div class="mb-50">
								<div class="container">
									<div class="row">
										<div class="w-10percent lg:w-15percent sm:w-full text-start">
											<div class="iconbox flex flex-grow-1 relative flex-wrap items-center iconbox-inline iconbox-icon-shaped iconbox-circle">
												<div class="iconbox-icon-wrap">
													<div class="iconbox-icon-container inline-flex relative z-1 rounded-full">
														<svg xmlns="http://www.w3.org/2000/svg" id="Credit-card" width="49" height="49" viewbox="0 0 49 49">
															<rect id="bound-1" width="49" height="49" fill="none"></rect>
															<rect id="Combined_Shape-27" data-name="Combined Shape" width="41" height="27" rx="2" transform="translate(4 11)" fill="#00cb99" opacity="0.3"></rect>
															<rect id="Rectangle_59" data-name="Rectangle 59" width="41" height="7" transform="translate(4 16)" fill="#00cb99"></rect>
															<rect id="Rectangle_59_Copy" data-name="Rectangle 59 Copy" width="8" height="4" rx="1" transform="translate(33 29)" fill="#00cb99" opacity="0.3"></rect>
														</svg>
													</div>
												</div>
											</div>
										</div>
										<div class="w-90percent lg:w-85percent sm:w-full">
											<div class="ld-fancy-heading relative">
												<h2 class="text-44 mb-10 ld-fh-element relative">Simple Pricing</h2>
											</div>
											<div class="ld-fancy-heading relative">
												<p class="text-18 ld-fh-element mb-0/5em inline-block relative">Use customer data to build great and solid product experiences that convert.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="container relative">
								<div class="row">
									<div class="col col-12">
										<div class="absolute w-90 -top-170 -right-100 module-save lg:hidden">
											<div class="lqd-imggrp-single block relative" data-float="ease">
												<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
													<figure class="w-full relative">
														<img width="174" height="111" src="./assets/images/demo/start-hub-3/3D/save@x21.png" alt="save 30%">
													</figure>
												</div>
											</div>
										</div>
										<div class="-mt-130 lqd-tabs lqd-tabs-style-10 lqd-tabs-nav-items-not-expanded lqd-nav-underline-" data-tabs-options='{"trigger": "click"}'>
											<nav class="lqd-tabs-nav-wrap mb-2/25em">
												<ul class="link-15 reset-ul lqd-tabs-nav flex flex-wrap items-end justify-end relative" role="tablist">
													<li data-controls="lqd-tab-price-monthly" role="presentation" class="font-medium">
														<a class="flex items-center active" href="#lqd-tab-price-monthly" aria-expanded="true" aria-controls="lqd-tab-price-monthly" role="tab" data-bs-toggle="tab">
															<span class="lqd-tabs-nav-txt">Monthly</span>
														</a>
													</li>
													<li data-controls="lqd-tab-price-annually" role="presentation" class="font-medium">
														<a class="flex items-center" href="#lqd-tab-price-annually" aria-expanded="false" aria-controls="lqd-tab-price-annually" role="tab" data-bs-toggle="tab">
															<span class="lqd-tabs-nav-txt">Annually</span>
														</a>
													</li>
												</ul>
											</nav>
											<div class="pt-80 lqd-tabs-content relative">
												<div id="lqd-tab-price-monthly" role="tabpanel" class="lqd-tabs-pane fade active" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"x": "35px", "opacity" : 0} , "animations": {"x": "0px", "opacity" : 1}}'>
													<div class="container animation-element">
														<div class="row text-center">
															<div class="col col-12 col-md-4 col-xl-3 p-0 lg:hidden animation-element">
																<div class="flex flex-col py-50 px-20 text-start w-full">
																	<div class="lqd-imggrp-single block relative">
																		<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
																			<figure class="w-full relative">
																				<img width="272" height="192" src="./assets/images/demo/start-hub-3/3D/rocket.svg" alt="rocket">
																			</figure>
																		</div>
																	</div>
																	<div class="w-full mt-65">
																		<ul class="reset-ul icon-list-items">
																			<li class="flex items-center pb-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Hidden-1" width="25" height="25" viewbox="0 0 25 25">
																						<rect id="bound-2" width="25" height="25" fill="none"></rect>
																						<path id="Combined_Shape-1" data-name="Combined Shape" d="M.942,8.491C.625,8.491.308,8.477,0,8.45L8.45,0a19.584,19.584,0,0,1,1.867,2.242l0,.006A20.748,20.748,0,0,1,7.548,5.366C5.992,6.792,3.584,8.491.942,8.491Z" transform="translate(11.558 10.259)" fill="#737588"></path>
																						<path id="Combined_Shape-2" data-name="Combined Shape" d="M2.632,9.868h0A11.464,11.464,0,0,1,0,6.25,11.459,11.459,0,0,1,2.131,3.125,10.232,10.232,0,0,1,5.034.977,9.8,9.8,0,0,1,9.375,0a7.251,7.251,0,0,1,2.609.515L9.375,3.125A3.129,3.129,0,0,0,6.25,6.25L2.633,9.868Z" transform="translate(3.125 6.25)" fill="#737588"></path>
																						<rect id="Rectangle-3" width="19.792" height="2.083" transform="translate(5.313 19.203) rotate(-45)" fill="#737588" opacity="0.3"></rect>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Chat_1" data-name="Chat#5" width="22" height="22" viewbox="0 0 22 22">
																						<rect id="bound-3" width="22" height="22" fill="none"></rect>
																						<path id="Combined_Shape-3" data-name="Combined Shape" d="M15.875,15.852l-2.1-2.1H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H14.417a3,3,0,0,1,3,3v7.75q0,.133-.011.264L17.439,11v4.2a.916.916,0,0,1-.923.918A.9.9,0,0,1,15.875,15.852Z" transform="translate(2.75 2.75)" fill="#737588" opacity="0.3"></path>
																						<path id="Combined_Shape-4" data-name="Combined Shape" d="M10.616,3A1.447,1.447,0,0,1,9.231,1.5,1.448,1.448,0,0,1,10.616,0,1.447,1.447,0,0,1,12,1.5,1.447,1.447,0,0,1,10.616,3ZM6,3A1.447,1.447,0,0,1,4.616,1.5,1.447,1.447,0,0,1,6,0,1.448,1.448,0,0,1,7.385,1.5,1.447,1.447,0,0,1,6,3ZM1.385,3A1.447,1.447,0,0,1,0,1.5,1.448,1.448,0,0,1,1.385,0,1.447,1.447,0,0,1,2.769,1.5,1.447,1.447,0,0,1,1.385,3Z" transform="translate(5 8)" fill="#737588" opacity="0.3"></path>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" width="18" height="18.01" viewbox="0 0 18 18.01">
																						<g id="Outgoing-box-1" transform="translate(0 0.01)">
																							<rect id="bound-4" width="18" height="18" fill="none"></rect>
																							<path id="Combined_Shape-5" data-name="Combined Shape" d="M15,0V3a1.5,1.5,0,0,1-1.5,1.5H1.5A1.5,1.5,0,0,1,0,3V0H3.209l.408,1.224A1.5,1.5,0,0,0,5.041,2.25h5a1.5,1.5,0,0,0,1.342-.829L12.089,0Z" transform="translate(1.5 12.75)" fill="#737588"></path>
																							<path id="Path-3" d="M0,5.25,2.523.765A1.5,1.5,0,0,1,3.83,0h6.5a1.5,1.5,0,0,1,1.307.765L14.156,5.25h-2.49a1.5,1.5,0,0,0-1.342.829L9.615,7.5h-5L4.211,6.276A1.5,1.5,0,0,0,2.788,5.25Z" transform="translate(1.922 6)" fill="#737588" opacity="0.3"></path>
																							<path id="Shape-8" d="M2.5.09a.375.375,0,0,0-.617.286V1.843H.375A.375.375,0,0,0,0,2.218v.767a.375.375,0,0,0,.375.375H1.881V4.828a.375.375,0,0,0,.617.286L5.127,2.888a.375.375,0,0,0,0-.572Z" transform="translate(6.398 5.25) rotate(-90)" fill="#737588"></path>
																						</g>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Automate All Contracts</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Hidden-2" width="25" height="25" viewbox="0 0 25 25">
																						<rect id="bound-5" width="25" height="25" fill="none"></rect>
																						<path id="Combined_Shape-6" data-name="Combined Shape" d="M.942,8.491C.625,8.491.308,8.477,0,8.45L8.45,0a19.584,19.584,0,0,1,1.867,2.242l0,.006A20.748,20.748,0,0,1,7.548,5.366C5.992,6.792,3.584,8.491.942,8.491Z" transform="translate(11.558 10.259)" fill="#737588"></path>
																						<path id="Combined_Shape-7" data-name="Combined Shape" d="M2.632,9.868h0A11.464,11.464,0,0,1,0,6.25,11.459,11.459,0,0,1,2.131,3.125,10.232,10.232,0,0,1,5.034.977,9.8,9.8,0,0,1,9.375,0a7.251,7.251,0,0,1,2.609.515L9.375,3.125A3.129,3.129,0,0,0,6.25,6.25L2.633,9.868Z" transform="translate(3.125 6.25)" fill="#737588"></path>
																						<rect id="Rectangle-4" width="19.792" height="2.083" transform="translate(5.313 19.203) rotate(-45)" fill="#737588" opacity="0.3"></rect>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Chat_2" data-name="Chat#5" width="22" height="22" viewbox="0 0 22 22">
																						<rect id="bound-6" width="22" height="22" fill="none"></rect>
																						<path id="Combined_Shape-8" data-name="Combined Shape" d="M15.875,15.852l-2.1-2.1H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H14.417a3,3,0,0,1,3,3v7.75q0,.133-.011.264L17.439,11v4.2a.916.916,0,0,1-.923.918A.9.9,0,0,1,15.875,15.852Z" transform="translate(2.75 2.75)" fill="#737588" opacity="0.3"></path>
																						<path id="Combined_Shape-9" data-name="Combined Shape" d="M10.616,3A1.447,1.447,0,0,1,9.231,1.5,1.448,1.448,0,0,1,10.616,0,1.447,1.447,0,0,1,12,1.5,1.447,1.447,0,0,1,10.616,3ZM6,3A1.447,1.447,0,0,1,4.616,1.5,1.447,1.447,0,0,1,6,0,1.448,1.448,0,0,1,7.385,1.5,1.447,1.447,0,0,1,6,3ZM1.385,3A1.447,1.447,0,0,1,0,1.5,1.448,1.448,0,0,1,1.385,0,1.447,1.447,0,0,1,2.769,1.5,1.447,1.447,0,0,1,1.385,3Z" transform="translate(5 8)" fill="#737588" opacity="0.3"></path>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" width="18" height="18.01" viewbox="0 0 18 18.01">
																						<g id="Outgoing-box-2" transform="translate(0 0.01)">
																							<rect id="bound-7" width="18" height="18" fill="none"></rect>
																							<path id="Combined_Shape-10" data-name="Combined Shape" d="M15,0V3a1.5,1.5,0,0,1-1.5,1.5H1.5A1.5,1.5,0,0,1,0,3V0H3.209l.408,1.224A1.5,1.5,0,0,0,5.041,2.25h5a1.5,1.5,0,0,0,1.342-.829L12.089,0Z" transform="translate(1.5 12.75)" fill="#737588"></path>
																							<path id="Path-4" d="M0,5.25,2.523.765A1.5,1.5,0,0,1,3.83,0h6.5a1.5,1.5,0,0,1,1.307.765L14.156,5.25h-2.49a1.5,1.5,0,0,0-1.342.829L9.615,7.5h-5L4.211,6.276A1.5,1.5,0,0,0,2.788,5.25Z" transform="translate(1.922 6)" fill="#737588" opacity="0.3"></path>
																							<path id="Shape-9" d="M2.5.09a.375.375,0,0,0-.617.286V1.843H.375A.375.375,0,0,0,0,2.218v.767a.375.375,0,0,0,.375.375H1.881V4.828a.375.375,0,0,0,.617.286L5.127,2.888a.375.375,0,0,0,0-.572Z" transform="translate(6.398 5.25) rotate(-90)" fill="#737588"></path>
																						</g>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Self Service Support</span>
																			</li>
																			<li class="flex items-center mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Hidden-3" width="25" height="25" viewbox="0 0 25 25">
																						<rect id="bound-8" width="25" height="25" fill="none"></rect>
																						<path id="Combined_Shape-11" data-name="Combined Shape" d="M.942,8.491C.625,8.491.308,8.477,0,8.45L8.45,0a19.584,19.584,0,0,1,1.867,2.242l0,.006A20.748,20.748,0,0,1,7.548,5.366C5.992,6.792,3.584,8.491.942,8.491Z" transform="translate(11.558 10.259)" fill="#737588"></path>
																						<path id="Combined_Shape-12" data-name="Combined Shape" d="M2.632,9.868h0A11.464,11.464,0,0,1,0,6.25,11.459,11.459,0,0,1,2.131,3.125,10.232,10.232,0,0,1,5.034.977,9.8,9.8,0,0,1,9.375,0a7.251,7.251,0,0,1,2.609.515L9.375,3.125A3.129,3.129,0,0,0,6.25,6.25L2.633,9.868Z" transform="translate(3.125 6.25)" fill="#737588"></path>
																						<rect id="Rectangle-5" width="19.792" height="2.083" transform="translate(5.313 19.203) rotate(-45)" fill="#737588" opacity="0.3"></rect>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																</div>
															</div>
															<div class="col col-12 col-md-4 col-xl-3 p-0 animation-element">
																<div class="flex flex-col items-center w-full py-50 px-20">
																	<div class="mb-20 rounded-100 bg-black-10 w-auto ld-fancy-heading relative">
																		<p class="text-10 font-semibold tracking-1 m-0 px-15 text-black uppercase ld-fh-element relative">Simple plan</p>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<h2 class="m-0 ld-fh-element relative">Free<span class="text-14 font-normal">/mo</span></h2>
																	</div>
																	<div class="py-15 w-full divider">
																		<span class="divider-separator"></span>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<p class="text-14 ld-fh-element mb-0/5em inline-block relative">Use customer data to build great and solid product experiences that convert.</p>
																	</div>
																	<div class="w-full text-center mt-55 mb-40 lg:hidden">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">100GB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																		</ul>
																	</div>
																	<div class="mt-55 mb-40 hidden lg:block">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">100GB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Self Service Support</span>
																			</li>
																			<li class="mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																	<a href="#contact-modal" class="btn btn-underlined border-thin text-green-500 text-13 module-btn-1" data-lity="#contact-modal">
																		<span class="btn-txt" data-text="Select Free Plan">Select Free Plan</span>
																	</a>
																</div>
															</div>
															<div class="col col-12 col-md-4 col-xl-3 p-0 animation-element">
																<div class="flex flex-col items-center relative py-50 px-20 bg-lightgray transition-all rounded-12">
																	<div class="badge-lqd-shape absolute z-0 -top-70 lg:hidden">
																		<div class="lqd-imggrp-single block relative">
																			<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
																				<figure class="w-full relative">
																					<img width="62" height="62" src="./assets/images/demo/start-hub-3/3D/badge.svg" alt="badge shape">
																				</figure>
																			</div>
																		</div>
																	</div>
																	<div class="badge-text absolute -top-55 sm:hidden">
																		<div class="ld-fancy-heading relative">
																			<span class="text-white text-14 leading-1em m-0 ld-fh-element relative">20%<br>OFF</span>
																		</div>
																	</div>
																	<div class="mb-20 rounded-100 bg-black-10 w-auto ld-fancy-heading relative">
																		<p class="text-10 font-semibold tracking-1 m-0 px-15 text-black uppercase ld-fh-element relative">Popular plan</p>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<h2 class="m-0 ld-fh-element relative">€85<span style="font-size:15px;font-weight:normal">/mo</span></h2>
																	</div>
																	<div class="py-15 w-full divider">
																		<span class="divider-separator"></span>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<p class="text-14 ld-fh-element mb-0/5em inline-block relative">Use customer data to build great and solid product experiences that convert.</p>
																	</div>
																	<div class="w-full text-center mt-55 mb-40 lg:hidden">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">1TB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																		</ul>
																	</div>
																	<div class="mt-55 mb-40 hidden lg:block">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">1TB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Self Service Support</span>
																			</li>
																			<li class="mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																	<a href="#contact-modal" class="btn btn-underlined border-thin text-gradient-start text-13 module-btn-2" data-lity="#contact-modal">
																		<span class="btn-txt" data-text="Select Popular Plan">Select Popular Plan</span>
																	</a>
																</div>
															</div>
															<div class="col col-12 col-md-4 col-xl-3 p-0 animation-element">
																<div class="flex flex-col items-center w-full py-50 px-20">
																	<div class="mb-20 rounded-100 bg-black-10 w-auto ld-fancy-heading relative">
																		<p class="text-10 font-semibold tracking-1 m-0 px-15 text-black uppercase ld-fh-element relative">Premium plan</p>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<h2 class="m-0 ld-fh-element relative">€23<span style="font-size:15px;font-weight:normal">/mo</span></h2>
																	</div>
																	<div class="py-15 w-full divider">
																		<span class="divider-separator"></span>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<p class="text-14 ld-fh-element mb-0/5em inline-block relative">Use customer data to build great and solid product experiences that convert.</p>
																	</div>
																	<div class="w-full text-center mt-55 mb-40 lg:hidden">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Storage</span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																		</ul>
																	</div>
																	<div class="mt-55 mb-40 hidden lg:block">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Storage</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Self Service Support</span>
																			</li>
																			<li class="mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																	<a href="#contact-modal" class="btn btn-underlined border-thin text-darkpink text-13 module-btn-3" data-lity="#contact-modal">
																		<span class="btn-txt" data-text="Select Premium Plan">Select Premium Plan</span>
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div id="lqd-tab-price-annually" role="tabpanel" class="lqd-tabs-pane fade" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"x": "35px", "opacity" : 0} , "animations": {"x": "0px", "opacity" : 1}}'>
													<div class="container animation-element">
														<div class="row text-center">
															<div class="col col-12 col-md-4 col-xl-3 p-0 lg:hidden animation-element">
																<div class="flex flex-col py-50 px-20 text-start w-full">
																	<div class="lqd-imggrp-single block relative">
																		<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
																			<figure class="w-full relative">
																				<img width="272" height="192" src="./assets/images/demo/start-hub-3/3D/rocket.svg" alt="rocket">
																			</figure>
																		</div>
																	</div>
																	<div class="w-full mt-65">
																		<ul class="reset-ul icon-list-items">
																			<li class="flex items-center pb-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Hidden-4" width="25" height="25" viewbox="0 0 25 25">
																						<rect id="bound-9" width="25" height="25" fill="none"></rect>
																						<path id="Combined_Shape-13" data-name="Combined Shape" d="M.942,8.491C.625,8.491.308,8.477,0,8.45L8.45,0a19.584,19.584,0,0,1,1.867,2.242l0,.006A20.748,20.748,0,0,1,7.548,5.366C5.992,6.792,3.584,8.491.942,8.491Z" transform="translate(11.558 10.259)" fill="#737588"></path>
																						<path id="Combined_Shape-14" data-name="Combined Shape" d="M2.632,9.868h0A11.464,11.464,0,0,1,0,6.25,11.459,11.459,0,0,1,2.131,3.125,10.232,10.232,0,0,1,5.034.977,9.8,9.8,0,0,1,9.375,0a7.251,7.251,0,0,1,2.609.515L9.375,3.125A3.129,3.129,0,0,0,6.25,6.25L2.633,9.868Z" transform="translate(3.125 6.25)" fill="#737588"></path>
																						<rect id="Rectangle-6" width="19.792" height="2.083" transform="translate(5.313 19.203) rotate(-45)" fill="#737588" opacity="0.3"></rect>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Chat_3" data-name="Chat#5" width="22" height="22" viewbox="0 0 22 22">
																						<rect id="bound-10" width="22" height="22" fill="none"></rect>
																						<path id="Combined_Shape-15" data-name="Combined Shape" d="M15.875,15.852l-2.1-2.1H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H14.417a3,3,0,0,1,3,3v7.75q0,.133-.011.264L17.439,11v4.2a.916.916,0,0,1-.923.918A.9.9,0,0,1,15.875,15.852Z" transform="translate(2.75 2.75)" fill="#737588" opacity="0.3"></path>
																						<path id="Combined_Shape-16" data-name="Combined Shape" d="M10.616,3A1.447,1.447,0,0,1,9.231,1.5,1.448,1.448,0,0,1,10.616,0,1.447,1.447,0,0,1,12,1.5,1.447,1.447,0,0,1,10.616,3ZM6,3A1.447,1.447,0,0,1,4.616,1.5,1.447,1.447,0,0,1,6,0,1.448,1.448,0,0,1,7.385,1.5,1.447,1.447,0,0,1,6,3ZM1.385,3A1.447,1.447,0,0,1,0,1.5,1.448,1.448,0,0,1,1.385,0,1.447,1.447,0,0,1,2.769,1.5,1.447,1.447,0,0,1,1.385,3Z" transform="translate(5 8)" fill="#737588" opacity="0.3"></path>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" width="18" height="18.01" viewbox="0 0 18 18.01">
																						<g id="Outgoing-box-3" transform="translate(0 0.01)">
																							<rect id="bound-11" width="18" height="18" fill="none"></rect>
																							<path id="Combined_Shape-17" data-name="Combined Shape" d="M15,0V3a1.5,1.5,0,0,1-1.5,1.5H1.5A1.5,1.5,0,0,1,0,3V0H3.209l.408,1.224A1.5,1.5,0,0,0,5.041,2.25h5a1.5,1.5,0,0,0,1.342-.829L12.089,0Z" transform="translate(1.5 12.75)" fill="#737588"></path>
																							<path id="Path-1" d="M0,5.25,2.523.765A1.5,1.5,0,0,1,3.83,0h6.5a1.5,1.5,0,0,1,1.307.765L14.156,5.25h-2.49a1.5,1.5,0,0,0-1.342.829L9.615,7.5h-5L4.211,6.276A1.5,1.5,0,0,0,2.788,5.25Z" transform="translate(1.922 6)" fill="#737588" opacity="0.3"></path>
																							<path id="Shape-10" d="M2.5.09a.375.375,0,0,0-.617.286V1.843H.375A.375.375,0,0,0,0,2.218v.767a.375.375,0,0,0,.375.375H1.881V4.828a.375.375,0,0,0,.617.286L5.127,2.888a.375.375,0,0,0,0-.572Z" transform="translate(6.398 5.25) rotate(-90)" fill="#737588"></path>
																						</g>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Automate All Contracts</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Hidden-5" width="25" height="25" viewbox="0 0 25 25">
																						<rect id="bound-12" width="25" height="25" fill="none"></rect>
																						<path id="Combined_Shape-18" data-name="Combined Shape" d="M.942,8.491C.625,8.491.308,8.477,0,8.45L8.45,0a19.584,19.584,0,0,1,1.867,2.242l0,.006A20.748,20.748,0,0,1,7.548,5.366C5.992,6.792,3.584,8.491.942,8.491Z" transform="translate(11.558 10.259)" fill="#737588"></path>
																						<path id="Combined_Shape-19" data-name="Combined Shape" d="M2.632,9.868h0A11.464,11.464,0,0,1,0,6.25,11.459,11.459,0,0,1,2.131,3.125,10.232,10.232,0,0,1,5.034.977,9.8,9.8,0,0,1,9.375,0a7.251,7.251,0,0,1,2.609.515L9.375,3.125A3.129,3.129,0,0,0,6.25,6.25L2.633,9.868Z" transform="translate(3.125 6.25)" fill="#737588"></path>
																						<rect id="Rectangle-1" width="19.792" height="2.083" transform="translate(5.313 19.203) rotate(-45)" fill="#737588" opacity="0.3"></rect>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Chat_4" data-name="Chat#5" width="22" height="22" viewbox="0 0 22 22">
																						<rect id="bound-13" width="22" height="22" fill="none"></rect>
																						<path id="Combined_Shape-20" data-name="Combined Shape" d="M15.875,15.852l-2.1-2.1H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H14.417a3,3,0,0,1,3,3v7.75q0,.133-.011.264L17.439,11v4.2a.916.916,0,0,1-.923.918A.9.9,0,0,1,15.875,15.852Z" transform="translate(2.75 2.75)" fill="#737588" opacity="0.3"></path>
																						<path id="Combined_Shape-21" data-name="Combined Shape" d="M10.616,3A1.447,1.447,0,0,1,9.231,1.5,1.448,1.448,0,0,1,10.616,0,1.447,1.447,0,0,1,12,1.5,1.447,1.447,0,0,1,10.616,3ZM6,3A1.447,1.447,0,0,1,4.616,1.5,1.447,1.447,0,0,1,6,0,1.448,1.448,0,0,1,7.385,1.5,1.447,1.447,0,0,1,6,3ZM1.385,3A1.447,1.447,0,0,1,0,1.5,1.448,1.448,0,0,1,1.385,0,1.447,1.447,0,0,1,2.769,1.5,1.447,1.447,0,0,1,1.385,3Z" transform="translate(5 8)" fill="#737588" opacity="0.3"></path>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="flex items-center pb-15 mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" width="18" height="18.01" viewbox="0 0 18 18.01">
																						<g id="Outgoing-box-4" transform="translate(0 0.01)">
																							<rect id="bound-14" width="18" height="18" fill="none"></rect>
																							<path id="Combined_Shape-22" data-name="Combined Shape" d="M15,0V3a1.5,1.5,0,0,1-1.5,1.5H1.5A1.5,1.5,0,0,1,0,3V0H3.209l.408,1.224A1.5,1.5,0,0,0,5.041,2.25h5a1.5,1.5,0,0,0,1.342-.829L12.089,0Z" transform="translate(1.5 12.75)" fill="#737588"></path>
																							<path id="Path-2" d="M0,5.25,2.523.765A1.5,1.5,0,0,1,3.83,0h6.5a1.5,1.5,0,0,1,1.307.765L14.156,5.25h-2.49a1.5,1.5,0,0,0-1.342.829L9.615,7.5h-5L4.211,6.276A1.5,1.5,0,0,0,2.788,5.25Z" transform="translate(1.922 6)" fill="#737588" opacity="0.3"></path>
																							<path id="Shape-11" d="M2.5.09a.375.375,0,0,0-.617.286V1.843H.375A.375.375,0,0,0,0,2.218v.767a.375.375,0,0,0,.375.375H1.881V4.828a.375.375,0,0,0,.617.286L5.127,2.888a.375.375,0,0,0,0-.572Z" transform="translate(6.398 5.25) rotate(-90)" fill="#737588"></path>
																						</g>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Self Service Support</span>
																			</li>
																			<li class="flex items-center mt-15 icon-list-item">
																				<span class="icon-list-icon flex">
																					<svg class="mr-5 w-25 h-25" xmlns="http://www.w3.org/2000/svg" id="Hidden-6" width="25" height="25" viewbox="0 0 25 25">
																						<rect id="bound-15" width="25" height="25" fill="none"></rect>
																						<path id="Combined_Shape-23" data-name="Combined Shape" d="M.942,8.491C.625,8.491.308,8.477,0,8.45L8.45,0a19.584,19.584,0,0,1,1.867,2.242l0,.006A20.748,20.748,0,0,1,7.548,5.366C5.992,6.792,3.584,8.491.942,8.491Z" transform="translate(11.558 10.259)" fill="#737588"></path>
																						<path id="Combined_Shape-24" data-name="Combined Shape" d="M2.632,9.868h0A11.464,11.464,0,0,1,0,6.25,11.459,11.459,0,0,1,2.131,3.125,10.232,10.232,0,0,1,5.034.977,9.8,9.8,0,0,1,9.375,0a7.251,7.251,0,0,1,2.609.515L9.375,3.125A3.129,3.129,0,0,0,6.25,6.25L2.633,9.868Z" transform="translate(3.125 6.25)" fill="#737588"></path>
																						<rect id="Rectangle-2" width="19.792" height="2.083" transform="translate(5.313 19.203) rotate(-45)" fill="#737588" opacity="0.3"></rect>
																					</svg>
																				</span>
																				<span class="pl-15 icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																</div>
															</div>
															<div class="col col-12 col-md-4 col-xl-3 p-0 animation-element">
																<div class="flex flex-col items-center w-full py-50 px-20">
																	<div class="mb-20 rounded-100 bg-black-10 w-auto ld-fancy-heading relative">
																		<p class="text-10 font-semibold tracking-1 m-0 px-15 text-black uppercase ld-fh-element relative">Simple plan</p>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<h2 class="m-0 ld-fh-element relative">Free<span class="text-14 font-normal">/yr</span></h2>
																	</div>
																	<div class="py-15 w-full divider">
																		<span class="divider-separator"></span>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<p class="text-14 ld-fh-element mb-0/5em inline-block relative">Use customer data to build great and solid product experiences that convert.</p>
																	</div>
																	<div class="w-full text-center mt-55 mb-40 lg:hidden">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">100GB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																		</ul>
																	</div>
																	<div class="mt-55 mb-40 hidden lg:block">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">100GB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Self Service Support</span>
																			</li>
																			<li class="mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																	<a href="#" class="btn btn-underlined border-thin text-green-500 text-13 module-btn-1">
																		<span class="btn-txt" data-text="Select Free Plan">Select Free Plan</span>
																	</a>
																</div>
															</div>
															<div class="col col-12 col-md-4 col-xl-3 p-0 animation-element">
																<div class="flex flex-col items-center relative py-50 px-20 bg-lightgray transition-all rounded-12">
																	<div class="badge-lqd-shape absolute z-0 -top-70 lg:hidden">
																		<div class="lqd-imggrp-single block relative">
																			<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
																				<figure class="w-full relative">
																					<img width="62" height="62" src="./assets/images/demo/start-hub-3/3D/badge.svg" alt="badge shape">
																				</figure>
																			</div>
																		</div>
																	</div>
																	<div class="badge-text absolute -top-55 sm:hidden">
																		<div class="ld-fancy-heading relative">
																			<span class="text-white text-14 leading-1em m-0 ld-fh-element relative">20%<br>OFF</span>
																		</div>
																	</div>
																	<div class="mb-20 rounded-100 bg-black-10 w-auto ld-fancy-heading relative">
																		<p class="text-10 font-semibold tracking-1 m-0 px-15 text-black uppercase ld-fh-element relative">Popular plan</p>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<h2 class="m-0 ld-fh-element relative">€85<span style="font-size:15px;font-weight:normal">/yr</span></h2>
																	</div>
																	<div class="py-15 w-full divider">
																		<span class="divider-separator"></span>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<p class="text-14 ld-fh-element mb-0/5em inline-block relative">Use customer data to build great and solid product experiences that convert.</p>
																	</div>
																	<div class="w-full text-center mt-55 mb-40 lg:hidden">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">1TB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																		</ul>
																	</div>
																	<div class="mt-55 mb-40 hidden lg:block">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">1TB Storage</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Self Service Support</span>
																			</li>
																			<li class="mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																	<a href="#" class="btn btn-underlined border-thin text-gradient-start text-13 module-btn-2">
																		<span class="btn-txt" data-text="Select Popular Plan">Select Popular Plan</span>
																	</a>
																</div>
															</div>
															<div class="col col-12 col-md-4 col-xl-3 p-0 animation-element">
																<div class="flex flex-col items-center w-full py-50 px-20">
																	<div class="mb-20 rounded-100 bg-black-10 w-auto ld-fancy-heading relative">
																		<p class="text-10 font-semibold tracking-1 m-0 px-15 text-black uppercase ld-fh-element relative">Premium plan</p>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<h2 class="m-0 ld-fh-element relative">€23<span style="font-size:15px;font-weight:normal">/yr</span></h2>
																	</div>
																	<div class="py-15 w-full divider">
																		<span class="divider-separator"></span>
																	</div>
																	<div class="ld-fancy-heading relative">
																		<p class="text-14 ld-fh-element mb-0/5em inline-block relative">Use customer data to build great and solid product experiences that convert.</p>
																	</div>
																	<div class="w-full text-center mt-55 mb-40 lg:hidden">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Storage</span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="pb-20 mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																			<li class="mt-20 flex justify-center text-green-500 icon-list-item">
																				<span class="icon-list-icon flex">
																					<i aria-hidden="true" class="lqd-icn-ess icon-ion-ios-checkmark text-15"></i>
																				</span>
																				<span class="icon-list-text"></span>
																			</li>
																		</ul>
																	</div>
																	<div class="mt-55 mb-40 hidden lg:block">
																		<ul class="icon-list-items reset-ul">
																			<li class="pb-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Photos and Videos</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">99.9 Uptime Guarantee</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Unlimited Storage</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Extended Documentation</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Full Service Payroll</span>
																			</li>
																			<li class="pb-20 mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Self Service Support</span>
																			</li>
																			<li class="mt-20 text-black icon-list-item">
																				<span class="icon-list-text">Encryption for messages</span>
																			</li>
																		</ul>
																	</div>
																	<a href="#" class="btn btn-underlined border-thin text-darkpink text-13 module-btn-3">
																		<span class="btn-txt" data-text="Select Premium Plan">Select Premium Plan</span>
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col col-12 pt-50">
										<div class="flex flex-wrap items-center justify-center">
											<div class="mr-25 px-15 rounded-100 bg-purple-100 ld-fancy-heading relative">
												<p class="m-0 text-14 font-normal text-purple-500 ld-fh-element relative">Contact</p>
											</div>
											<div class="ld-fancy-heading relative">
												<p class="m-0 text-15 ld-fh-element relative">Looking for a corporate solution? <a href="#" class="underline">Contact us.</a></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section> -->
					<!-- End Pricing -->

					<!-- Start Testimonials -->
					<section class="lqd-section testimonials bg-tarnsparent pb-50 pt-50 lg:pt-0" id="testimonials" style="background-image: linear-gradient(180deg, #FFEEDE 50%, #fff 100%);">
						<div class="lqd-shape lqd-shape-top" data-negative="false">
							<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 1000 100" preserveaspectratio="none">
								<path class="lqd-shape-fill" d="M738,99l262-93V0H0v5.6L738,99z" fill="#fff"></path>
							</svg>
						</div>
						<div class="container module-slider">
							<div class="row">
								<div class="col col-12 text-center">
									<div class="carousel-container relative carousel-nav-center carousel-nav-lg carousel-nav-circle carousel-nav-center carousel-nav-floated carousel-nav-middle carousel-nav-middlecarousel-dots-mobile-outside carousel-dots-mobile-center">
										<div class="carousel-items relative" data-lqd-flickity='{"prevNextButtons": true, "wrapAround": true, "groupCells": true, "cellAlign": "left", "buttonsAppendTo": "self", "addSlideNumbersToArrows": false, "pageDots": false}'>
											<div class="flickity-viewport relative w-full overflow-hidden">
												<div class="flickity-slider flex w-full h-full relative items-start">
													<div class="carousel-item flex flex-col justify-center">
														<div class="carousel-item-inner relative w-full">
															<div class="text-20 font-medium leading-20 text-center carousel-item-content relative w-full">
																<img src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/testimonials/testi-img-e1636971534166.png')}}" alt="testimonial" width="100" height="121">
																<p class="mt-2em text-black">Thanks to 24Flights flight booking app, planning my travel has become a breeze. The app's user-friendly and allowed me to effortlessly search, compare prices, and secure the best deals, all within minutes.</p>
																<h6 class="text-purple-400 text-13">Aditya Kuna, Civil Engineer, Dubai</h6>
															</div>
														</div>
													</div>
													<div class="carousel-item flex flex-col justify-center">
														<div class="carousel-item-inner relative w-full">
															<div class="text-20 font-medium leading-20 text-center carousel-item-content relative w-full">
																<img src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/testimonials/testi-img-e1636971534166.png')}}" alt="testimonial" width="100" height="121">
																<p class="mt-2em text-black">This app has truly transformed the way I travel – convenience, efficiency, and endless possibilities all in one place. Highly recommended to fellow adventurers!</p>
																<h6 class="text-purple-400 text-13">Allam Mohd, Product Designer, Egypt</h6>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="absolute w-auto top-0 sm:hidden module-shape-1">
							<div class="lqd-imggrp-single block relative" data-float="ease">
								<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
									<figure class="w-full relative">
										<img width="250" height="276" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/human.svg')}}" alt="">
									</figure>
								</div>
							</div>
						</div>
						<div class="absolute w-100 top-50percent sm:hidden module-shape-2">
							<div class="lqd-imggrp-single block relative">
								<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
									<figure class="w-full relative">
										<img width="100" height="424" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/prism.png')}}" alt="">
									</figure>
								</div>
							</div>
						</div>
						<div class="absolute w-70 top-60percent sm:hidden module-shape-3">
							<div class="lqd-imggrp-single block relative" data-float="ease">
								<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
									<figure class="w-full relative">
										<img width="70" height="70" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/hand.png')}}" alt="">
									</figure>
								</div>
							</div>
						</div>
						<div class="absolute w-100 top-60 ltr-right-0 sm:hidden module-shape-4">
							<div class="lqd-imggrp-single block relative">
								<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
									<figure class="w-full relative">
										<img width="100" height="100" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/3D/cube.png')}}" alt="">
									</figure>
								</div>
							</div>
						</div>
						<section class="lqd-section w-full mt-100 lg:hidden">
							<div class="container">
								<div class="row items-center text-center">
									<div class="col col-2">
										<div class="lqd-imggrp-single block relative">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="111" height="33" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Jazeera-1-2.svg')}}" alt="client">
												</figure>
											</div>
										</div>
									</div>
									<div class="col col-2">
										<div class="lqd-imggrp-single block relative">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="65" height="23" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Qatar Airways.svg')}}" alt="client">
												</figure>
											</div>
										</div>
									</div>
									<div class="col col-2">
										<div class="lqd-imggrp-single block relative">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="75" height="17" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Emirates Logo.svg')}}" alt="client">
												</figure>
											</div>
										</div>
									</div>
									<div class="col col-2">
										<div class="lqd-imggrp-single block relative">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="74" height="59" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/FlyDubai.svg')}}" alt="client">
												</figure>
											</div>
										</div>
									</div>
									<div class="col col-2">
										<div class="lqd-imggrp-single block relative">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="85" height="25" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/KuwaitAirways.svg')}}" alt="client">
												</figure>
											</div>
										</div>
									</div>
									<div class="col col-2">
										<div class="lqd-imggrp-single block relative">
											<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
												<figure class="w-full relative">
													<img width="74" height="36" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Turkish_airlines.svg')}}" alt="client">
												</figure>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
					</section>
					<!-- End Testimonials -->

					<!-- Start Faq -->
					<!-- <section class="lqd-section faq bg-white transition-all pt-50 pb-90" id="faq">
						<div class="container">
							<div class="row">
								<div class="col col-12 text-center">
									<div class="mb-25 lqd-imggrp-single block relative">
										<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
											<figure class="w-full relative">
												<img width="54" height="54" src="./assets/images/demo/start-hub-3/3D/Message-1.svg" alt="message icon">
											</figure>
										</div>
									</div>
									<div class="ld-fancy-heading relative">
										<h2 class="ld-fh-element mb-0/5em inline-block relative text-slate-600">Frequently Asked Questions</h2>
									</div>
									<div class="ld-fancy-heading relative">
										<p class="ld-fh-element mb-0/5em inline-block relative text-18 text-text">Use customer data to build great and solid product experiences that convert.</p>
									</div>
								</div>
								<div class="col col-12 p-0">
									<section class="lqd-section mt-60">
										<div class="container">
											<div class="row">
												<div class="col col-12 col-md-6 p-30">
													<div class="accordion accordion-md accordion-side-spacing accordion-title-circle accordion-expander-lg accordion-active-has-shadow accordion-active-has-fill" id="accordion-question-parent-1" role="tablist" aria-multiselectable="true">
														<div class="accordion-item panel mb-20 active">
															<div class="accordion-heading" role="tab" id="heading-tab-1">
																<h4 class="accordion-title">
																	<a class="collapsed text-16 leading-2em bg-gray-100 " role="button" data-bs-toggle="collapse" href="#collapse-question-tab-1" aria-expanded="true" aria-controls="collapse-question-tab-1">
																		<span class="accordion-title-txt">End-to-end encryption for iOS Devices</span>
																		<span class="text-22 text-brown-500 accordion-expander">
																			<i class="lqd-icn-ess icon-ion-ios-add"></i>
																			<i class="lqd-icn-ess icon-ion-ios-remove"></i>
																		</span>
																	</a>
																</h4>
															</div>
															<div id="collapse-question-tab-1" class="accordion-collapse collapse show" role="tabpanel" aria-labelledby="heading-tab-1" data-bs-parent="#accordion-question-parent-1">
																<div class="text-15 accordion-content">Content-focused grid designs, unique social elements, post-sharing function, author exposure, sticky newsletter. </div>
															</div>
														</div>
														<div class="accordion-item panel mb-20">
															<div class="accordion-heading" role="tab" id="heading-tab-2">
																<h4 class="accordion-title">
																	<a class="collapsed text-16 leading-2em bg-gray-100 " role="button" data-bs-toggle="collapse" href="#collapse-question-tab-2" aria-expanded="false" aria-controls="collapse-question-tab-2">
																		<span class="accordion-title-txt">Sending media, location and contacts</span>
																		<span class="text-22 text-brown-500 accordion-expander">
																			<i class="lqd-icn-ess icon-ion-ios-add"></i>
																			<i class="lqd-icn-ess icon-ion-ios-remove"></i>
																		</span>
																	</a>
																</h4>
															</div>
															<div id="collapse-question-tab-2" class="accordion-collapse collapse " role="tabpanel" aria-labelledby="heading-tab-2" data-bs-parent="#accordion-question-parent-1">
																<div class="text-15 accordion-content">Content-focused grid designs, unique social elements, post-sharing function, author exposure, sticky newsletter. </div>
															</div>
														</div>
														<div class="accordion-item panel mb-20">
															<div class="accordion-heading" role="tab" id="heading-tab-3">
																<h4 class="accordion-title">
																	<a class="collapsed text-16 leading-2em bg-gray-100 " role="button" data-bs-toggle="collapse" href="#collapse-question-tab-3" aria-expanded="false" aria-controls="collapse-question-tab-3">
																		<span class="accordion-title-txt">Get insights on key metrics time</span>
																		<span class="text-22 text-brown-500 accordion-expander">
																			<i class="lqd-icn-ess icon-ion-ios-add"></i>
																			<i class="lqd-icn-ess icon-ion-ios-remove"></i>
																		</span>
																	</a>
																</h4>
															</div>
															<div id="collapse-question-tab-3" class="accordion-collapse collapse " role="tabpanel" aria-labelledby="heading-tab-3" data-bs-parent="#accordion-question-parent-1">
																<div class="text-15 accordion-content">Content-focused grid designs, unique social elements, post-sharing function, author exposure, sticky newsletter. </div>
															</div>
														</div>
														<div class="accordion-item panel">
															<div class="accordion-heading" role="tab" id="heading-tab-4">
																<h4 class="accordion-title">
																	<a class="collapsed text-16 leading-2em bg-gray-100 " role="button" data-bs-toggle="collapse" href="#collapse-question-tab-4" aria-expanded="false" aria-controls="collapse-question-tab-4">
																		<span class="accordion-title-txt">Calling unavailable in some countries</span>
																		<span class="text-22 text-brown-500 accordion-expander">
																			<i class="lqd-icn-ess icon-ion-ios-add"></i>
																			<i class="lqd-icn-ess icon-ion-ios-remove"></i>
																		</span>
																	</a>
																</h4>
															</div>
															<div id="collapse-question-tab-4" class="accordion-collapse collapse " role="tabpanel" aria-labelledby="heading-tab-4" data-bs-parent="#accordion-question-parent-1">
																<div class="text-15 accordion-content">Content-focused grid designs, unique social elements, post-sharing function, author exposure, sticky newsletter. </div>
															</div>
														</div>
													</div>
												</div>
												<div class="col col-12 col-md-6 p-30">
													<div class="accordion accordion-md accordion-side-spacing accordion-title-circle accordion-expander-lg accordion-active-has-shadow accordion-active-has-fill" id="accordion-question-parent-2" role="tablist" aria-multiselectable="true">
														<div class="accordion-item panel mb-20">
															<div class="accordion-heading" role="tab" id="heading-tab-5">
																<h4 class="accordion-title">
																	<a class="collapsed text-16 leading-2em bg-gray-100 " role="button" data-bs-toggle="collapse" href="#collapse-question-tab-5" aria-expanded="false" aria-controls="collapse-question-tab-5">
																		<span class="accordion-title-txt">Google mobile can monetize your app</span>
																		<span class="text-22 text-brown-500 accordion-expander">
																			<i class="lqd-icn-ess icon-ion-ios-add"></i>
																			<i class="lqd-icn-ess icon-ion-ios-remove"></i>
																		</span>
																	</a>
																</h4>
															</div>
															<div id="collapse-question-tab-5" class="accordion-collapse collapse " role="tabpanel" aria-labelledby="heading-tab-5" data-bs-parent="#accordion-question-parent-2">
																<div class="text-15 accordion-content">Content-focused grid designs, unique social elements, post-sharing function, author exposure, sticky newsletter. </div>
															</div>
														</div>
														<div class="accordion-item panel mb-20">
															<div class="accordion-heading" role="tab" id="heading-tab-6">
																<h4 class="accordion-title">
																	<a class="collapsed text-16 leading-2em bg-gray-100 " role="button" data-bs-toggle="collapse" href="#collapse-question-tab-6" aria-expanded="false" aria-controls="collapse-question-tab-6">
																		<span class="accordion-title-txt">How to restore your chat history?</span>
																		<span class="text-22 text-brown-500 accordion-expander">
																			<i class="lqd-icn-ess icon-ion-ios-add"></i>
																			<i class="lqd-icn-ess icon-ion-ios-remove"></i>
																		</span>
																	</a>
																</h4>
															</div>
															<div id="collapse-question-tab-6" class="accordion-collapse collapse " role="tabpanel" aria-labelledby="heading-tab-6" data-bs-parent="#accordion-question-parent-2">
																<div class="text-15 accordion-content">Content-focused grid designs, unique social elements, post-sharing function, author exposure, sticky newsletter. </div>
															</div>
														</div>
														<div class="accordion-item panel">
															<div class="accordion-heading" role="tab" id="heading-tab-7">
																<h4 class="accordion-title">
																	<a class="collapsed text-16 leading-2em bg-gray-100 " role="button" data-bs-toggle="collapse" href="#collapse-question-tab-7" aria-expanded="false" aria-controls="collapse-question-tab-7">
																		<span class="accordion-title-txt">Problems sending or receiving messages</span>
																		<span class="text-22 text-brown-500 accordion-expander">
																			<i class="lqd-icn-ess icon-ion-ios-add"></i>
																			<i class="lqd-icn-ess icon-ion-ios-remove"></i>
																		</span>
																	</a>
																</h4>
															</div>
															<div id="collapse-question-tab-7" class="accordion-collapse collapse " role="tabpanel" aria-labelledby="heading-tab-7" data-bs-parent="#accordion-question-parent-2">
																<div class="text-15 accordion-content">Content-focused grid designs, unique social elements, post-sharing function, author exposure, sticky newsletter. </div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col col-12">
									<div class="flex flex-wrap justify-center items-center pt-30">
										<div class="mr-25 px-15 rounded-100 bg-brown-300 ld-fancy-heading relative">
											<p class="text-15 font-normal text-brown-500 m-0 ld-fh-element relative">Contact</p>
										</div>
										<div class="ld-fancy-heading relative">
											<p class="text-15 m-0 ld-fh-element relative">Looking for a corporate solution? <a href="#" class="underline">Contact us.</a></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Faq -->

					<!-- Start Blog -->
					<!-- <section class="lqd-section blog pb-120" style="background-image: linear-gradient(180deg, #DBE4FE 0%, #fff 20%);">
						<div class="lqd-shape lqd-shape-top" data-negative="false">
							<svg class="h-60" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 1000 100" preserveaspectratio="none" fill="#fff">
								<path class="lqd-shape-fill" d="M738,99l262-93V0H0v5.6L738,99z"></path>
							</svg>
						</div>
						<div class="container p-0">
							<div class="row m-0">
								<div class="col col-12 p-0">
									<div class="container pt-80">
										<div class="row items-center">
											<div class="col col-12 col-md-6 p-0">
												<div class="lqd-imggrp-single block relative">
													<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
														<figure class="w-full relative">
															<img width="38" height="6" src="./assets/images/demo/start-hub-3/3D/dash.svg" alt="dash shape">
														</figure>
													</div>
												</div>
												<div class="ld-fancy-heading relative">
													<h2 class="ld-fh-element mb-0/5em inline-block relative">Latest Posts</h2>
												</div>
											</div>
											<div class="col col-12 col-md-6 p-0">
												<div class="flex flex-wrap justify-center">
													<div class="iconbox flex flex-grow-0 relative items-center justify-center text-center">
														<div class="iconbox-icon-wrap mr-25">
															<div class="text-40 w-40 iconbox-icon-container inline-flex">
																<svg xmlns="http://www.w3.org/2000/svg" id="Airplane" width="47" height="47" viewbox="0 0 47 47">
																	<circle id="Oval-6" cx="23.5" cy="23.5" r="23.5" transform="translate(0 0)" fill="#bbc3ff"></circle>
																	<path id="Shape-1" d="M30.754,0,.679,13.467c-.947.424-.9.974.111,1.23L7.724,16.45l9.51,4.319L24.121,24.5a1,1,0,0,0,1.539-.707Z" transform="translate(6.376 10.81)" fill="#4451b1"></path>
																	<path id="Shape-2" data-name="Shape-2" d="M23.03,0,0,16.45l3.2,8.713a.841.841,0,0,0,1.494.333L9.51,20.769,5.985,18.788Z" transform="translate(14.1 10.81)" fill="#929bdb"></path>
																</svg>
															</div>
														</div>
														<h3 class="text-18 font-normal m-0 lqd-iconbox-heading flex-unset">
															<strong>— Book Now!</strong>&nbsp;with 24Flights.com
														</h3>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="container mt-30">
										<div class="row">
											<div class="col col-12 col-xl-6 p-0 mb-30">
												<article class="lqd-lp relative lqd-lp-hover-img-zoom text-start post type-post status-publish format-standard has-post-thumbnail hentry category-blog-single">
													<div class="lqd-lp-img overflow-hidden rounded-6 mb-2/5em">
														<figure>
															<img width="1104" height="648" src="./assets/images/demo/start-hub-3/blog/blog-image.png" alt="blog">
														</figure>
													</div>
													<header class="lqd-lp-header">
														<div class="lqd-lp-meta lqd-lp-meta-dot-between flex flex-wrap items-center font-bold uppercase tracking-0/1em">
															<span class="screen-reader-text">Tags </span>
															<ul class="lqd-lp-cat lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored reset-ul inline-ul relative z-3">
																<li>
																	<a class="module-color" href="#" rel="tag">Metrics</a>
																</li>
															</ul>
															<time class="lqd-lp-date" datetime="2021-06-02T13:40:12+00:00">1 year ago</time>
														</div>
														<h5 class="font-semibold tracking-0 entry-title lqd-lp-title mt-0/75em mb-4 text-24 font-semibold leading-26 text-black">Use customer data to build great products</h5>
													</header>
													<div class="lqd-lp-excerpt mb-2rem">
														<p>Passionate about solving problems through creative communications. Offering affordable goods.</p>
													</div>
													<footer class="lqd-lp-footer">
														<div class="lqd-lp-meta">
															<div class="lqd-lp-author inline-flex flex-wrap items-center relative z-3">
																<a href="https://starthubthree.liquid-themes.com/author/starthub/" class="lqd-overlay flex"></a>
																<figure class="rounded-full overflow-hidden">
																	<img alt="starthub" src="./assets/images/demo/start-hub-3/avatar/927bf75490757a76d572a2a6a35f120e.png" class="avatar avatar-50 photo w-full" height="50" width="50">
																</figure>
																<div class="lqd-lp-author-info ml-1/5em">
																	<h3 class="mt-0 mb-0 uppercase tracking-0/1em font-bold">starthub</h3>
																</div>
															</div>
														</div>
													</footer>
												</article>
											</div>
											<div class="col col-12 col-xl-6 p-0">
												<div class="relative flex flex-wrap flex-col pl-90 lg:pl-0">
													<article class="mb-30 border-bottom-dashed border-lightgray lqd-lp relative lqd-lp-hover-img-zoom text-start post type-post status-publish format-standard has-post-thumbnail hentry category-blog-single tag-product">
														<div class="hidden lqd-lp-img overflow-hidden rounded-6 mb-2/5em">
															<figure>
																<img width="1250" height="700" src="./assets/images/demo/start-hub-3/blog/blog-image.png" alt="blog">
															</figure>
														</div>
														<header class="lqd-lp-header">
															<div class="lqd-lp-meta lqd-lp-meta-dot-between flex flex-wrap items-center font-bold uppercase tracking-0/1em">
																<span class="screen-reader-text">Tags </span>
																<ul class="lqd-lp-cat lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored reset-ul inline-ul relative z-3">
																	<li>
																		<a class="module-color-1" href="#" rel="tag">Product</a>
																	</li>
																</ul>
																<time class="lqd-lp-date" datetime="2020-09-24T06:00:29+00:00">2 years ago</time>
															</div>
															<h5 class="font-semibold tracking-0 entry-title lqd-lp-title mt-0/75em mb-1/15em text-18 font-semibold leading-26 text-black">How to create magical digital experiences for customers</h5>
														</header>
														<footer class="hidden lqd-lp-footer">
															<div class="lqd-lp-meta">
																<div class="lqd-lp-author inline-flex flex-wrap items-center relative z-3">
																	<a href="#" class="lqd-overlay flex"></a>
																	<figure class="rounded-full overflow-hidden">
																		<img alt="starthub" src="./assets/images/demo/start-hub-3/avatar/927bf75490757a76d572a2a6a35f120e.png" class="avatar avatar-50 photo w-full" height="50" width="50">
																	</figure>
																	<div class="lqd-lp-author-info ml-1/5em">
																		<h3 class="mt-0 mb-0 uppercase tracking-0/1em font-bold">starthub</h3>
																	</div>
																</div>
															</div>
														</footer>
													</article>
													<article class="mb-30 border-bottom-dashed border-lightgray lqd-lp relative lqd-lp-hover-img-zoom text-start post type-post status-publish format-standard has-post-thumbnail hentry category-blog-single tag-office">
														<div class="hidden lqd-lp-img overflow-hidden rounded-6 mb-2/5em">
															<figure>
																<img width="1250" height="700" src="./assets/images/demo/start-hub-3/blog/blog-image.png" alt="blog">
															</figure>
														</div>
														<header class="lqd-lp-header">
															<div class="lqd-lp-meta lqd-lp-meta-dot-between flex flex-wrap items-center font-bold uppercase tracking-0/1em">
																<span class="screen-reader-text">Tags </span>
																<ul class="lqd-lp-cat lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored reset-ul inline-ul relative z-3">
																	<li>
																		<a class="module-color-2" href="#" rel="tag">Office</a>
																	</li>
																</ul>
																<time class="lqd-lp-date" datetime="2020-09-23T12:14:11+00:00">2 years ago</time>
															</div>
															<h5 class="font-semibold tracking-0 entry-title lqd-lp-title mt-0/75em mb-1/15em text-18 font-semibold leading-26 text-black">Free advertising for your online business and store</h5>
														</header>
														<footer class="hidden lqd-lp-footer">
															<div class="lqd-lp-meta">
																<div class="lqd-lp-author inline-flex flex-wrap items-center relative z-3">
																	<a href="#" class="lqd-overlay flex"></a>
																	<figure class="rounded-full overflow-hidden">
																		<img alt="starthub" src="./assets/images/demo/start-hub-3/avatar/927bf75490757a76d572a2a6a35f120e.png" class="avatar avatar-50 photo w-full" height="50" width="50">
																	</figure>
																	<div class="lqd-lp-author-info ml-1/5em">
																		<h3 class="mt-0 mb-0 uppercase tracking-0/1em font-bold">starthub</h3>
																	</div>
																</div>
															</div>
														</footer>
													</article>
													<article class="mb-30 border-bottom-dashed border-lightgray lqd-lp relative lqd-lp-hover-img-zoom text-start post type-post status-publish format-standard has-post-thumbnail hentry category-blog-single tag-travel">
														<div class="hidden lqd-lp-img overflow-hidden rounded-6 mb-2/5em">
															<figure>
																<img width="1250" height="700" src="./assets/images/demo/start-hub-3/blog/blog-image.png" alt="blog">
															</figure>
														</div>
														<header class="lqd-lp-header">
															<div class="lqd-lp-meta lqd-lp-meta-dot-between flex flex-wrap items-center font-bold uppercase tracking-0/1em">
																<span class="screen-reader-text">Tags </span>
																<ul class="lqd-lp-cat lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored reset-ul inline-ul relative z-3">
																	<li>
																		<a class="module-color-3" href="#" rel="tag">Travel</a>
																	</li>
																</ul>
																<time class="lqd-lp-date" datetime="2020-09-23T12:13:55+00:00">2 years ago</time>
															</div>
															<h5 class="font-semibold tracking-0 entry-title lqd-lp-title mt-0/75em mb-1/15em text-18 font-semibold leading-26 text-black">Secure transactions and payments for eCommerce Platforms</h5>
														</header>
														<footer class="hidden lqd-lp-footer">
															<div class="lqd-lp-meta">
																<div class="lqd-lp-author inline-flex flex-wrap items-center relative z-3">
																	<a href="#" class="lqd-overlay flex"></a>
																	<figure class="rounded-full overflow-hidden">
																		<img alt="starthub" src="./assets/images/demo/start-hub-3/avatar/927bf75490757a76d572a2a6a35f120e.png" class="avatar avatar-50 photo w-full" height="50" width="50">
																	</figure>
																	<div class="lqd-lp-author-info ml-1/5em">
																		<h3 class="mt-0 mb-0 uppercase tracking-0/1em font-bold">starthub</h3>
																	</div>
																</div>
															</div>
														</footer>
													</article>
													<article class="mb-30 lqd-lp relative lqd-lp-hover-img-zoom text-start post type-post status-publish format-standard has-post-thumbnail hentry category-blog-single tag-global">
														<div class="hidden lqd-lp-img overflow-hidden rounded-6 mb-2/5em">
															<figure>
																<img width="1250" height="700" src="./assets/images/demo/start-hub-3/blog/blog-image.png" alt="blog">
															</figure>
														</div>
														<header class="lqd-lp-header">
															<div class="lqd-lp-meta lqd-lp-meta-dot-between flex flex-wrap items-center font-bold uppercase tracking-0/1em">
																<span class="screen-reader-text">Tags </span>
																<ul class="lqd-lp-cat lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored reset-ul inline-ul relative z-3">
																	<li>
																		<a class="module-color-4" href="#" rel="tag">Global</a>
																	</li>
																</ul>
																<time class="lqd-lp-date" datetime="2020-09-22T12:12:36+00:00">2 years ago</time>
															</div>
															<h5 class="font-semibold tracking-0 entry-title lqd-lp-title mt-0/75em mb-1/15em text-18 font-semibold leading-26 text-black">Chip startup says sensors may replace buttons on phones</h5>
														</header>
														<footer class="hidden lqd-lp-footer">
															<div class="lqd-lp-meta">
																<div class="lqd-lp-author inline-flex flex-wrap items-center relative z-3">
																	<a href="#" class="lqd-overlay flex"></a>
																	<figure class="rounded-full overflow-hidden">
																		<img alt="starthub" src="./assets/images/demo/start-hub-3/avatar/927bf75490757a76d572a2a6a35f120e.png" class="avatar avatar-50 photo w-full" height="50" width="50">
																	</figure>
																	<div class="lqd-lp-author-info ml-1/5em">
																		<h3 class="mt-0 mb-0 uppercase tracking-0/1em font-bold">starthub</h3>
																	</div>
																</div>
															</div>
														</footer>
													</article>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section> -->
					<!-- End Blog -->

					<!-- Start Download -->
					<section class="lqd-section download transition-all box-shadow-bottom text-center bg-gray-700" id="download">
						<div class="w-full flex flex-wrap transition-all box-shadow-bottom rounded-25 rounded-top-0 border-top border-black-10 bg-white">
							<div class="container flex flex-wrap p-0">
								<div class="w-25percent flex p-10 border-right border-black-10 lg:w-50percent lg:border-bottom">
									<div class="py-30 iconbox flex items-center transition-all flex-grow-1 relative flex-col iconbox-default">
										<div class="iconbox-icon-wrap">
											<div class="iconbox-icon-container inline-flex mb-25 text-74 text-slate-400">
												<svg class="w-1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
													<path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z" />
												</svg>
											</div>
										</div>
									 
										<div class="contents">
											<h3 class="text-15 font-medium leading-20 mb-10 lqd-iconbox-heading">Visit Facebook </h3>
											<p class="text-14"><a href="https://www.facebook.com/24Flights" target="_blank">Follow Us on Facebook</a></p>
										</div>
									</div>
								</div>
								<div class="w-25percent flex p-10 border-right border-black-10 lg:w-50percent lg:border-bottom lg:border-right-0">
									<div class="py-30 iconbox flex items-center transition-all flex-grow-1 relative flex-col iconbox-default">
										<div class="iconbox-icon-wrap">
											<div class="iconbox-icon-container inline-flex mb-25 text-74 text-slate-400">
												<svg class="w-1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
													<path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
												</svg>
											</div>
										</div>
									 
										<div class="contents">
											<h3 class="text-15 font-medium leading-20 mb-10 lqd-iconbox-heading">Visit Instagram </h3>
											<p class="text-14"><a href="https://www.instagram.com/24_flights/" target="_blank">Follow Us on Instagram</a></p>
										</div>

									</div>
								</div>
								<div class="w-25percent flex p-10 border-right border-black-10 lg:border-bottom lg:w-50percent">
									<div class="py-30 iconbox flex items-center transition-all flex-grow-1 relative flex-col iconbox-default">
										<div class="iconbox-icon-wrap">
											<div class="iconbox-icon-container inline-flex mb-25 text-74 text-slate-400">
												<svg class="w-1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
													<path d="M255.9 120.9l9.1-15.7c5.6-9.8 18.1-13.1 27.9-7.5 9.8 5.6 13.1 18.1 7.5 27.9l-87.5 151.5h63.3c20.5 0 32 24.1 23.1 40.8H113.8c-11.3 0-20.4-9.1-20.4-20.4 0-11.3 9.1-20.4 20.4-20.4h52l66.6-115.4-20.8-36.1c-5.6-9.8-2.3-22.2 7.5-27.9 9.8-5.6 22.2-2.3 27.9 7.5l8.9 15.7zm-78.7 218l-19.6 34c-5.6 9.8-18.1 13.1-27.9 7.5-9.8-5.6-13.1-18.1-7.5-27.9l14.6-25.2c16.4-5.1 29.8-1.2 40.4 11.6zm168.9-61.7h53.1c11.3 0 20.4 9.1 20.4 20.4 0 11.3-9.1 20.4-20.4 20.4h-29.5l19.9 34.5c5.6 9.8 2.3 22.2-7.5 27.9-9.8 5.6-22.2 2.3-27.9-7.5-33.5-58.1-58.7-101.6-75.4-130.6-17.1-29.5-4.9-59.1 7.2-69.1 13.4 23 33.4 57.7 60.1 104zM256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm216 248c0 118.7-96.1 216-216 216-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216z" />
												</svg>
											</div>
										</div>
										<div class="contents">
											<h3 class="text-15 font-medium leading-20 mb-10 lqd-iconbox-heading">Visit App Store </h3>
											<p class="text-14"><a href="https://apps.apple.com/kw/app/24-flights/id1466042184" target="_blank">Download for iOS Devices</a></p>
										</div>
									</div>
								</div>
								<div class="w-25percent flex p-10 lg:w-50percent">
									<div class="py-30 iconbox flex items-center transition-all flex-grow-1 relative flex-col iconbox-default">
										<div class="iconbox-icon-wrap">
											<div class="iconbox-icon-container inline-flex mb-25 text-74 text-slate-400">
												<svg id="changeColor" fill="#DC7633" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="72" zoomAndPan="magnify" viewBox="0 0 375 374.9999" height="72" version="1.0"><defs><path id="pathAttribute" d="M 11.972656 11.972656 L 359.222656 11.972656 L 359.222656 359.222656 L 11.972656 359.222656 Z M 11.972656 11.972656 " stroke="#878282" fill="#737373" stroke-width="10"></path></defs><g><path id="pathAttribute" d="M 185.597656 359.222656 C 89.675781 359.222656 11.972656 280.984375 11.972656 185.597656 C 11.972656 90.210938 89.675781 11.972656 185.597656 11.972656 C 281.519531 11.972656 359.222656 89.675781 359.222656 185.597656 C 359.222656 281.519531 280.984375 359.222656 185.597656 359.222656 Z M 185.597656 22.691406 C 95.570312 22.691406 22.691406 95.570312 22.691406 185.597656 C 22.691406 275.625 95.570312 348.503906 185.597656 348.503906 C 275.625 348.503906 348.503906 275.625 348.503906 185.597656 C 348.503906 95.570312 275.089844 22.691406 185.597656 22.691406 Z M 185.597656 22.691406 " fill-opacity="1" fill-rule="nonzero" stroke="#878282" fill="#737373" stroke-width="10"></path></g><g id="inner-icon" transform="translate(85, 75)"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" id="IconChangeColor" height="239" width="239"><rect width="256" height="256" fill="none"></rect><path d="M223.6,114.2,55.9,18.1a16.2,16.2,0,0,0-16.2.1,15.8,15.8,0,0,0-7.9,13.7V224.1a16,16,0,0,0,16,15.9,16.9,16.9,0,0,0,8.1-2.1l167.7-96.1a15.7,15.7,0,0,0,0-27.6ZM144,139.3l18.9,18.9L74.7,208.6Zm-69.3-92,88.2,50.5L144,116.7ZM177.2,149.9,155.3,128l21.9-21.9L215.6,128Z" id="mainIconPathAttribute" fill="#737373" stroke-width="0" stroke="#ff0000"></path></svg> </g></svg>
											</div>
										</div>
										<div class="contents">
											<h3 class="text-15 font-medium leading-20 mb-10 lqd-iconbox-heading">Visit Play Store </h3>
											<p class="text-14"><a href="https://play.google.com/store/apps/details?id=com.ni.tfflights" target="_blank">Download for Android</a></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Download -->

				</div>
			</main>

			<footer id="site-footer" class="main-footer bg-transparent text-white" style="background-image: linear-gradient(120deg, #323945 78%, #514A65 100%);">
				<div class="transition-all bg-cover pt-120 pb-70 module-bg" style="background-image: url('{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/footer/footer-bg-shapes.svg') }}');">

					<div class="container">
						<div class="row">
							<div class="col col-12 p-0">
								<section class="lqd-section footer-content flex flex-wrap items-start">
									<div class="w-50percent flex p-10 lg:w-full" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "opacity" : 0} , "animations": {"y": "0px", "opacity" : 1}}'>
										<div class="w-full flex flex-col mr-60 sm:mr-0">
											<div class="ld-fancy-heading relative animation-element">
												<h2 class="text-46 leading-1em mb-60 tracking-0 text-white ld-fh-element relative lqd-highlight-custom lqd-highlight-custom-2" data-inview="true" data-transition-delay="true" data-delay-options=' {"elements": ".lqd-highlight-inner", "delayType": "transition"}'>
													<span>Sign Up 24Flights get a special</span>
													<mark class="lqd-highlight">
														<span class="lqd-highlight-txt">discount.</span>
														<span class="left-0 -bottom-20 lqd-highlight-inner">
															<svg class="lqd-highlight-pen" width="51" height="51" viewbox="0 0 51 51" xmlns="http://www.w3.org/2000/svg">
																<path d="M36.204 1.044C32.02 2.814 5.66 31.155 4.514 35.116c-.632 2.182-1.75 5.516-2.483 7.409-3.024 7.805-1.54 9.29 6.265 6.265 1.893-.733 5.227-1.848 7.41-2.477 3.834-1.105 4.473-1.647 19.175-16.27 0 0 10.63-10.546 15.21-15.125C53 8.997 42.021-1.418 36.203 1.044Zm7.263 5.369c3.56 3.28 4.114 4.749 2.643 6.995l-1.115 1.7-4.586-4.543-4.585-4.544 1.42-1.157C39.311 3.18 40.2 3.4 43.467 6.413ZM37.863 13.3l4.266 4.304-11.547 11.561-11.547 11.561-4.48-4.446-4.481-4.447 11.404-11.418c6.273-6.28 11.566-11.42 11.762-11.42.197 0 2.277 1.938 4.623 4.305ZM12.016 39.03l3.54 3.584-3.562 1.098-5.316 1.641c-1.665.516-1.727.455-1.211-1.21l1.614-5.226c1.289-4.177.685-4.191 4.935.113Z"></path>
															</svg>
															<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-2" width="233" height="13" viewbox="0 0 233 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveaspectratio="none">
																<path d="m.624 9.414-.312-2.48C0 4.454.001 4.454.002 4.454l.035-.005.102-.013.398-.047c.351-.042.872-.102 1.557-.179 1.37-.152 3.401-.368 6.05-.622C13.44 3.081 21.212 2.42 31.13 1.804 50.966.572 79.394-.48 113.797.24c34.387.717 63.927 2.663 84.874 4.429a1048.61 1048.61 0 0 1 24.513 2.34 641.605 641.605 0 0 1 8.243.944l.432.054.149.02-.318 2.479-.319 2.48-.137-.018c-.094-.012-.234-.03-.421-.052a634.593 634.593 0 0 0-8.167-.936 1043.26 1043.26 0 0 0-24.395-2.329c-20.864-1.76-50.296-3.697-84.558-4.413-34.246-.714-62.535.332-82.253 1.556-9.859.612-17.574 1.269-22.82 1.772-2.622.251-4.627.464-5.973.614a213.493 213.493 0 0 0-1.901.22l-.094.01-.028.004Z" fill="#49C193"></path>
															</svg>
														</span>
													</mark>
												</h2>
											</div>
											<a href="{{url('/')}}" class="btn btn-solid btn-hover-txt-liquid-y btn-custom-size btn-icon-right btn-hover-swp bg-white text-accent rounded-6 text-13 w-240 h-55 animation-element" data-lity="#contact-modal">
												<span class="btn-txt" data-text="Join the Community" data-split-text="true" data-split-options='{"type":  "chars, words"}'>Sign Up & Book Now</span>
												<span class="btn-icon tex-18">
													<i aria-hidden="true" class="lqd-icn-ess icon-md-arrow-forward"></i>
												</span>
												<span class="btn-icon mr-10 tex-18">
													<i aria-hidden="true" class="lqd-icn-ess icon-md-arrow-forward"></i>
												</span>
											</a>
											<!-- <div class="w-full flex items-center justify-between mt-40">
												<div class="lqd-imggrp-single flex flex-grow-1 relative w-33percent sm:justify-start">
													<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
														<figure class="w-full relative animation-element">
															<img width="101" height="30" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Jazeera-1-2.svg')}}" alt="footer clients">
														</figure>
													</div>
												</div>
												<div class="lqd-imggrp-single flex flex-grow-1 relative w-33percent sm:justify-center">
													<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
														<figure class="w-full relative animation-element">
															<img width="60" height="21" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Qatar Airways.svg') }}" alt="footer clients">
														</figure>
													</div>
												</div>
												<div class="lqd-imggrp-single flex flex-grow-1 relative w-33percent sm:justify-end">
													<div class="lqd-imggrp-img-container inline-flex relative items-center justify-center">
														<figure class="w-full relative animation-element">
															<img width="69" height="16" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/clients/Emirates Logo.svg') }}" alt="footer clients">
														</figure>
													</div>
												</div>
											</div> -->
										</div>
									</div>
									<div class="w-50percent flex flex-col p-10 lg:w-full module-last">
										<div class="flex flex-wrap flex-col ml-200 lg:ml-0">
											<div data-custom-animations="true" data-ca-options='{"animationTarget": ".iconbox", "startDelay" : 1000, "ease": "power4.out", "initValues": {"opacity" : 0} , "animations": {"opacity" : 1}}'>
												<div class="iconbox flex flex-grow-1 relative flex-wrap items-center iconbox-inline iconbox-square mb-10 text-start">
													<div class="iconbox-icon-wrap mr-15">
														<div class="iconbox-icon-container inline-flex relative z-1 w-45 h-45 text-18 rounded-6 text-white module-icon-bg-1">
															<i aria-hidden="true" class="text-white-20 lqd-icn-ess icon-ion-ios-checkmark"></i>
														</div>
													</div>
													<h3 class="lqd-iconbox-heading text-17 font-medium leading-30 tracking-0 m-0 text-white-20">Download Tickets on Mobile. </h3>
												</div>
											</div>
											<div data-custom-animations="true" data-ca-options='{"animationTarget": ".iconbox", "startDelay" : 700, "ease": "power4.out", "initValues": {"opacity" : 0} , "animations": {"opacity" : 1}}'>
												<div class="iconbox flex flex-grow-1 relative flex-wrap items-center iconbox-inline iconbox-square mb-10 text-start">
													<div class="iconbox-icon-wrap mr-15">
														<div class="iconbox-icon-container inline-flex relative z-1 w-45 h-45 text-18 rounded-6 text-white module-icon-bg-2">
															<i aria-hidden="true" class="text-white-50 lqd-icn-ess icon-ion-ios-checkmark"></i>
														</div>
													</div>
													<h3 class="lqd-iconbox-heading text-17 font-medium leading-30 tracking-0 m-0 text-white-50">Real-time Flight Status. </h3>
												</div>
											</div>
											<div data-custom-animations="true" data-ca-options='{"animationTarget": ".iconbox", "startDelay" : 300, "ease": "power4.out", "initValues": {"opacity" : 0} , "animations": {"opacity" : 1}}'>
												<div class="iconbox flex flex-grow-1 relative flex-wrap items-center iconbox-inline iconbox-square mb-10 text-start">
													<div class="iconbox-icon-wrap mr-15">
														<div class="iconbox-icon-container inline-flex relative z-1 w-45 h-45 text-18 rounded-6 text-white module-icon-bg-3">
															<i aria-hidden="true" class="text-white lqd-icn-ess icon-ion-ios-checkmark"></i>
														</div>
													</div>
													<h3 class="lqd-iconbox-heading text-17 font-medium leading-30 tracking-0 m-0 text-white">Secure online payments. </h3>
												</div>
											</div>
											<div data-custom-animations="true" data-ca-options='{"animationTarget": ".iconbox", "startDelay" : 700, "ease": "power4.out", "initValues": {"opacity" : 0} , "animations": {"opacity" : 1}}'>
												<div class="iconbox flex flex-grow-1 relative flex-wrap items-center iconbox-inline iconbox-square mb-10 text-start">
													<div class="iconbox-icon-wrap mr-15">
														<div class="iconbox-icon-container inline-flex relative z-1 w-45 h-45 text-18 rounded-6 text-white module-icon-bg-4">
															<i aria-hidden="true" class="text-white-50 lqd-icn-ess icon-ion-ios-checkmark"></i>
														</div>
													</div>
													<h3 class="lqd-iconbox-heading text-17 font-medium leading-30 tracking-0 m-0 text-white-50">Awesome Offers. </h3>
												</div>
											</div>
											<div data-custom-animations="true" data-ca-options='{"animationTarget": ".iconbox", "startDelay" : 1000, "ease": "power4.out", "initValues": {"opacity" : 0} , "animations": {"opacity" : 1}}'>
												<div class="iconbox flex flex-grow-1 relative flex-wrap items-center iconbox-inline iconbox-square mb-10 text-start">
													<div class="iconbox-icon-wrap mr-15">
														<div class="iconbox-icon-container inline-flex relative z-1 w-45 h-45 text-18 rounded-6 text-white module-icon-bg-5">
															<i aria-hidden="true" class="text-white-20 lqd-icn-ess icon-ion-ios-checkmark"></i>
														</div>
													</div>
													<h3 class="lqd-iconbox-heading text-17 font-medium leading-30 tracking-0 m-0 text-white-20">24/7 Customer Service. </h3>
												</div>
											</div>
										</div>
									</div>
								</section>
								<section class="lqd-section footer-line flex flex-wrap items-center border-bottom border-white-10 transition-all pt-30 pb-10">
								    <div class="w-full flex flex-col p-10">
								        <div class="ld-fancy-heading relative">
								            <p style="color: white;" class="text-14 font-semibold text-text ld-fh-element mb-0/5em inline-block relative">Trusted by</p>

								             <img src="{{ asset('frontEnd/flightBookPage/assets/images/trustedBy/civil_aviation.svg')}}" alt="Civil Aviation" class="w-16 h-16 mx-2" style="width: 70px; height: 70px;" />
								            <img src="{{ asset('frontEnd/flightBookPage/assets/images/trustedBy/IATA_logo.svg')}}" alt="IATA Logo" class="w-16 h-16 mx-2" style="width: 70px; height: 70px;" />


								        </div>
								        
								    </div>
								</section>

								<style>
								    .flex.items-start {
								        align-items: flex-start;
								    }
								</style>



								<section class="lqd-section footer-menu flex flex-wrap items-start pt-50" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "opacity" : 0} , "animations": {"y": "0px", "opacity" : 1}}'>
									<div class="w-25percent flex flex-col p-10 lg:w-33percent sm:w-50percent animation-element">
										<div class="ld-fancy-heading relative">
											<h5 class="text-10 uppercase tracking-1 text-white-50 mb-4em ld-fh-element relative">COMPANY</h5>
										</div>
										<div class="link-15 link-white-80 lqd-fancy-menu lqd-custom-menu relative lqd-menu-td-none">
											<ul class="reset-ul" id="3e8baa6">
												<li class="mb-10">
													<a href="{{ url('/')}}">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>About US</span>
													</a>
												</li>
												<li class="mb-10">
													<a href="http://masilagroup.com/" target="_blank">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Masila Group</span>
													</a>
												</li>
												<li class="mb-10">
													
													<!-- <a href="#">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Travel Desk</span>
													</a>
												</li>
												<li class="mb-10"> -->
													<a href="{{ url('contact-us') }}" target="_blank">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Contact Us</span>
													</a>
												</li>
												<li>
													<a href="{{ url('contact-us') }}" target="_blank">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Customer Care</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="w-20percent flex flex-col p-10 lg:w-33percent sm:w-50percent animation-element">
										<div class="ld-fancy-heading relative">
											<h5 class="text-10 uppercase tracking-1 text-white-50 mb-4em ld-fh-element relative">Services</h5>
										</div>
										<div class="link-15 link-white-80 lqd-fancy-menu lqd-custom-menu relative lqd-menu-td-none">
											<ul class="reset-ul">
												<li class="mb-10">
													<a href="#">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Visa Service</span>
													</a>
												</li>
												<li class="mb-10">
													<a href="#">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Flight Booking</span>
													</a>
												</li>
												<li class="mb-10">
													<a href="#">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Hotel Booking</span>
													</a>
												</li>
												<li>
													<a href="#">
														<span class="link-icon inline-flex hide-if-empty left-icon icon-next-to-label"></span>
														<span>Tour Packages</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="w-20percent flex flex-col p-10 lg:w-33percent sm:w-full module-third animation-element">
										<div class="ld-fancy-heading relative">
											<h5 class="text-10 uppercase tracking-1 text-white-50 mb-4em ld-fh-element relative">NEED HELP?</h5>
										</div>
										<div class="ld-fancy-heading relative">
											<h6 class="text-9 uppercase tracking-1 ld-fh-element mb-0/5em inline-block relative text-slate-200">CALL US DIRECTLY</h6>
										</div>
										<div class="ld-fancy-heading relative">
											<p class="text-18 font-medium mb-1/75em text-white ld-fh-element relative">(+965) 2292 3004</p>
										</div>
										<div class="ld-fancy-heading relative">
											<h6 class="text-9 uppercase tracking-1 ld-fh-element mb-0/5em inline-block relative text-slate-200">CALL US DIRECTLY</h6>
										</div>
										<div class="ld-fancy-heading relative">
											<p class="text-18 font-medium mb-1/75em ld-fh-element relative">info@24Flights.com</p>
										</div>
									</div>
									<div class="w-35percent flex flex-col p-10 lg:w-full module-last animation-element">
										<div class="ld-fancy-heading relative">
											<h5 class="text-10 uppercase tracking-1 text-white-50 mb-4em ld-fh-element relative">Download our APP</h5>
										</div>
										<div class="ld-sf relative ld-sf--input-solid ld-sf--button-solid ld-sf--button-eql ld-sf--size-sm ld-sf--circle ld-sf--border-none ld-sf--button-show ld-sf--button-inside button-shrinked">
											 <img src="{{ asset('frontEnd/flightBookPage/assets/images/trustedBy/24flight_qr_code.svg')}}" alt="Civil Aviation" class="w-16 h-16 mx-2" style="width: 100px; height: 150px;" />
										</div>
									</div>
								</section>
								<section class="lqd-section footer-info flex flex-wrap items-center justify-between pt-70" data-custom-animations="true" data-ca-options='{"animationTarget": ".animation-element", "ease": "power4.out", "initValues": {"y": "35px", "opacity" : 0} , "animations": {"y": "0px", "opacity" : 1}}'>
									<div class="w-20percent flex justify-start p-10 lg:w-full lg:justify-start animation-element">
									    <div class="lqd-fancy-menu lqd-custom-menu relative lqd-menu-td-none">
									        <div class="ld-fancy-heading relative text-center w-80percent lg:w-full lg:text-start module-copyright flex items-center">
									            <img style="margin-bottom:10px;" width="75" height="21" src="{{ asset('frontEnd/flightBookPage/assets/images/demo/start-hub-3/logo/hub-logo-orange.svg')}}" alt="24Flights" class="mr-2">
									            <p class="text-14 leading-1em font-normal text-white-70 ld-fh-element mb-0/5em inline-block relative whitespace-nowrap">IATA Approved - 42213253</p>
									        </div>
									    </div>
									</div>


									<div class="w-80percent flex flex-wrap p-10 lg:w-full animation-element">
										<div class="ld-fancy-heading relative text-center w-80percent lg:w-full lg:text-start module-copyright">
											<p class="text-14 leading-1em font-normal text-white-70 ld-fh-element mb-0/5em inline-block relative">© Al Masila Travel Initiative</p>
										</div>
										<div class="flex gap-40 justify-end module-social w-20percent lg:justify-start lg:order-first">
											<span class="grid-item">
												<a href="https://www.facebook.com/24Flights" class="icon social-icon social-icon-facebook-square text-22 hover:svg-white" target="_blank">
													<span class="sr-only">Facebook-square</span>
													<svg class="w-1em h-1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
														<path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z" fill="#FFFFFFA6" />
													</svg>
												</a>
											</span>
											<!-- <span class="grid-item">
												<a href="#" class="icon social-icon social-icon-twitter text-22 hover:svg-white" target="_blank">
													<span class="sr-only">Twitter</span>
													<svg class="w-1em h-1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
														<path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" fill="#FFFFFFA6" />
													</svg>
												</a>
											</span> -->
											<span class="grid-item">
												<a href="https://www.instagram.com/24_flights/" class="icon social-icon social-icon-instagram text-22 hover:svg-white" target="_blank">
													<span class="sr-only">Instagram</span>
													<svg class="w-1em h-1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
														<path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" fill="#FFFFFFA6" />
													</svg>
												</a>
											</span>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Contact Modal -->
		<div id="contact-modal" class="lity-modal lqd-modal lity-hide" data-modal-type="fullscreen">
			<div class="lqd-modal-inner">
				<div class="lqd-modal-head"></div>
				<div class="lqd-modal-content link-black">
					<div class="container">
						<div class="row min-h-100vh items-center">
							<div class="w-55percent p-10 sm:w-full">
								<div class="flex flex-col w-full pr-90 lg:pr-0">
									<div class="ld-fancy-heading relative">
										<h2 class="ld-fh-element mb-0/5em inline-block relative text-120 font-medium leading-0/8em text-blue-600">Send a message</h2>
									</div>
									<div class="ld-fancy-heading relative">
										<p class="ld-fh-element mb-0/5em inline-block relative text-18">We're here to answer any question you may have.</p>
									</div>
									<div class="w-full flex flex-wrap">
										<div class="w-50percent flex flex-col p-10 sm:w-full">
											<div class="mb-10 ld-fancy-heading relative">
												<h6 class="ld-fh-element mb-0/5em inline-block relative text-black text-14 font-bold tracking-0">careers</h6>
											</div>
											<div class="mb-10 ld-fancy-heading relative">
												<p class="ld-fh-element mb-0/5em inline-block relative text-16 leading-1/25em">Would you like to join our growing team?</p>
											</div>
											<div class="ld-fancy-heading relative">
												<p class="ld-fh-element mb-0/5em inline-block relative">
													<a href="#" class="text-16 font-bold leading-1/2em">careers@hub.com </a>
												</p>
											</div>
										</div>
										<div class="w-50percent flex flex-col p-10 sm:w-full">
											<div class="mb-10 ld-fancy-heading relative">
												<h6 class="ld-fh-element mb-0/5em inline-block relative text-black text-14 font-bold tracking-0">careers</h6>
											</div>
											<div class="mb-10 ld-fancy-heading relative">
												<p class="ld-fh-element mb-0/5em inline-block relative text-16 leading-1/25em">Would you like to join our growing team?</p>
											</div>
											<div class="ld-fancy-heading relative">
												<p class="ld-fh-element mb-0/5em inline-block relative">
													<a href="#" class="text-16 font-bold leading-1/2em">careers@hub.com </a>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="w-45percent sm:w-full">
								<div class="lqd-contact-form lqd-contact-form-inputs-underlined lqd-contact-form-button-block lqd-contact-form-button-lg lqd-contact-form-button-border-none">
									<div role="form" lang="en-US">
										<div class="screen-reader-response">
											<p role="status" aria-live="polite" aria-atomic="true"></p>
										</div>
										<form action="#" method="post" class="lqd-cf-form" novalidate="novalidate" data-status="init">
											<div class="row">
												<div class="col col-xs-12 col-sm-6 relative py-0">
													<i class="lqd-icn-ess icon-lqd-user"></i>
													<span class="lqd-form-control-wrap">
														<input class="text-13 text-black border-black-20" type="text" name="name" value="" size="40" aria-required="true" aria-invalid="false" placeholder="What's your name?">
													</span>
												</div>
												<div class="col col-xs-12 col-sm-6 relative py-0">
													<i class="lqd-icn-ess icon-lqd-envelope"></i>
													<span class="lqd-form-control-wrap">
														<input class="text-13 text-black border-black-20" type="email" name="email" value="" size="40" aria-required="true" aria-invalid="false" placeholder="Email address">
													</span>
												</div>
												<div class="col col-xs-12 col-sm-6 relative py-0">
													<i class="lqd-icn-ess icon-speech-bubble"></i>
													<span class="lqd-form-control-wrap">
														<input class="text-13 text-black border-black-20" type="text" name="topic" value="" size="40" aria-required="true" aria-invalid="false" placeholder="Select a Discussion Topic">
													</span>
												</div>
												<div class="col col-xs-12 col-sm-6 relative py-0">
													<i class="lqd-icn-ess icon-lqd-dollar"></i>
													<span class="lqd-form-control-wrap">
														<input class="text-13 text-black border-black-20" type="text" name="budget" value="" size="40" aria-required="true" aria-invalid="false" placeholder="What's your budget?">
													</span>
												</div>
												<div class="col col-12 lqd-form-textarea relative py-0">
													<i class="lqd-icn-ess icon-lqd-pen-2"></i>
													<span class="lqd-form-control-wrap">
														<textarea class="text-13 text-black border-black-20" name="message" cols="10" rows="6" aria-required="true" aria-invalid="false" placeholder="A brief description about your project/request/consultation"></textarea>
													</span>
												</div>
												<div class="col col-xs-12 text-center relative py-0">
													<input class="bg-primary text-white text-17 font-medium leading-1/5em hover:bg-primary hover:text-white rounded-100" type="submit" value="— send message">
													<p class="mt-1em text-black">
														<span>— copy email:</span>
														<a href="#">info@24Flights.com </a>
													</p>
												</div>
											</div>
										</form>
										<div class="lqd-cf-response-output"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="lqd-modal-foot"></div>
			</div>
		</div>
		<!-- Contact Modal -->

		<!-- Hub wordpress -->
		 

		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/jquery.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/jquery-ui/jquery-ui.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/bootstrap/js/bootstrap.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/gsap/minified/gsap.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/gsap/minified/ScrollTrigger.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/gsap/utils/SplitText.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/fastdom/fastdom.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/isotope/isotope.pkgd.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/isotope/packery-mode.pkgd.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/flickity/flickity.pkgd.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/imagesloaded.pkgd.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/draggabilly.pkgd.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/fontfaceobserver.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/particles.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/fresco/js/fresco.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/lity/lity.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/vendors/lottie/lottie.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/js/liquid-gdpr.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/js/theme.min.js')}} "></script>
		<script src="{{ asset('frontEnd/flightBookPage/assets/js/liquid-ajax-contact-form.min.js')}} "></script>

		<!-- Start custom cursor -->
		<div class="lqd-cc lqd-cc--inner fixed pointer-events-none"></div>
		<div class="lqd-cc--el lqd-cc-solid lqd-cc-explore flex items-center justify-center rounded-full fixed pointer-events-none">
			<div class="lqd-cc-solid-bg flex absolute lqd-overlay"></div>
			<div class="lqd-cc-solid-txt flex justify-center text-center relative">
				<div class="lqd-cc-solid-txt-inner">Explide</div>
			</div>
		</div>
		<div class="lqd-cc--el lqd-cc-solid lqd-cc-drag flex items-center justify-center rounded-full fixed pointer-events-none">
			<div class="lqd-cc-solid-bg flex absolute lqd-overlay"></div>
			<div class="lqd-cc-solid-ext lqd-cc-solid-ext-left inline-flex items-center">
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;">
					<path fill="currentColor" d="M19.943 6.07L9.837 14.73a1.486 1.486 0 0 0 0 2.25l10.106 8.661c.96.826 2.457.145 2.447-1.125V7.195c0-1.27-1.487-1.951-2.447-1.125z"></path>
				</svg>
			</div>
			<div class="lqd-cc-solid-txt flex justify-center text-center relative">
				<div class="lqd-cc-solid-txt-inner">Drag</div>
			</div>
			<div class="lqd-cc-solid-ext lqd-cc-solid-ext-right inline-flex items-center">
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;">
					<path fill="currentColor" d="M11.768 25.641l10.106-8.66a1.486 1.486 0 0 0 0-2.25L11.768 6.07c-.96-.826-2.457-.145-2.447 1.125v17.321c0 1.27 1.487 1.951 2.447 1.125z"></path>
				</svg>
			</div>
		</div>
		<div class="lqd-cc--el lqd-cc-arrow inline-flex items-center fixed top-0 left-0 pointer-events-none">
			<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M60.4993 0V4.77005H8.87285L80 75.9207L75.7886 79.1419L4.98796 8.35478V60.4993H0V0H60.4993Z" />
			</svg>
		</div>
		<div class="lqd-cc--el lqd-cc-custom-icon rounded-full fixed pointer-events-none">
			<div class="lqd-cc-ci inline-flex items-center justify-center rounded-full relative">
				<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="width: 1em; height: 1em;">
					<path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M16.03 6a1 1 0 0 1 1 1v8.02h8.02a1 1 0 1 1 0 2.01h-8.02v8.02a1 1 0 1 1-2.01 0v-8.02h-8.02a1 1 0 1 1 0-2.01h8.02v-8.01a1 1 0 0 1 1.01-1.01z"></path>
				</svg>
			</div>
		</div>
		<div class="lqd-cc lqd-cc--outer fixed top-0 left-0 pointer-events-none"></div>
		<!-- End custom cursor -->

		<template id="lqd-snickersbar">
			<div class="lqd-snickersbar flex flex-wrap lqd-snickersbar-in" data-item-id>
				<div class="lqd-snickersbar-inner flex flex-wrap items-center">
					<div class="lqd-snickersbar-detail">
						<p class="hidden lqd-snickersbar-addding-temp my-0">Adding to cart</p>
						<p class="hidden lqd-snickersbar-added-temp my-0">Added to cart</p>
						<p class="my-0 lqd-snickersbar-msg flex items-center my-0"></p>
						<p class="my-0 lqd-snickersbar-msg-done flex items-center my-0"></p>
					</div>
					<div class="lqd-snickersbar-ext ml-4"></div>
				</div>
			</div>
		</template>
		<template id="lqd-temp-sticky-header-sentinel">
			<div class="lqd-sticky-sentinel invisible absolute pointer-events-none"></div>
		</template>
		<div class="lity hidden" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1" data-modal-type="default">
			<div class="lity-backdrop"></div>
			<div class="lity-wrap" data-lity-close role="document">
				<div class="lity-loader" aria-hidden="true">Loading...</div>
				<div class="lity-container">
					<div class="lity-content"></div>
				</div>
				<button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>&times;</button>
			</div>
		</div>


	</body>

</html>