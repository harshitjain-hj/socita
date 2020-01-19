@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/profile/{{ $user->id }}" method="post">
        @csrf

        @method('PATCH')

        <div class="row">
            <div class="col-8 offset-3">
                <div class="row">
                    <h1>Edit Profile</h1>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Status</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $user->profile->title }}" autocomplete="title" autofocus>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror    
                </div>                        
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') ?? $user->profile->description }}" autocomplete="description" autofocus>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                    
                </div>
                <div class="form-group row">
                    <label for="url" class="col-md-4 col-form-label">Links</label>
                        <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') ?? $user->profile->url }}" autocomplete="url" autofocus>
                        @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                    
                </div>
                <div class="form-group row">
                    <label for="profile_image" class="col-md-4 col-form-label">Profile Image</label>
                        <input id="profile_image" type="text" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image" value="{{ old('nimage') ?? $user->profile->profile_image }}" autocomplete="profile_image" autofocus>
                        @error('profile_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                    
                </div>
                <div class="row pt-3">
                    <button class="btn btn-primary">Update Profile</button>
                </div>    
            </div>
        </div>
    </form>
</div>
@endsection
