@extends('layouts.app')

@section('title', 'categories')

@section('content')

<a href="{{route('categories.create')}}" class="btn btn-secondary m-2">add categories</a>

@if($categories)
    <div class="m-3">
        <h6>
            Categories:
        </h6>
        @foreach ($categories as $category)

            <div class="card m-2" style="width: 18rem;">
                <img src="{{asset('storage/' . $category->image)}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$category->name}}</h5>
                    <div>
                        <a href="{{route('categories.edit', $category)}}" class="btn btn-primary m-3">edit</a>
                        <form action="{{route('categories.destroy', $category)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger m-1">delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@else
    <p>no tags available</p>
@endif
@endsection