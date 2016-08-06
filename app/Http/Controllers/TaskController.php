<?php namespace App\Http\Controllers;

use App\Tasklist;
use Redirect;
use App\Task;
use App\Http\Requests;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class TaskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pageTitle='All Tasks';
		$tasks = Task::has('tasklist')->with('tasklist')->whereStatus('ACTIVE')->orderBy('duedate','desc')->custompaginate();



		return view('tasks.index',compact('pageTitle','tasks'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$pageTitle='Create new task';

		return view('tasks.create',compact('pageTitle'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\TasksRequest $request)
	{
		Task::create($request->all());

		return $request->input('title').' was successfully added';
	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$task = Task::has('tasklist')->with('tasklist')->findOrFail($id);

		return $task;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Requests\TasksRequest $request)
	{
		$Task = Task::has('tasklist')->with('tasklist')->findOrFail($id);


		$Task->update($request->all());

		return $request->input('title').' was successfully updated';
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$Task= Task::findOrFail($id);

		$Task->destroy($id);
		return 'Tasks was successfully deleted';
	}

	# get tasks by status
	public function getByStatus($status){
		$tasks=Task::has('tasklist')->with('tasklist')->whereStatus(strtoupper($status))->orderBy('duedate','desc')->custompaginate();

		if($tasks){
			$pageTitle = ucfirst($status).' Tasks';

			return view('welcome.index',compact('pageTitle','tasks'));

		}
	}

	# get tasks by list
	public function getByList($list){
		$tasklist=Tasklist::whereSlug($list)->first();
		if($tasklist){
			$tasks=Task::has('tasklist')->with('tasklist')->where('tasklist_id',$tasklist->id)->orderBy('duedate','desc')->custompaginate();

			$pageTitle = ucfirst($tasklist->title).' Tasks';

			return view('welcome.index',compact('pageTitle','tasks'));
		}

	}

	# get tasks by status
	public function searchForTasks($title){
		$tasks=Task::search_for_task($title);

		return $tasks;
	}

}
