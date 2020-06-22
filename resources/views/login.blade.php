@extends('main')

@section('content')
<h1 class="display-4">Hello!</h1>
<p class="lead">This is a sample PHP laravel/lumen OIDC application</p>
<hr class="my-4">
<p >Try logging in</p>
<p class="lead">
    <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
</p>
@endsection