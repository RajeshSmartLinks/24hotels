<!-- Header
    ============================================= -->
    <header id="header" class="Stickyheader">
      <div class="container">
        <div class="header-row">
          <div class="header-column justify-content-start"> 
            
            <!-- Logo
            ============================================= -->
            <div class="logo me-2 me-lg-3"> <a href="{{url('/')}}" class="d-flex" title="MasilaHoildays"><img src='{{asset("frontEnd/images/logomh.png")}}' alt="24-flights" height="60"/></a> </div>
            <!-- Logo end --> 
            
          </div>
          <div class="header-column justify-content-end"> 
            
            <!-- Primary Navigation
            ============================================= -->
            <nav class="primary-menu navbar navbar-expand-lg">
              <div id="header-nav" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                  <li><a class="dropdown-item" href="{{url('/')}}">{{__('lang.home')}}</a></li>
                  {{-- <li><a class="dropdown-item" href="{{route('offers')}}">{{__('lang.offers')}}</a></li> --}}
                  <li><a class="dropdown-item" href="{{url('/contact-us')}}">{{__('lang.contact_us')}}</a></li>
                  <li class="dropdown dropdown-language nav-item ">

                    <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="selected-language"> {{config('app.currency')}}</span>
                    </a>
                    <div class="dropdown-menu " aria-labelledby="dropdown-flag" style="min-width: 95px;!important">
                      @php
                        $currencyList = currencyList();
                        if(app()->getLocale() == 'ar')
                        {
                          $currencyText = 'currency_code_ar' ;
                        }
                        else {
                          $currencyText = 'currency_code_en' ;
                        }
                      @endphp
                      @foreach($currencyList as $currency)
           

                        {{-- <a class="dropdown-item" href="{{route('changecurrency',['currency'=>$currency->currency_code_en])}}" > <img  src='{{asset("frontEnd/images/flags/$currency->currency_code_en.jpg")}}'/> &nbsp;
                        {{$currency->$currencyText}}</a> --}}

                        <a class="dropdown-item" href={{ Request::segment(1) != "preview" ? route('changecurrency',['currency'=>$currency->currency_code_en]) : '#' }} > <img  src='{{asset("frontEnd/images/flags/$currency->currency_code_en.jpg")}}'/> &nbsp;
                          {{$currency->$currencyText}}</a>


                      @endforeach
                    </div>
                  </li>
                  @if(app()->getLocale() == 'ar')
                  <li> <a class="dropdown-item" href="{{route('changelang',['lang'=>'en'])}}">English</a></li>
                  @else
                  <li> <a class="dropdown-item" href="{{route('changelang',['lang'=>'ar'])}}">عربى</a></li>
                  @endif
                  @if(auth()->user())
                  <li> <a class="dropdown-item" href="{{route('wallet-logs')}}">Wallet : KWD {{auth()->user()->wallet_balance}}</a></li>
                  @endif
                </ul>
              </div>
            </nav>
            <!-- Primary Navigation end --> 
            
            <!-- Collapse Button
            =============================== -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav"> <span></span> <span></span> <span></span> </button>
            <div class="vr mx-2 h-25 my-auto"></div>
            <!-- Login Signup
            =============================== -->
            <nav class="login-signup navbar navbar-expand">
              @if(Auth::guard('web')->check())
              <ul class="navbar-nav">
                <li class="profile"><a class="pe-0"  href="{{auth()->user()->is_agent == '1' ? route('agent-dashboard') : url('/profile')}}" title="Profile"><span class="d-none d-sm-inline-block">{{Auth::guard('web')->user()->first_name}}</span> <span class="user-icon ms-sm-2">
                  @if(!empty(Auth::guard('web')->user()->profile_pic))
                  <img src= "{{asset('uploads/users/'.Auth::guard('web')->user()->profile_pic)}}" style="height: 35px;width: 35px;border-radius: 50%;" >
                  @else
                  <i class="fas fa-user"></i>
                  @endif

                </span></a></li>
              </ul>
              @else
              <ul class="navbar-nav">
                {{-- <li class="profile"><a class="pe-0"  href="{{url('/login')}}" title="{{__('lang.login_sign_up')}}"><span class="d-none d-sm-inline-block">{{__('lang.login_sign_up')}}</span> <span class="user-icon ms-sm-2"><i class="fas fa-user"></i></span></a></li> --}}
                <li class="profile"><a class="pe-0"  href="{{url('/login')}}" title="{{__('lang.login')}}"><span class="d-none d-sm-inline-block">{{__('lang.login')}}</span> <span class="user-icon ms-sm-2"><i class="fas fa-user"></i></span></a></li>
              </ul>
              @endif
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- Header end --> 