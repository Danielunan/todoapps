<div class="col-lg-3 col-md-4">
    <a ui-sref="newTask" class="btn btn-danger waves-effect waves-light btn-block">New Task</a>
    <div class="panel panel-default p-0  m-t-20">
        <div class="panel-body p-0">
            <div class="list-group mail-list">
                <a ui-sref-active="active" ui-sref="home" class="list-group-item no-border "><i class="fa fa-download m-r-5"></i>All tasks</a>
                <a ui-sref-active="active" href="{!! URL::route('tasks.status','active') !!}" class="list-group-item no-border"><i class="fa fa-star-o m-r-5"></i>Active tasks <b>({!! \App\Task::status('active')->count() !!})</b></a>
                <a ui-sref-active="active" href="{!! URL::route('tasks.status','complete') !!}" class="list-group-item no-border"><i class="fa fa-star-o m-r-5"></i>Completed tasks <b>({!! \App\Task::status('complete')->count() !!})</b></a>

            </div>
        </div>
    </div>

    <h3 class="panel-title m-t-40">Task Lists</h3>

    <div class="list-group no-border">
        <a href="{!! URL::route('tasklist.index') !!}" class="list-group-item no-border active"></span>All</a>
        @foreach(\App\Tasklist::limit(5)->get() as $list)
            <a href="{!! URL::route('tasks.list',$list->slug) !!}" class="list-group-item no-border">{!! $list->title !!}</a>
        @endforeach

    </div>

</div>

