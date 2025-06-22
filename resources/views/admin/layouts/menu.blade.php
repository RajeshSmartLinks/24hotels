 <!-- BEGIN: Main Menu-->
 <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('admin.dashboard')}}">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">{{env("APP_NAME")}}</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @can('dashboard-view')
            <li class=" nav-item {{Request::segment(2) == 'dashboard' ? 'active' : '' }}"><a href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span><span class="badge badge badge-warning badge-pill float-right mr-2"></span></a>
            </li>
            @endcan
            {{-- <li class=" navigation-header"><span>Apps</span>
            </li> --}}
            {{-- @can('booking-view')
            <li class=" nav-item {{Request::segment(2) == 'bookings' ? 'active' : '' }}"><a href="{{route('admin.bookingsList')}}"><i class="feather icon-message-square"></i><span class="menu-title" data-i18n="Booking">Flight Booking</span></a>
            </li>
            @endcan --}}
            @can('hotel-booking-view')
            <li class=" nav-item {{Request::segment(2) == 'hotelBookings' ? 'active' : '' }}"><a href="{{route('admin.hotelbookingsList')}}"><i class="feather icon-message-square"></i><span class="menu-title" data-i18n="Booking">Hotel Booking</span></a>
            </li>
            @endcan
            
            @can('customer-view')
            <li class=" nav-item {{Request::segment(2) == 'customer' ? 'active' : '' }}"><a href="{{route('admin.customerList')}}"><i class="feather icon-mail"></i><span class="menu-title" data-i18n="Customers">Customers</span></a>
            @endcan
            {{-- @can('user-view')
            <li class=" nav-item {{Request::segment(2) == 'user' ? 'active' : '' }}"><a href="{{route('admin.userList')}}"><i class="feather icon-message-square"></i><span class="menu-title" data-i18n="Users">Users</span></a>
            </li>
            @endcan
            @can('offer-view')
            <li class=" nav-item {{Request::segment(2) == 'offers' ? 'active' : '' }}"><a href="{{route('offers.index')}}"><i class="feather icon-calendar"></i><span class="menu-title" data-i18n="Offers">Offers</span></a>
            </li>
            @endcan
            @can('popular-events-news-view')
            <li class=" nav-item {{Request::segment(2) == 'popular-events-news' ? 'active' : '' }}"><a href="{{route('popular-events-news.index')}}"><i class="feather icon-calendar"></i><span class="menu-title" data-i18n="Offers">Popular Events News</span></a>
            </li>
            @endcan
            @can('coupone-view')
            <li class=" nav-item"><a href="#"><i class="feather icon-message-square"></i><span class="menu-title" data-i18n="Coupones">Coupones</span></a>
            </li>
            @endcan
            @can('package-view')
            
            <li class=" nav-item {{Request::segment(2) == 'packages' ? 'active' : '' }}"><a href="{{route('packages.index')}}"><i class="feather icon-calendar"></i><span class="menu-title" data-i18n="Packages">Packages</span></a>
            </li>
            @endcan
            @can('destination-view')
            <li class=" nav-item {{Request::segment(2) == 'destinations' ? 'active' : '' }}"><a href="{{route('destinations.index')}}"><i class="feather icon-check-square"></i><span class="menu-title" data-i18n="Destinations">Destinations</span></a>
            </li>
            @endcan --}}
             @can('agency-view')
            <li class=" nav-item {{Request::segment(2) == 'agency' ? 'active' : '' }}"><a href="{{route('agency.index')}}"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Agencies">Agencies</span></a>
            </li>
            @endcan
            @can('agent-view')
            <li class=" nav-item {{Request::segment(2) == 'agents' ? 'active' : '' }}"><a href="{{route('agents.index')}}"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Agents">Agents</span></a>
            </li>
            @endcan
            @canany(['faq-view' , 'privacy-policy-view'])
            <li class=" navigation-header"><span>pages</span>
            </li>
            @endcan
            {{-- <li class=" nav-item"><a href="#"><i class="feather icon-settings"></i><span class="menu-title" data-i18n="Account Settings">Terms of use</span></a> 
            </li>--}}
            @can('faq-view')
            <li class=" nav-item {{Request::segment(2) == 'faq' ? 'active' : '' }}"><a href="{{route('faq.index')}}"><i class="feather icon-help-circle"></i><span class="menu-title" data-i18n="FAQ">FAQ</span></a>
            </li>
            @endcan
            @can('privacy-policy-view')
            <li class=" nav-item"><a href="#"><i class="feather icon-info"></i><span class="menu-title" data-i18n="Knowledge Base">Privacy Policy</span></a>
            </li>
            @endcan
            @canany(['role-view', 'operator-view' , 'currency-view' , 'markups-view' , 'app-view' ,'push-notification-view' ,'coupon-view'])
            <li class=" navigation-header"><span>Settings</span></li>
            @endcan
            @can('role-view')
            <li class="nav-item {{Request::segment(2) == 'role' ? 'active' : '' }}"><a
                href="{{route('role.index')}}"><i class="feather icon-user-plus"></i><span
                    class="menu-title"
                    data-i18n="{{aztran('roles')}}">{{aztran('roles')}}</span></a>
            </li>
            @endcan
            @can('operator-view')
            <li class=" nav-item {{Request::segment(2) == 'operator' ? 'active' : '' }}"><a href="{{route('operator.index')}}"><i class="feather icon-mail"></i><span class="menu-title" data-i18n="Operators">Operators</span></a>
            </li>
            @endcan
            @can('currency-view')
            <li class=" nav-item {{Request::segment(2) == 'currency' ? 'active' : '' }}"><a href="{{route('currency.index')}}"><i class="feather icon-calendar"></i><span class="menu-title" data-i18n="{{__('admin.currency')}}">{{__('admin.currency')}}</span></a>
            </li>
            @endcan
            @can('markups-view')
            <li class=" nav-item {{Request::segment(2) == 'markups' ? 'active' : '' }}"><a href="{{route('markups.index')}}"><i class="feather icon-mail"></i><span class="menu-title" data-i18n="Mark Ups">Mark Ups</span></a>
            </li>
            @endcan
            @can('app-view')
            <li class=" nav-item {{Request::segment(2) == 'app' ? 'active' : '' }}"><a href="{{route('app.index')}}"><i class="feather icon-mail"></i><span class="menu-title" data-i18n="App">App</span></a>
            </li>
            @endcan
            @can('push-notification-view')
            <li class=" nav-item {{Request::segment(2) == 'notifications' ? 'active' : '' }}"><a href="{{route('notifications.index')}}"><i class="feather icon-mail"></i><span class="menu-title" data-i18n="Notifications">Notifications</span></a>
            </li>
            @endcan

            @can('coupon-view')
            <li class=" nav-item {{Request::segment(2) == 'coupons' ? 'active' : '' }}"><a href="{{route('coupons.index')}}"><i class="feather icon-message-square"></i><span class="menu-title" data-i18n="Coupons">Coupons</span></a>
            </li>
            @endcan
            @can('seo-view')
            <li class=" nav-item {{Request::segment(2) == 'seo' ? 'active' : '' }}"><a href="{{route('seo.index')}}"><i class="feather icon-message-square"></i><span class="menu-title" data-i18n="SEO">SEO Settings</span></a>
            </li>
            @endcan
            @can('popup-view')
            <li class=" nav-item {{Request::segment(2) == 'popup' ? 'active' : '' }}"><a href="{{route('popup.index')}}"><i class="feather icon-check-square"></i><span class="menu-title" data-i18n="popup">Popup</span></a>
            </li>
            @endcan
            
           
        </ul>
    </div>
</div>
<!-- END: Main Menu-->