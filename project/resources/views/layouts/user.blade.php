<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/images/genarel-settings/'.$gs->favicon)}} " rel="icon">

    <title>{{$gs->website_title}}</title>

    @includeIf('admin.partials.style')
    @yield('style')
</head>

<body id="page-top">
    <div id="wrapper">


        @includeIf('user.partials.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @includeIf('user.partials.topbar')
                <div class="container-fluid" id="container-wrapper">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="complete_check" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('Confirm Order Complete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">{{ __('Are you sure?') }}.</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-success status_btn">{{ __('Complete') }}</a>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @includeIf('user.partials.scripts')
    @yield('script')

</body>

</html>