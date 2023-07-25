
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user-dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/images/genarel-settings/'.$gs->header_logo) }}" alt="" >
        </div>

      </a>

      <li class="nav-item @if( request()->is('user/dashboard') ) active @endif ">
        <a class="nav-link" href="{{ route('user-dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#hotel" aria-expanded="true"
           aria-controls="collapseTable">
            <i class="fas fa-fw fa-hotel"></i>
    <span>{{__('Hotel')}}</span>
        </a>
        <div id="hotel" class="collapse 
        @if( request()->is('user/hotel') ) show
        @elseif( request()->is('user/hotel/create') ) show
        @elseif( request()->is('user/hotel/edit/*') ) show
        @elseif( request()->is('user/room') ) show
        @elseif( request()->is('user/room/*') ) show
        @elseif( request()->is('user/hotel/orders/all') ) show
        @elseif( request()->is('user/hotel/orders/pending') ) show
        @endif
        " aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item 
                @if( request()->is('user/hotel') ) active
                @elseif( request()->is('user/hotel/create') ) active
                @elseif( request()->is('user/hotel/edit/*') ) active
                @elseif( request()->is('user/hotel/room/*') ) active
                @endif
                " href="{{route('user-hotel-index')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Hotel') }}</a>
                @if(App\Helpers\Helper::hotelCheck() == true)
                <a class="collapse-item  
                @if( request()->is('user/hotel/orders/all') ) active
                @endif
                " href="{{route('user-hotel-allorders')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Booking') }}</a>
                <a class="collapse-item 
                @if( request()->is('user/hotel/orders/pending') ) active
                @endif
                " href="{{route('user-hotel-pending.orders')}}"><i class="fas fa-angle-double-right"></i> {{ __('Pending Booking') }}</a>
                @endif
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tour" aria-expanded="true"
           aria-controls="collapseTable">
            <i class="fab fa-tripadvisor fa-2x"></i>
    <span>{{__('Tour')}}</span>
        </a>
        <div id="tour" class="collapse 
        @if( request()->is('user/tour') ) show
        @elseif( request()->is('user/tour/orders/all') ) show
        @elseif( request()->is('user/tour/orders/pending') ) show
        @elseif( request()->is('user/tour/edit/*') ) show
        @endif
        " aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item 
                @if( request()->is('user/tour') ) active
                @elseif( request()->is('user/tour/create') ) active
                @elseif( request()->is('user/tour/edit/*') ) active
                @endif
                " href="{{route('user-tour-index')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Tour') }}</a>
                @if(App\Helpers\Helper::tourCheck() == true)
                <a class="collapse-item 
                @if( request()->is('user/tour/orders/all') ) active
                @endif
                " href="{{route('user-tour-allorders')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Booking') }}</a>
                <a class="collapse-item 
                @if( request()->is('user/tour/orders/pending') ) active
                @endif
                " href="{{route('user-tour-pending.orders')}}"><i class="fas fa-angle-double-right"></i> {{ __('Pending Booking') }}</a>
                @endif
            </div>
        </div>
    </li>
 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#space" aria-expanded="true"
           aria-controls="collapseTable">
            <i class="fas fa-fw fa-home"></i>
    <span>{{__('Space')}}</span>
        </a>
        <div id="space" class="collapse 
        @if( request()->is('user/space') ) show
        @elseif( request()->is('user/space/orders/all') ) show
        @elseif( request()->is('user/space/orders/pending') ) show
        @elseif( request()->is('user/space/edit/*') ) show
        @endif
        " aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item 
                @if( request()->is('user/space') ) active
                @elseif( request()->is('user/space/create') ) active
                @elseif( request()->is('user/space/edit/*') ) active
                @endif
                " href="{{route('user-space-index')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Spaces') }}</a>
                @if(App\Helpers\Helper::spaceCheck() == true)
                <a class="collapse-item 
                @if( request()->is('user/space/orders/all') ) active
                @endif
                " href="{{route('user-space-allorders')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Booking') }}</a>
                <a class="collapse-item 
                @if( request()->is('user/space/orders/pending') ) active
                @endif
                " href="{{route('user-space-pending.orders')}}"><i class="fas fa-angle-double-right"></i> {{ __('Pending Booking') }}</a>
                @endif
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#car" aria-expanded="true"
           aria-controls="collapseTable">
            <i class="fas fa-fw fa-car"></i>
    <span>{{__('Car')}}</span>
        </a>
        <div id="car" class="collapse 
        @if( request()->is('user/car') ) show
        @elseif( request()->is('user/car/orders/all') ) show
        @elseif( request()->is('user/car/orders/pending') ) show
        @elseif( request()->is('user/car/edit/*') ) show
        @endif
        " aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item 
                @if( request()->is('user/car') ) active
                @elseif( request()->is('user/car/create') ) active
                @elseif( request()->is('user/car/edit/*') ) active
                @endif
                " href="{{route('user-car-index')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Cars') }}</a>
                @if(App\Helpers\Helper::carCheck() == true)
                <a class="collapse-item 
                @if( request()->is('user/car/orders/all') ) active
                @endif
                " href="{{route('user-car-allorders')}}"><i class="fas fa-angle-double-right"></i> {{ __('All Booking') }}</a>
                <a class="collapse-item 
                @if( request()->is('user/car/orders/pending') ) active
                @endif
                " href="{{route('user-car-pending.orders')}}"><i class="fas fa-angle-double-right"></i> {{ __('Pending Booking') }}</a>
                @endif
            </div>
        </div>
    </li> 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#history" aria-expanded="true"
           aria-controls="collapseTable">
            <i class="fas fa-fw fa-newspaper"></i>
    <span>{{__('Order History')}}</span>
        </a>
        <div id="history" class="collapse 
        @if( request()->is('user/car/order/history') ) show
        @elseif( request()->is('user/hotel/order/history') ) show
        @elseif( request()->is('user/car/order/history') ) show
        @elseif( request()->is('user/space/order/history') ) show
        @elseif( request()->is('user/tour/order/history') ) show
        @endif
        " aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item 
                @if( request()->is('user/car/order/history') ) active
                @endif
                " href="{{route('user-order-history','car')}}"><i class="fas fa-angle-double-right"></i> {{ __('Cars Booking') }}</a>
                <a class="collapse-item 
                @if( request()->is('user/hotel/order/history') ) active
                @endif
                " href="{{route('user-order-history','hotel')}}"><i class="fas fa-angle-double-right"></i> {{ __('Hotel Booking') }}</a>
                <a class="collapse-item 
                @if( request()->is('user/tour/order/history') ) active
                @endif
                " href="{{route('user-order-history','tour')}}"><i class="fas fa-angle-double-right"></i> {{ __('Tour Booking') }}</a>
                <a class="collapse-item 
                @if( request()->is('user/space/order/history') ) active
                @endif
                " href="{{route('user-order-history','space')}}"><i class="fas fa-angle-double-right"></i> {{ __('Space Booking') }}</a>
            </div>
        </div>
    </li> 

    <li class="nav-item @if( request()->is('user/withdraws') ) active @endif ">
        <a class="nav-link" href="{{ route('user-withdraw-index') }}">
            <i class="fas fa-money-bill"></i>
            <span>{{ __('Withdraws') }}</span></a>
    </li>
</ul>
