@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <img src="{{ $diary->image }}" class="card-img-top" alt="Book cover design" style="max-height: 35em; ">    
        <div class="card-header card-body text-center">
            <div class="row">
                <div class="col-8">
                    <h2>{{ $diary->title }}</h2>
                    <h5>{{ $diary->description }}</h5>
                    <p>{{ $diary->created_at }}</p>
                </div>
                @if(auth()->user()->id == $diary->user_id)
                    <div class="col-4 align-self-center">
                        <a href="/diary/{{ $diary->id }}/task/create" class="btn btn-primary">Add new Task</a>
                    </div>
                @endif
            </div>
        </div>        
        <ul class="list-group list-group-flush">
            @foreach($diary->tasks as $task)
                <div class="d-flex bd-highlight list-group-item">
                    <span class="p-2 flex-grow-1 bd-highlight"><h5>{{ $task->title }}</h5></span>
                    <a href="/diary/{{$diary->id}}/task/{{$task->id}}/edit" class="p-2 bd-highlight text-danger">EDIT</a>
                    <a href="/rate/{{$task->id}}/create" class="p-2 bd-highlight text-info">RATE</a>
                    <span class="p-2 bd-highlight text-danger">{{ $task->deadline }}</span>
                </div>
            @endforeach
        </ul>
    </div>
</div>
@endsection
