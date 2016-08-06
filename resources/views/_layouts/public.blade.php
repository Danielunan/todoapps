<!DOCTYPE html>
<html ng-app="app">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{env('SITE_DESCRIPTION')}}">
    <meta name="author" content="{{env('SITE_AUTHOR')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{isset($pageTitle)?$pageTitle:env('SITE_NAME')}}</title>

    <!-- Base Css Files -->
    {!! HTML::style('css/bootstrap.min.css') !!}


            <!-- Font Icons -->
    {!! HTML::style('assets/font-awesome/css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}

            <!-- animate css -->
    {!! HTML::style('css/animate.css') !!}

            <!-- Waves-effect -->
    {!! HTML::style('css/waves-effect.css') !!}

            <!-- Plugins css -->
    {!! HTML::style('assets/notifications/notification.css') !!}

    {!! HTML::style('assets/timepicker/bootstrap-timepicker.min.css') !!}
    {!! HTML::style('assets/timepicker/bootstrap-datepicker.min.css') !!}
    {!! HTML::style('assets/select2/select2.css') !!}

    <!-- Custom Files -->
    {!! HTML::style('css/helper.css') !!}
    {!! HTML::style('css/style.css') !!}
    {!! HTML::style('css/overides.css') !!}


    {!! HTML::script('js/modernizr.min.js') !!}
    {!! HTML::script('js/jquery.min.js') !!}
    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::script('bower_components/angular/angular.min.js') !!}
    {!! HTML::script('bower_components/angular-ui-router/release/angular-ui-router.min.js') !!}
    {!! HTML::style('bower_components/angular-bootstrap-datepicker/dist/angular-bootstrap-datepicker.css') !!}
    {!! HTML::script('bower_components/angular-bootstrap-datepicker/dist/angular-bootstrap-datepicker.min.js') !!}
    {!! HTML::script('app/app.js') !!}



</head>



<body  >

<!-- Begin page -->
<div id="wrapper">





    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="col-md-8 col-md-offset-2">
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">
                    @yield('content')
                </div> <!-- container -->

            </div> <!-- content -->

        </div>
    </div>




</div>
<!-- END wrapper -->

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->



{!! HTML::script('js/waves.js') !!}
{!! HTML::script('js/wow.min.js') !!}
{!! HTML::script('js/jquery.nicescroll.js') !!}
{!! HTML::script('js/jquery.scrollTo.min.js') !!}
{!! HTML::script('assets/jquery-detectmobile/detect.js') !!}
{!! HTML::script('assets/fastclick/fastclick.js') !!}
{!! HTML::script('assets/jquery-slimscroll/jquery.slimscroll.js') !!}
{!! HTML::script('assets/jquery-blockui/jquery.blockUI.js') !!}

{!! HTML::script('assets/timepicker/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/select2/select2.min.js') !!}

{!! HTML::script('assets/notifications/notify.min.js') !!}
{!! HTML::script('assets/notifications/notify-metro.js') !!}




<!-- CUSTOM JS -->
{!! HTML::script('js/jquery.app.js') !!}
{!! HTML::script('js/commonFunctions.js') !!}
{!! HTML::script('js/my.js') !!}



</body>
</html>