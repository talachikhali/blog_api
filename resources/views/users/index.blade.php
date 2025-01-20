@extends('layouts.app')

@section('title', 'Users')

@section('content')

<a href="{{route('users.create')}}" class="btn btn-secondary m-2">add users</a>
@forelse($users as $user)

    <div class="card m-2 col-md-6" style="width: 18rem;">
        <div class="card-body">
                <h5 class="card-title d-inline"><a class="link-offset-2 link-underline text-decoration-none text-dark"
                        href="{{ route('users.show', $user->id)}}">{{$user->name}} </a></h5>

            <p class="card-text">{{$user->email}}</p>
            <div class="d-flex justify-content-start">
                <a href="{{route('users.edit', $user)}}" class="btn btn-primary m-1">Update</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger m-1">Delete</button>
                </form>

                @if($user->hasRole(['user']))
                <form action="{{ route('users.block', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">Block</button>
                </form>
                @elseif($user->hasRole(['admin']))
                @else
                <form action="{{ route('users.unblock', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">Unblock</button>
                </form>
                @endif
            </div>
        </div>
    </div>


@empty
    <p>no users yet</p>
@endforelse

@endsection