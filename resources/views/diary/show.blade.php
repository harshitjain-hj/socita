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
                <div class="col-4 align-self-center">
                    <a href="/diary/task/create" class="btn btn-primary">Add new Task</a>
                </div>
            </div>
        </div>        
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Cras justo odio</li>
            <li class="list-group-item">Dapibus ac facilisis in</li>
            <li class="list-group-item">Vestibulum at eros</li>
        </ul>
    </div>
</div>
@endsection
