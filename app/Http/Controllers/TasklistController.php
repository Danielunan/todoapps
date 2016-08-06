<?php namespace App\Http\Controllers;

use Redirect;
use App\Tasklist;
use App\Http\Requests;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class TasklistController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pageTitle='All Tasklists';
		$tasklists = Tasklist::with('tasks')->orderBy('created_at','desc')->custompaginate();

		return view('tasklists.index',compact('pageTitle','tasklists'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$pageTitle='Create new task list';

		return view('tasklists.create',compact('pageTitle'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\TasklistsRequest $request)
	{

		# add a slug
		$request->merge
		(
				array
				(
						'slug'=>Helpers::seo_url($request->input('title'))
				)
		);

		Tasklist::create($request->all());

		return Redirect::route('tasklist.index')->with('message', 'Tasklist was created');

	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tasklist = Tasklist::with('tasks')->findOrFail($id);
		$pageTitle=$tasklist->title;

		return view('tasklists.update',compact('pageTitle','tasklist'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Requests\TasklistsRequest $request)
	{
		$tasklist = Tasklist::with('tasks')->findOrFail($id);

		//
		$tasklist->update($request->all());

		return Redirect::back()->with('message', 'Tasklist successfully updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$tasklist= Tasklist::findOrFail($id);

		$tasklist->destroy($id);
		return Redirect::back()->with('message', 'Tasklist successfully deleted');
	}

}
