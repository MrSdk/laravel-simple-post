@extends('layout',[ 'title' => "Home Component", 'route' => $route ?? '' ])

@section('bodyDashboard')

<div style="margin-top: 5%;" class="jumbotron">
  <h1 class="display-4">Welcome, to Post application</h1>
  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <hr class="my-4">
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/posts" role="button">Join</a>
  </p>
</div>
 
@endsection('bodyDashboard')