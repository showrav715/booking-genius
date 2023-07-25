
@foreach ($rooms as $k => $room)
@php

    if($stock){
    if(isset($stock[$k]) && in_array($room->id ,$extra_room)){
        $stock_val = $stock[$k];
        
    }else{
        $stock_val = $room->stock;
    }

    }else{
        $stock_val = $room->stock;
    }


@endphp



<div class="single-room">
    <div class="image" data-toggle="modal" data-target="#staticBackdrop"> 
        @if (count($room->gallery->where('type','hotel_room')) > 0)
        <img src="{{asset('assets/images/hotel-image/room/'.$room->gallery->where('type','hotel_room')[0]->image)}}" alt="">
        @else
        <img src="{{asset('assets/images/placeholder.jpg')}}" alt="">
        @endif
       
        <div class="count-gallery"><i class="fas fa-image"></i>
            {{count($room->gallery->where('type','hotel_room')->where('imagable_id',$room->id))}}
        </div>
    </div>
    <div class="hotel-info">
        <h3 class="room-name">{{$room->room_name}}</h3>
        <ul class="room-meta">
            <li>
                <div class="item">
                    <i class="fas fa-compass"></i>
                    <span>{{$room->square_fit}} {{__('sqft')}}</span>
                </div>
            </li>
            <li>
                <div class="item">
                    <i class="fas fa-bed"></i>
                    <span>x{{$room->bed}} {{__('bed')}}</span>
                </div>
            </li>
            <li>
                <div class="item"><i class="fas fa-users"></i>
                <span>x {{$room->adult}} {{__('Adult')}}</span>
                </div>
            </li>
            <li>
                <div class="item"><i class="fas fa-child fa"></i>
                    <span>x{{$room->children}} {{__('Children')}}</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="hotel-room">
        @php
            $per_price = 0;
        @endphp
        <p class="price_date_wise"></p>
        <select class="form-control per_night_cost" data-target="{{PriceHelper::showPrice($room->per_night_cost)}}"  data-href="{{$room->id}}" name="per_night_cost" id="per_night_cost">
            <option value="" selected>{{__('Select Room')}}</option>
            @php
                for($i=1;$i<=$stock_val;$i++){
                    $per_price = $room->per_night_cost * $i;
                    echo '<option value="'.$i.'">'.$i.' Room  </option>';
                }
            @endphp
        </select>
    </div>
</div>

@endforeach