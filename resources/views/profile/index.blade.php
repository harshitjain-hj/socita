@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profile_image }}" alt="Profile Pic" height ="180" width="180" class="rounded-circle">
        </div>
        <div class="col-9 pt-4">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-start">
                    <h1>{{ $user->username }}</h1>
                        <follow-button user-id="{{ $user->id }}"></follow-button>
                </div>
                @can('update', $user->profile)
                    @if( count($user->diaries) < 3 )
                        <a href="/diary/create">Add New Book</a>
                    @endif
                @endcan
            </div>
            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan
            <div class="d-flex">
                <div class="pr-5"><strong>500</strong> Tasks</div>
                <div class="pr-5"><strong>100</strong> Followers</div>
                <div class="pr-5"><strong>200</strong> Following</div>
            </div>
            <div class="pt-4">
                <div><strong>{{ $user->name }}</strong></div>
                <div>{{ $user->profile->title }}</div>
                <div>{{ $user->profile->description }}</div>
                <div><a href="{{ $user->profile->url }}">{{ $user->profile->url }}</a></div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($user->diaries as $diary)
            <div class="p-3 col-4">
                <div class="card">
                    <img src="{{ $diary->image }}" class="card-img-top" alt="Image url no longer exist">
                    <div class="card-body">
                        <h5 class="card-title">{{ $diary->title }}</h5>
                        <p>Created At - {{ $diary->created_at }}</p>
                        <p class="card-text">{{ $diary->description }}</p>

                        <!-- TODO: Disable this  -->
                        <a href="/diary/{{ $diary->id }}" class="btn btn-primary">Look</a>
                    </div>
                </div>
            </div>
        @endforeach
        
    </div>
</div>
@endsection
