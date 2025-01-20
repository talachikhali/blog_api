@extends('layouts.app')


@section('title', 'login')

@section('content')
<h1>Admin Login:</h1>
<form action="{{route('login')}}" method="POST">
    @csrf
    <div class="form-group m-4">
        <label for="email">Email:</label>
        <input type="email" class="form-control mb-2" placeholder="enter you email" name="email" id="email">
    </div>
    <div class="form-group m-4">
        <label for="password">password:</label>
        <input type="password" class="form-control mb-2" placeholder="enter you password" name="password" id="password">
    </div>
    <input type="submit" class="btn btn-primary mx-4" value="login">
</form>

@endsection