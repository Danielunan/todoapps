<?php namespace App\Http\Controllers;

use Redirect;
use App\Task;
use App\Tasklist;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller {


	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pageTitle='All Tasks';
		$tasks= Task::with('tasklist')->orderBy('created_at','desc')->custompaginate();

		return view('welcome.index',compact('tasks','pageTitle'));
	}

	# get all tasks
	public function getAllTasks()
	{
		$tasks= Task::with('tasklist')->orderBy('created_at','desc')->get();

		return $tasks;
	}

	# get all tasks
	public function getAllTasklists()
	{
		$tasklists= Tasklist::with('tasks')->orderBy('created_at','desc')->get();

		return $tasklists;
	}

}
