@extends('main')

@section('content')
<h2 class="display-4">Welcome {{$user->username}}, login successful!</h2>
<p><a class="btn btn-primary btn-lg text-right" href="/" role="button">Logout</a></p>
<hr class="my-4">
<p class="lead">You can enter your personal data into the fields listed or edit existing information</p>
<div class="container-fluid">
    <form class="form-horizontal" id="userform" action="{{ url('users').'/'.$user->id }}" method="POST">
        <div class="form-group row d-flex align-items-center" style="width: 400px;">
            <label for="inputFirstName" style="flex-basis: 120px; font-weight: bold;">First name</label>
            <div class="flex-grow-1">
                <input type="text" class="form-control" id="inputFirstName" name="first_name" value="<?php echo isset($user->first_name) ? $user->first_name : "" ?>" placeholder="John">
            </div>
        </div>
        <div class="form-group row d-flex align-items-center" style="width: 400px;">
            <label for="inputLastName" style="flex-basis: 120px; font-weight: bold;" >Last name</label>
            <div class="flex-grow-1">
                <input type="text" class="form-control" id="inputLastName" name="last_name" value="<?php echo isset($user->last_name) ? $user->last_name : "" ?>" placeholder="Doe">
            </div>
        </div>
        <div class="form-group row d-flex align-items-center" style="width: 400px;">
            <label for="inputEmail" style="flex-basis: 120px; font-weight: bold;">Email</label>
            <div class="flex-grow-1">
                <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo isset($user->email) ? $user->email : "" ?>" placeholder="john.doe@example.com">
            </div>
        </div>
        <div class="form-group row d-flex align-items-center" style="width: 400px;">
            <div  class="flex-grow-1 d-flex justify-content-center">
                <p id=success-alert class="m-0" style="font-size:15px" > <?php echo isset($message) ? $message : "" ?> </p>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary ">Save</button>
            </div>
        </div>
    </form>
</div>
<script>
$("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});
</script>

@endsection
