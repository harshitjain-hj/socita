@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/diary/{{ $diary->id }}/task/{{ $task->id }}" method="post">
        @csrf
        
        @method('PATCH')

        <div class="row">
            <div class="col-8 offset-2">
                <div class="row">
                    <h1>Edit Task</h1>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Task</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $task->title}}"  autofocus>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror    
                </div>                        
                <div class="form-group row">
                    <label for="deadline" class="col-md-4 col-form-label">Deadline</label>
                        <input id="deadline" type="text" class="form-control @error('deadline') is-invalid @enderror" name="deadline" value="{{ old('deadline') ?? $task->deadline }}" autofocus>
                        @error('deadline')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                    
                </div>
                <div class="row pt-3">
                    <button class="btn btn-primary">Edit</button>
                </div>    
            </div>
        </div>
    </form>
</div>
@endsection
