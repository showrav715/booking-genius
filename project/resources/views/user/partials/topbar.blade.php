
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
       
        <li class="nav-item dropdown no-arrow mx-1"> 
            <a class="nav-link" href="{{route('front.index')}}" target="_blank"> <i class="fas fa-globe-americas text-white"></i></a>
        </li>
      
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow mx-1" id="notf_order"> 
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter" data-href="{{ route('user-notification-count') }}" id="order-notf-count">{{App\Models\UserNotification::countNotification(Auth::user()->id)}}</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
               
                <div data-href="{{ route('user-order-notf-show') }}" id="order-notf-show">
                </div>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle ShowLanguageImage" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
               <img class="img-profile rounded-circle " src="{{Auth::guard('web')->user()->photo ? asset('assets/images/users/'.Auth::guard('web')->user()->photo) :  asset('assets/images/noimage.png')}}" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::guard('web')->user()->name }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('user-profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{ __('Profile') }}
                </a>
                <a class="dropdown-item" href="{{route('user-reset')}}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{ __('Settings') }}
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('user-logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{ __('Logout') }}
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="m-3">
@include('includes.form-success')
</div>
