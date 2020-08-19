@extends('layout',[ 'title' => "Posts" ])

@section('bodyDashboard')

<h1>All Posts </h1>
<hr>
<div class="row m-auto">
  @foreach( $posts ?? [] as $post )
    <div class="col-sm-5" style="margin: 5px;">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <img class="card-img-top" src="{{ asset('/uploads/post/'.$post->image ) }}" alt="Not found image">
            
            <p class="card-text" style="height: 50px; overflow: hidden">{{ $post->description }}</p>
            <a href="/posts/{{ $post->id }}" class="btn btn-primary">Read more..</a>
        </div>
        </div>
    </div>
  @endforeach
</div>
 
@endsection('bodyDashboard')