<?php

use App\Tack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/tasklist',function(){
  $tasks = \App\Task::all();
  return view('tasklist',[
    "tasks" => $tasks,
    "errors" => session()->get("FORM_ERRORS"),
    "inputs" => session()->get("OLC_INPUTS"),
  ]);
});

Route::get('/task/{id}',function($id){
  $task = \App\Task::where("id",$id)->first();
  if($task === null){
    return abort(404);
  }else{
    return view("/task",[
      "task" => $task
    ]);
  }
});

Route::post('/task',function(){
  $rules = [
    "task_name" => ["required","max:10"]
  ];
  $val = validator(request()->all(),$rules);

  if($val->fails()){
    session()->flash("OLD_INPUTS",request()->all());
    session()->flash("FORM_ERRORS",$val->errors());
    return redirect("/tasklist");
  }
  $task = new \App\Task();
  $task->name = request("task_name");
  $task->save();
  return redirect("/tasklist");
});

Route::post('/task/delete/{id}',function($id){
  $task = \App\Task::where("id",$id)->first();
  if($task){
    $task->delete();
  }
  return redirect("/tasklist");
});

//'/'
Route::get('/',function(){
  $tacks = Tack::orderBy('created_at','asc')->get();

  return view('tacks',[
    'tacks' => $tacks
  ]);
});

//'/task'
Route::post('/tack',function(Request $request){
  $validator = Validator::make($request->all(),[
    'name' => 'required|max:255',
  ]);
  if($validator->fails()){
    return redirect('/')->withInput()->withErrors($validator);
  }
  $tack = new Tack();
  $tack->name = $request->name;
  $tack->save();

  return redirect('/');
});

//'/task/{task}'
Route::delete('/tack/{tack}',function(Tack $tack){
  $tack->delete();

  return redirect('/');
});
