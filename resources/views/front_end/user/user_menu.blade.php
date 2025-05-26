<div class="col-lg-3"> 
    <!-- Nav Link
    ============================================= -->
    <ul class="nav nav-pills alternate flex-lg-column mb-3 mb-lg-0 ">
      @if (Auth::user()->is_agent == 1)
        <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'agent-dashboard' ? 'active' : '' }}" href="{{route('agent-dashboard')}}"><span class="me-2"><i class="fas fa-chalkboard-teacher"></i></span>{{__('lang.dashboard')}} </a></li>
        
        <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'agent-flight-booking' ? 'active' : '' }}" href="{{route('agent-flight-booking')}}"><span class="me-2"><i class="fas fa-plane"></i></span>{{__('lang.flight_booking')}}</a></li>

        <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'agent-hotel-booking' ? 'active' : '' }}" href="{{route('agent-hotel-booking')}}"><span class="me-2"><i class="fas fa-hotel"></i></span>{{__('lang.hotel_booking')}} </a></li>
        
        <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'wallet-logs' ? 'active' : '' }}" href="{{route('wallet-logs')}}"><span class="me-2"><i class="fas fa-wallet"></i></span>{{__('lang.wallet_logs')}} </a></li>

        <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'profile' ? 'active' : '' }}" href="{{route('profile')}}"><span class="me-2"><i class="fas fa-user"></i></span>{{__('lang.personal_information')}} </a></li>
      @else
        <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'profile' ? 'active' : '' }}" href="{{route('profile')}}"><span class="me-2"><i class="fas fa-user"></i></span>{{__('lang.personal_information')}} </a></li>

        <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'user-bookings' ? 'active' : '' }}" href="{{route('user-bookings')}}"><span class="me-2"><i class="fas fa-history"></i></span>{{__('lang.booking_history')}} </a></li> 

      @endif
      

      
      <li class="nav-item"><a class="nav-link {{Request::segment(1) == 'change-password' ? 'active' : '' }}" href="{{route('change-password')}}"><span class="me-2"><i class="fas fa-key"></i></span>{{__('lang.change_password')}}</a></li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="me-2"><i class="fas fa-sign-in-alt"></i></span>{{__('lang.logout')}}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </li>
    </ul>
    <!-- Nav Link end --> 
  </div>