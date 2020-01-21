@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/rate/{{ $task->id }}" method="post">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <div class="row">
                    <h1>Rate the Task</h1>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Rating</label>
                        <select id="rating" class="custom-select form-control @error('comment') is-invalid @enderror" name="rating" value="{{ old('rating') }}" autofocus>
                            <option selected>Open this select menu</option>
                            <option name="rating" value="1">GOOD</option>
                            <option name="rating" value="2">GREAT</option>
                            <option name="rating" value="3">AWESOME</option>
                        </select>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror    
                </div>                        
                <div class="form-group row">
                    <label for="comment" class="col-md-4 col-form-label">Comment</label>
                        <input id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" value="{{ old('comment') }}" autofocus>
                        @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                    
                </div>
                <div class="row pt-3">
                    <button class="btn btn-primary">Add</button>
                </div>    
            </div>
        </div>
    </form>
</div>
@endsection
