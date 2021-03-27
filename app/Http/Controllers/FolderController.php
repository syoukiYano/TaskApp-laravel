<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//Auth

class FolderController extends Controller
{
    public function index(){
        $folders = Auth::user()->folders()->first();  
        if(is_null($folders)){
            return view('home');
        }
        return redirect()->route('tasks.index', ['id' => $folders->id,]);
    }

    public function create(CreateFolder $request){
        $folder = new Folder();
        $folder->title = $request->title;
        Auth::user()->folders()->save($folder);
        // $folder->save();
        return redirect()->route('tasks.index',['id'=>$folder->id,]);//{id}に$folder->id;
    }
}
