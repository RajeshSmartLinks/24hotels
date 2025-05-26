<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.flutter_app.header')
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex">
    <div class="container">
        <div class="header-container d-flex " style="display: flex;justify-content: center;">
            <div class="logo mr-auto">
                <h1 class="text-light"><a href="#"><span>24Flights</span></a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            </div>
        </div><!-- End Header Container -->
    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="" class="d-flex align-items-center">

</section><!-- End Hero -->

<main id="main" style="display: flex;justify-content: center;">
    @yield('content')
</main>

@include('layouts.flutter_app.footer')

@yield('extra-script')
</body>

</html>
