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
                            <h4 id="todo-message"> Create New Task</h4>
                        </div>

                    </div>



                    <div class="panel-body">
                        {!! Form::open(array('route' => 'task.store', 'role' => 'form')) !!}

                            @include('tasks.forms.task_f',array('buttonName'=>'Add'))
                        {!! Form::close() !!}
                    </div>



                </div>
            </div>


        </div> <!-- panel -->
    </div> <!-- end Col-9 -->

</div>
<!-- End row -->
@stop