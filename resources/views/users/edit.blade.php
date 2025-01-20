@extends('layouts.app')

@section('title', 'update user')

@section('content')

<h1 class="m-4"> update user:</h1>

<form action="{{route("users.update", $user->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group m-4">
        <label for="name">user name:</label>
        <input type="text" class="form-control mb-2 text_dec" name="name" id="name" value="{{$user->name}}">
    </div>
    <div class="form-group m-4">
        <label for="email">user email:</label>
        <input type="email" class="form-control mb-2" name="email" id="email" value="{{$user->email}}">
    </div>
    <div class="form-group m-4">
        <label for="image">if you want to change the post image select a new one:</label><br>
        <input type="file" name="image" id="image">
    </div>
    @if ($user->image)
        <div class="form-group m-4 col-md-3">
        <img src="{{asset('storage/' . $user->image)}}" class="img-fluid rounded" alt="profile image">
        </div>
    @endif
    <div class="form-group m-4">
        <p class="text-secondary">if you don't want to change the password leave this empty!</p>
        <label for="password">Enter Your New Password:</label>
        <input type="password" class="form-control mb-2" name="password" id="password">
        <p class="text-secondary">must be at least 8 characters</p>

    </div>
    <div class="form-group m-4">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" class="form-control mb-2" name="password_confirmation" id="confirm_password">
    </div>
    <div class="form-group m-4">
        <div class="form-check">
                <input class="form-check-input" type="checkbox" value="admin" name="role" id="admin" <?php if($user->hasRole('admin')) echo 'checked' ?>>
                <label class="form-check-label" for="admin">
                    admin
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary m-4">Submit</button>
</form>

@endsection