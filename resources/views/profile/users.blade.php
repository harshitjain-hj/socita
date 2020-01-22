@extends('layouts.app')

@section('content')

    
<div class="container">
    <div class="card-deck">
        @foreach($users as $user)
            <div class="card col-md-3 ">
                <img src="{{ $user->profile->profile_image }}" class="card-img-top rounded-circle img-fluid" height ="130" width="130">
                <div class="card-body justify-content-center">
                    <h4 class="card-title"><a href="/profile/{{ $user->id }}">{{ $user->username }}</a></h4>
                    <div><strong>{{ $user->name }}</strong></div>
                    <div>{{ $user->profile->title }}</div>
                    <div>{{ $user->profile->description }}</div>
                    <div><a href="{{ $user->profile->url }}">{{ $user->profile->url }}</a></div>
                    <p class="card-text"><small class="text-muted"></small></p>
                </div>
                <div class="card-footer">
                <small class="text-muted">Joined at - {{ $user->created_at }}</small>
                </div>
            </div>    
        @endforeach
    </div>        
</div>


@endsection
