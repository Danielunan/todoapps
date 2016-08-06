@extends('_layouts.public')

@section('content')
        <!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="pull-left page-title">{!! $pageTitle !!}</h4>

    </div>
</div>

<div class="row">

    <!-- Left sidebar -->
    @include('_partials.public_left_sidebar')
    <!-- End Left sidebar -->
    <ui-view>   </ui-view>



</div>
<!-- End row -->
@stop