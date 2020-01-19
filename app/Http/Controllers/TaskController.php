<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create() 
    {
        return view('task/create');
    }

    public function store() 
    {
        $data = request()->validate([
            'title' => 'required',
            // 'deadline' => 'required',
        ]);

        auth()->user()->diaries()->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);

        // return view('task/create');
        dd(request()->all());
    }
}
