@extends('layouts.app')

@section('title', 'tags')

@section('content')

<a href="{{route('tags.create')}}" class="btn btn-secondary m-2">add tags</a>

@if($tags)
    <div class="m-3">
        <h6>
            Tags:
        </h6>
        @foreach ($tags as $tag)
            <div>
                <p class="d-inline"># {{$tag->name}}</p>
                <a href="{{route('tags.edit', $tag)}}" class="btn btn-primary m-3">edit</a>
                <form action="{{route('tags.destroy', $tag)}}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger m-1">delete</button>
                </form>
            </div>
        @endforeach

    </div>
@else
    <p>no tags available</p>
@endif
@endsection