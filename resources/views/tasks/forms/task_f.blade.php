@if(session()->has('message'))
    <div class="alert alert-success">
        {!! session('message') !!}
    </div>
@endif

<div class="form-group">
    <label >Task</label>
    <input name="title" value="{!! @isset($task)?$task->title:'' !!}" type="text" class="form-control"  placeholder="Enter task name">
    {!! $errors->first('title','<p class="text-error">:message</p>') !!}
</div>
<label>Due date</label>
<div class="input-group">
    <input type="text" name="duedate" value="{!! @isset($task)?$task->duedate:'' !!}" class="form-control" placeholder="Select due date" id="datepicker">
    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
    {!! $errors->first('duedate','<p class="text-error">:message</p>') !!}
</div><!-- input-group -->





<div style="margin-top: 10px;" class="form-group">
    <label >Tasklist</label>
    {!! Form::select('tasklist_id',\App\Tasklist::lists('title','id'),isset($task)?$task->tasklist_id:'',array('class'=>'select2 populate','data-live-search'=>'true')) !!}
    {!! $errors->first('tasklist_id','<p class="error">:message</p>') !!}

</div>

@if(isset($task))
    <div style="margin-top: 10px;" class="form-group">
        <label >Status</label>

        <select name="status" class="select2 populate" data-live-search="true" data-placeholder="Choose a status...">
            <option selected value="{!! $task->status !!}">{!! $task->status !!}</option>
            <option value="ACTIVE">ACTIVE</option>
            <option value="COMPLETE">COMPLETE</option>

        </select>


    </div>
@endif


<div style="margin-top: 10px;" class="form-group">
    <button type="submit" class="btn btn-purple waves-effect waves-light">{!! $buttonName !!}</button>
</div>
