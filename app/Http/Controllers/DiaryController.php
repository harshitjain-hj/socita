<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;

class DiaryController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        

        $diaries = Diary::whereIn('user_id', $users)->orderBy('created_at', 'DESC')->get();
        // dd($diaries);
        return view('diary/index', compact('diaries'));
    }
    
    public function create()
    {
        // checking whether the user has created enough diaries
        if( auth()->user()->diaries()->count() < 3 )
            return view('diary/create');    
        else
            return redirect('/profile/' . auth()->user()->id);
        // dd(auth()->user()->diaries()->count());
    }
    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|url',
        ]);

        // create the diary according to the data
        auth()->user()->diaries()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);

        // dd(request()->all());
        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Diary $diary)
    {
        // dd($diary);
        return view('diary/show', compact('diary'));
    }
}
