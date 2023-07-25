@extends('layouts.load')

@section('content')

            <div class="content-area">
              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                    
                                      <div class="row" >
                                        <div class="col-md-6 offset-md-4">
                                        <p>{{ __('Use the BB codes, it show the data dynamically in your emails.') }}</p>
                                        <br>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>{{ __('Meaning') }}</th>
                                                <th>{{ __('BB Code') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{ __('Customer Name') }}</td>
                                                <td>{customer_name}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Order Amount') }}</td>
                                                <td>{order_amount}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Admin Name') }}</td>
                                                <td>{admin_name}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Admin Email') }}</td>
                                                <td>{admin_email}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Website Title') }}</td>
                                                <td>{website_title}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Order Number') }}</td>
                                                <td>{order_number}</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                        </div>
                                        </div>

                      <form id="ModalFormSubmit" action="{{route('admin-mail-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">
                          <label for="type">{{ __('Email Type') }}</label>
                        <input type="text" class="form-control" disabled="" value="{{$data->email_type}}" id="type" placeholder="{{ __('Email Type') }}">
                        </div>


                        <div class="form-group">
                          <label for="type">{{ __('Email Subject') }}</label>
                        <input type="text" class="form-control" name="email_subject" value="{{$data->email_subject}}" id="type" placeholder="{{ __('Email Subject') }}">
                        </div>


                        <div class="form-group">
                          <label for="description">{{ __('Email Body') }}</label>
                          <textarea id="area1" class="form-control nic-edit" name="email_body" placeholder="{{ __('Email Body') }}">{{$data->email_body}}</textarea>
                      </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection