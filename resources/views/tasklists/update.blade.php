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

    <!-- Right Sidebar -->
    <div class="col-lg-9 col-md-8">

        <div class="panel panel-default m-t-20">
            <div class="panel panel-default">

                <div class="panel-body todoapp">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 id="todo-message"></span>Update List</h4>
                        </div>

                    </div>

                    {!! Form::model($tasklist,array('route'=>array('tasklist.update',$tasklist->id),'method'=>'put', 'class' => 'm-t-20 normalForm', 'role' => 'form')) !!}

                    <div class="row">
                        <div class="col-sm-9 todo-inputbar">
                            <input value="{!! isset($tasklist->title)?$tasklist->title:'' !!}" type="text" id="title" name="title" class="form-control" placeholder="Add new tasklist">
                            {!! $errors->first('title','<p class="error">:message</p>') !!}
                        </div>
                        <div class="col-sm-3 todo-send">
                            <button class="btn-primary btn-block btn waves-effect waves-light" type="submit" id="todo-btn-submit">Go</button>
                        </div>
                    </div>

                    {!! Form::close() !!}


                </div>
            </div>


        </div> <!-- panel -->
    </div> <!-- end Col-9 -->

</div>
<!-- End row -->
@stop