<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/images/genarel-settings/'.$gs->header_logo) }}" alt="" >
        </div>

      </a>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>{{ __('Dashboard') }}</span></a>
      </li>

      @if(Auth::guard('admin')->user()->role == 0)
        @include('admin.load.roles.super')
      @else
        @include('admin.load.roles.normal')
      @endif
</ul>