@extends('layouts.app')

@section('title', 'show user')

@section('content')

<div class="d-flex justify-content-start">
        <div class="d-flex flex-column align-items-center ">
            <h1 class="m-3">{{$user->name}}</h1>
            <p class="m-3 text-center lead">
                {{ $user->email }}
            </p>
            <div class="m-3">
                <div class="d-flex justify-content-center m-4 ">
                    @can('updateorDelete', $user)
                        <a href="{{route('users.edit', $user)}}" class="btn btn-primary m-1">Update</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger m-1">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
        <div class="m-3 col-md-1 ">
            <img src="{{asset('storage/' . $user->image)}}" class="img-fluid rounded" alt="profile image">
        </div>

</div>

@endsection