<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="We empowers travel agencies to operate more efficiently.As a leading global travel distribution platform.">
    <meta name="keywords" content="Masila Hoildays,Booking Engine,Admin">
    <meta name="author" content="Rajesh Vuppala">
    <title>{{env('APP_NAME')}} - Login</title>
    <link href="{{asset('frontEnd/images/favicon.png')}}" rel="icon" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/pages/authentication.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <!-- <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css"> -->
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="{{asset('admin-assets/images/pages/login.png')}}" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Login</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">Welcome back, please login to your account.</p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                {{-- <form action="{{url('admin/login')}}" method="post">
                                                    @csrf
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="user-name" placeholder="Username" required name ="email">
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="user-name">Username</label>
                                                        
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="user-password" placeholder="Password"  name="password"  required>
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="user-password">Password</label>


                                                        
                                                    </fieldset>
                                                    <div class="form-group d-flex justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">Remember me</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                                                </form> --}}
                                                <form id="loginForm" method="POST">
                                                    @csrf
                                                    <!-- Login Section -->
                                                    <div id="loginSection">
                                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                            <input type="text"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                id="user-name"
                                                                placeholder="Username"
                                                                required
                                                                name="email">
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                            <span class="text-danger d-none" id="emailError"></span>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-user"></i>
                                                            </div>
                                                            <label for="user-name">Username</label>
                                                        </fieldset>

                                                        <fieldset class="form-label-group position-relative has-icon-left">
                                                            <input type="password"
                                                                class="form-control @error('password') is-invalid @enderror"
                                                                id="user-password"
                                                                placeholder="Password"
                                                                required
                                                                name="password">
                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                            <span class="text-danger d-none" id="passwordError"></span>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                            <label for="user-password">Password</label>
                                                        </fieldset>

                                                        <div class="form-group d-flex justify-content-between align-items-center">
                                                            <div class="text-left">
                                                                <fieldset class="checkbox">
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                                            {{ old('remember') ? 'checked' : '' }}>
                                                                        <span class="vs-checkbox">
                                                                            <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                            </span>
                                                                        </span>
                                                                        <span class="">Remember me</span>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary float-right btn-inline" id="loginBtn">Login</button>
                                                    </div>

                                                    <!-- OTP Section -->
                                                    <div id="otpSection" class="d-none">
                                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                            <input type="text"
                                                                class="form-control"
                                                                id="otpInput"
                                                                name="otp"
                                                                maxlength="6"
                                                                placeholder="Enter OTP">
                                                            <div class="form-control-position">
                                                                <i class="feather icon-shield"></i>
                                                            </div>
                                                            <label for="otpInput">OTP</label>
                                                            <span class="text-danger d-none" id="otpError"></span>
                                                        </fieldset>

                                                        <button type="button" class="btn btn-success btn-block mt-2" id="verifyOtpBtn">Verify OTP</button>
                                                        <button type="button" class="btn btn-link mt-2" id="resendOtpBtn">Resend OTP</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            {{-- <div class="divider">
                                                <div class="divider-text">OR</div>
                                            </div> --}}
                                            {{-- <div class="footer-btn d-inline">
                                                <a href="#" class="btn btn-facebook"><span class="fa fa-facebook"></span></a>
                                                <a href="#" class="btn btn-twitter white"><span class="fa fa-twitter"></span></a>
                                                <a href="#" class="btn btn-google"><span class="fa fa-google"></span></a>
                                                <a href="#" class="btn btn-github"><span class="fa fa-github-alt"></span></a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('admin-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('admin-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('admin-assets/js/core/app.js')}}"></script>
    <script src="{{asset('admin-assets/js/scripts/components.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->
    <script>
        $(document).ready(function () {
            // Login form submit
            $("#loginForm").on("submit", function (e) {
                e.preventDefault();

                $("#loginBtn").prop("disabled", true).text("Logging in...");

                $.ajax({
                    url: "{{ url('admin/login') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success && response.step === "otp") {
                            $("#loginSection").addClass("d-none");
                            $("#otpSection").removeClass("d-none");
                        } else if (response.success) {
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function (xhr) {
                         console.log(xhr.responseJSON);
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $("#emailError").text(errors.email[0]).removeClass("d-none");
                            }
                            if (errors.password) {
                                $("#passwordError").text(errors.password[0]).removeClass("d-none");
                            }
                        } else {
                            console.log(xhr.responseJSON);
                            $("#emailError").text(xhr.responseJSON.message).removeClass("d-none");
                            //alert(xhr.responseJSON.message || "Login failed. Try again.");
                        }
                    },
                    complete: function () {
                        $("#loginBtn").prop("disabled", false).text("Login");
                    }
                });
            });

            // Verify OTP
            $("#verifyOtpBtn").on("click", function () {
                $.ajax({
                    url: "{{ url('admin/verify-otp') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: $("#user-name").val(),
                        password: $("#user-password").val(),
                        otp: $("#otpInput").val()
                    },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                        } else {
                            $("#otpError").text(response.message).removeClass("d-none");
                        }
                    },
                    error: function () {
                        $("#otpError").text("OTP verification failed.").removeClass("d-none");
                    }
                });
            });

            // Resend OTP
            $("#resendOtpBtn").on("click", function () {
                $(this).prop("disabled", true).text("Resending...");

                $.ajax({
                    url: "{{ url('admin/resend-otp') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: $("#user-name").val()
                    },
                    success: function (response) {
                        alert(response.message);
                        setTimeout(function () {
                            $("#resendOtpBtn").prop("disabled", false).text("Resend OTP");
                        }, 30000); // 30 sec cooldown
                    },
                    error: function () {
                        alert("Failed to resend OTP.");
                        $("#resendOtpBtn").prop("disabled", false).text("Resend OTP");
                    }
                });
            });
        });
    </script>


</body>
<!-- END: Body-->

</html>