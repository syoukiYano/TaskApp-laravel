<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //引数の$idはweb.phpの/folders/{id}/tasks/
    public function index(int $id){
        // $folders = Folder::all();
        $folders = Auth::user()->folders()->get();
        $current_folder = Folder::find($id);        

        //SELECT * FROM tasks WHERE(folder_id = $id);の意味 get()で実行。
        // $tasks = Task::where('folder_id',$current_folder->id)->get();
        $tasks = $current_folder->tasks()->get();//hasMany tasks()はApp/Folder.phpのメソッド
        if (Auth::user()->id !== $current_folder->user_id) {
            abort(403);
        }
        return view('tasks/index',[
            'folders'        => $folders,
            'folders_id'     => $id,
            'current_folder' => $current_folder,
            'tasks'          => $tasks,
        ]);        
    }
    public function create(int $id ,CreateTask $request){
        $current_folder = Folder::find($id);
        $task = new Task();
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $current_folder->tasks()->save($task);//tasks()はApp/Folder.phpのメソッド。
        return redirect()->route('tasks.index',['id'=>$current_folder->id,]);//{id}に$current_folder->id;
    }
    public function edit(int $id,int $tasks_id,CreateTask $request){
        $task = Task::find($tasks_id);
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
        return redirect()->route('tasks.index',['id'=>$task->folder_id]);
    }
    public function delete(int $id,int $tasks_id,Request $request){
        $task = Task::find($tasks_id);
        $task->delete();
        return redirect()->route('tasks.index',['id'=>$task->folder_id]);
    }
}
