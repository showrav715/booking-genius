@extends('layouts.load')
@section('content')
<div class="content-area no-padding">
    <div class="add-product-content1">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description">
                    <div class="body-area">

                        <div class="table-responsive show-table">
                            <table class="table">
                                <tr>
                                    <th>{{ __("User ID#") }}</th>
                                    <td>{{$data->id}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("User Photo") }}</th>
                                    <td>
                                        <img width="200" height="200" class="rounded-circle" src="{{ $data->photo ? asset('assets/images/users/'.$data->photo):asset('assets/images/noimage.png')}}" alt="user">

                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("User Name") }}</th>
                                    <td>{{$data->name}}</td>
                                </tr>
                             
                                <tr>
                                    <th>{{ __("User Email") }}</th>
                                    <td>{{$data->email}}</td>
                                </tr>
                                @if($data->phone)
                                <tr>
                                    <th>{{ __("User Phone") }}</th>
                                    <td>{{$data->phone}}</td>
                                </tr>
                                @endif
                                @if($data->city)
                                <tr>
                                    <th>{{ __("User City") }}</th>
                                    <td>{{ $data->city }}</td>
                                </tr>
                                @endif
                                @if($data->state)
                                <tr>
                                    <th>{{ __("User State") }}</th>
                                    <td>{{ $data->state }}</td>
                                </tr>
                                @endif
                                @if($data->country)
                                <tr>
                                    <th>{{ __("User Country") }}</th>
                                    <td>{{ $data->country }}</td>
                                </tr>
                                @endif
                                @if($data->zip_code)
                                <tr>
                                    <th>{{ __("User Zip Code") }}</th>
                                    <td>{{ $data->zip_code }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>{{ __("Joined") }}</th>
                                    <td>{{$data->created_at->diffForHumans()}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection