
<h6 class="dropdown-header">
    {{__('All Notification')}}
        <a href="javascript:;" data-href="{{route('order-notf-clear')}}" class="text-white float-right " id="order-notf-clear">{{__('Clear')}}</a>
  </h6>


      @foreach ($datas as $noty)
    
        @if ($noty->order_type == 'Tour')
            
          <a class="dropdown-item d-flex align-items-center" href="{{route('admin-tour-allorders')}}">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-dollar-sign"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">{{Carbon\Carbon::parse($noty->created_at)->diffForHumans()}}</div>
              <span class="font-weight-bold">{{__('A New Tour Order')}}</span>
            </div>
          </a>
        @endif
        @if ($noty->order_type == 'Hotel')
        <a class="dropdown-item d-flex align-items-center" href="{{route('admin-hotel-allorders')}}">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-dollar-sign"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">{{Carbon\Carbon::parse($noty->created_at)->diffForHumans()}}</div>
              <span class="font-weight-bold">{{__('A New Hotel Order')}}</span>
            </div>
          </a>
        @endif
        @if ($noty->order_type == 'Car')
        <a class="dropdown-item d-flex align-items-center" href="{{route('admin-car-allorders')}}">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-dollar-sign"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">{{Carbon\Carbon::parse($noty->created_at)->diffForHumans()}}</div>
              <span class="font-weight-bold">{{__('A New Car Order')}}</span>
            </div>
          </a>
        @endif
        @if ($noty->order_type == 'Space')
        <a class="dropdown-item d-flex align-items-center" href="{{route('admin-space-allorders')}}">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-dollar-sign"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">{{Carbon\Carbon::parse($noty->created_at)->diffForHumans()}}</div>
              <span class="font-weight-bold">{{__('A New Space Order')}}</span>
            </div>
          </a>
        @endif
        @if ($noty->order_type == 'User')
        <a class="dropdown-item d-flex align-items-center" href="{{route('admin-user-index')}}">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">{{Carbon\Carbon::parse($noty->created_at)->diffForHumans()}}</div>
              <span class="font-weight-bold">{{__('A New User Register')}}</span>
            </div>
          </a>
        @endif
      @endforeach
