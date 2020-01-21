<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class RatingController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function create($task) 
    {
        $task = Task::findOrFail($task);
        
        // dd($task);
         return view('rating/create', compact('task'));
                
    }

    public function store($task) 
    {
        $task = Task::findOrFail($task);

        $data = request()->validate([
            'rating' => 'required',
            'comment' => '',
        ]);

        $task->ratings()->create([
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        // dd(request()->all());
        // dd($task);
        return redirect('/diary/' . $task->diary_id);    
    }
}
