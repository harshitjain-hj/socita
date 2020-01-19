@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/diary" method="post">
        @csrf
        <div class="row">
            <div class="col-8 offset-3">
                <div class="row">
                    <h1>Create Diary</h1>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Diary Name</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="name" autofocus>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror    
                </div>                        
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description" autofocus>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                    
                </div>
                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label">Book Cover</label>
                        <input id="image" type="text" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('nimage') }}" autocomplete="image" autofocus>
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                    
                </div>
                <div class="row pt-3">
                    <button class="btn btn-primary">Create</button>
                </div>    
            </div>
        </div>
    </form>
</div>
@endsection
