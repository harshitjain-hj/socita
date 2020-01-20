@extends('layouts.app')

@section('content')

    
<div class="container">
    <div class="card-group">
    @foreach($diaries as $diary)
    <!-- <div class="p-3 col-4"> -->
        <div class="card">
            <img src="{{ $diary->image }}" class="card-img-top" alt="Cover Image">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title">{{ $diary->title }}</h5>
                        <p class="card-text">{{ $diary->description }}</p>
                        <p class="card-text"><small class="text-muted">{{ $diary->created_at }}</small></p>
                    </div>
                    <div class="col-4 align-self-center">
                        <a href="/diary/{{ $diary->id }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        </div>
        @endforeach    
    </div>
</div>


@endsection
