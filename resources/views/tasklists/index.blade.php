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
                            <h4 id="todo-message"> <span id="todo-total">{!! $tasklists->count() !!}</span> Lists</h4>
                        </div>

                    </div>



                    {!! Form::open(array('route' => 'tasklist.store', 'class' => 'm-t-20 normalForm', 'role' => 'form')) !!}

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {!! session('message') !!}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-9 todo-inputbar">
                            <input type="text" id="title" name="title" class="form-control" placeholder="Add new tasklist">
                            {!! $errors->first('title','<p class="error">:message</p>') !!}
                        </div>
                        <div class="col-sm-3 todo-send">
                            <button class="btn-primary btn-block btn waves-effect waves-light" type="submit" id="todo-btn-submit">Add</button>
                        </div>
                    </div>

                    {!! Form::close() !!}


                    <ul class="list-group no-margn todo-list"  id="todo-list" >
                        @foreach($tasklists as $tasklist)
                            @if($tasklist->id==1)
                                <li class="list-group-item">
                                    <div class="checkbox checkbox-primary">

                                        <label for="6">
                                            {!! $tasklist->title !!}


                                        </label>


                                    </div>
                                </li>
                            @else
                                <li class="list-group-item">
                                    <div class="checkbox checkbox-primary">

                                        <label for="6">
                                            <a href="{!! URL::route('tasklist.edit',$tasklist->id) !!}">{!! $tasklist->title !!}</a>


                                        </label>


                                        {!! Form::open(array('route'=>array('tasklist.destroy',$tasklist->id),'method'=>'delete','class'=>'destroy pull-right')) !!}
                                        {!! Form::submit('Trash',array('class'=>'btn btn-danger btn-xs')) !!}
                                        {!! Form::close() !!}


                                    </div>
                                </li>
                            @endif

                        @endforeach

                    </ul>


                </div>
            </div>


        </div> <!-- panel -->
    </div> <!-- end Col-9 -->

</div>
<!-- End row -->
@stop