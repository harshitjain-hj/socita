<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Diary;
use App\Task;


class TaskController extends Controller
{
    public function create($diary) 
    {
        $diary = Diary::findOrFail($diary);
        if(auth()->user()->id == $diary->user_id){
            // dd(auth()->user()->id == $diary->user_id);
            return view('task/create', compact('diary'));
        }
        else{
            return redirect('/diary/' . $diary->id);
        }        
    }

    public function store($diary) 
    {
        $diary = Diary::findOrFail($diary);

        $data = request()->validate([
            'title' => 'required',
            'deadline' => 'required',
        ]);

        $diary->tasks()->create([
            'title' => $data['title'],
            'deadline' => $data['deadline'],
        ]);

        // dd(request()->all());
        // dd($diary);
        return redirect('/diary/' . $diary->id);    
    }

    public function edit($diary, $task)
    {
        $task = Task::findOrFail($task);
        $diary = Diary::findOrFail($diary);
        if(auth()->user()->id == $diary->user_id){
            // dd(auth()->user()->id == $diary->user_id);
            return view('task/edit', compact('task', 'diary'));
        }
        else{
            return redirect('/diary/' . $task->diary_id);
        }   
    }

    public function update($diary, $task)
    {
        $task = Task::findOrFail($task);

        $data = request()->validate([
            'title' => 'required',
            'deadline' => 'required',
        ]); 
        
        $task->update($data);

        // dd($data);
        return redirect('/diary/' . $task->diary_id);
    } 
}
