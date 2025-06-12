<!DOCTYPE html>

{{-- <html lang="en"> --}}
@if(app()->getLocale() == 'ar')
<html dir="rtl" lang="ar">
@else
<html lang="en">
@endif    
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <link href="{{asset('frontEnd/images/favicon.png')}}" rel="icon" />
    <title>{{ isset($titles['title']) && !empty($titles['title']) ? $titles['title'] : env('APP_NAME') }}</title>
    {{-- <title>{{ env('APP_NAME') }}</title> --}}

    <meta name="description" content="{{ isset($titles['description']) && !empty($titles['description']) ? $titles['description'] : 'We empowers travel agencies to operate more efficiently.As a leading global travel distribution platform.' }} ">
    <meta name="keywords" content="{{ isset($titles['keywords']) && !empty($titles['keywords']) ? $titles['keywords'] : 'MasilaHoildays,Booking Engine' }}">
    <meta name="author" content="masilaGroup">
    <link rel="canonical" href="{{url()->current()}}" />
    <meta property="og:title" content="{{ isset($titles['title']) && !empty($titles['title']) ? $titles['title'] : 'MasilaHoildays | B2B Hotel Bookings' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:URL" content="{{url()->current()}}"/>
    <meta property="og:image" content="{{ isset($titles['image']) && !empty($titles['image']) ? $titles['image'] : asset('frontEnd/images/favicon.png') }}" />
    <meta property="og:description" content="{{ isset($titles['description']) && !empty($titles['description']) ? $titles['description'] : 'We empowers travel agencies to operate more efficiently.As a leading global travel distribution platform.' }}" />
    <meta name="twitter:card" content="MasilaHoildays" />
    <meta name="twitter:title" content="{{ isset($titles['title']) && !empty($titles['title']) ? $titles['title'] : 'MasilaHoildays | Book Flights & Hotels' }} " />
    <meta name="twitter:description" content="{{ isset($titles['description']) && !empty($titles['description']) ? $titles['description'] : 'We empowers travel agencies to operate more efficiently.As a leading global travel distribution platform.' }}" />
    <meta name="twitter:site" content="@masilahoildays" />
    @if (App::environment('prod'))
        <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '488329817111460');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=488329817111460&ev=PageView&noscript=1"/></noscript>
        <!-- End Meta Pixel Code -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2042956870004653" crossorigin="anonymous"></script>
    @endif
    <meta name="publisher" content="masilaGroup">
    @if(app()->getLocale() == 'ar')
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/vendor/bootstrap/css/bootstrap.rtl.min.css') }}' />  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo' !important;
        }
        h1,h2,h3,h4,h5,h6 {
            font-family: 'Cairo' !important; 
        }
    </style>
    @else
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/vendor/bootstrap/css/bootstrap.min.css') }}' />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @endif 
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/vendor/font-awesome/css/all.min.css') }}' />
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/vendor/owl.carousel/assets/owl.carousel.min.css') }}' />
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/vendor/jquery-ui/jquery-ui.css') }}' />
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/vendor/daterangepicker/daterangepicker.css') }}' />
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/css/stylesheet.css') }}' />
    <link rel="stylesheet" type="text/css" href='{{ asset('frontEnd/css/custom.css') }}' />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    .ui-autocomplete-loading { 
        background:url("{{asset('frontEnd/images/indicator.gif')}}") no-repeat right 
    }
    .whats-app {
    position: fixed;
    width: 40px;
    height: 40px;
    bottom: 48px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 3px #999;
    z-index: 100;
    right: 12px;
}
.whats-app-rtl {
    position: fixed;
    width: 40px;
    height: 40px;
    bottom: 48px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 3px #999;
    z-index: 100;
    left: 12px;
}

.my-float {
    margin-top: 5px;
}

    </style>

    @if(url()->current() == 'https://24flights.com/package/umrah-sep')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10906842083">
        </script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-10906842083');
        </script>

    @elseif(env('APP_ENV') == 'prod' )
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-81V5GTF8PN"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-81V5GTF8PN');
        </script>
    @endif

    @yield('extrastyle')
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div data-loader="dual-ring"></div>
    </div>
    <!-- Preloader End -->

    <!-- Document Wrapper -->
    <div id="main-wrapper">
        

        @include('front_end.layouts.header')

        @yield('content')

        @include('front_end.layouts.footer')



    </div>
    <!-- Document Wrapper end -->

    <!-- Back to Top -->
    <a id="back-to-top" data-bs-toggle="tooltip" title="Back to Top" href="javascript:void(0)"><i
            class="fa fa-chevron-up"></i></a>

            <a  class= {{(app()->getLocale() == 'ar')?"whats-app-rtl":"whats-app" }} href="https://api.whatsapp.com/send?phone=96567041515" target="_blank">
                <i class="fab fa-whatsapp my-float"></i>
            </a>

    <!-- Script -->
    <script src='{{ asset('frontEnd/vendor/jquery/jquery.min.js') }}'></script>
    <script src='{{ asset('frontEnd/vendor/jquery-ui/jquery-ui.min.js') }}'></script>
    <script src='{{ asset('frontEnd/vendor/bootstrap/js/bootstrap.bundle.min.js') }}'></script>
    <script src='{{ asset('frontEnd/vendor/owl.carousel/owl.carousel.min.js') }}'></script>
    <script src='{{ asset('frontEnd/vendor/bootstrap-spinner/bootstrap-spinner.js') }}'></script>
    <script src='{{ asset('frontEnd/vendor/daterangepicker/moment.min.js') }}'></script>
    <script src='{{ asset('frontEnd/vendor/daterangepicker/daterangepicker.js') }}'></script>
    
    <script src='{{ asset('frontEnd/js/theme.js') }}'></script>
    <script src='{{ asset('frontEnd/js/custom.js') }}'></script>
    @yield('extraScripts')
</body>

</html>
