@extends('main')

@section('content')
<h2 class="display-4">Welcome {{$user->username}}, login successful!</h2>
<p><a class="btn btn-primary btn-lg text-right" href="/" role="button">Logout</a></p>
<hr class="my-4">
<p class="lead">You can enter your personal data into the fields listed or edit existing information</p>
<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal" id="userform" action="{{ url('users').'/'.$user->id }}" method="POST">
            <div class="form-group row">
                <label for="inputFirstName" class="control-label col-sm-2">First name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputFirstName" name="first_name" value="<?php echo isset($user->first_name) ? $user->first_name : "" ?>" placeholder="John">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputLastName" class="control-label col-sm-2">Last name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputLastName" name="last_name" value="<?php echo isset($user->last_name) ? $user->last_name : "" ?>" placeholder="Doe">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail" class="control-label col-sm-2">Email</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo isset($user->email) ? $user->email : "" ?>" placeholder="john.doe@example.com">
                </div>
            </div>
            <div class="form-group row">
                <div id=status>
                    <p> <?php echo isset($message) ? $message : "" ?> </p>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
