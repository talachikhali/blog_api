@extends('layouts.app')

@section('title', 'add category')

@section('content')

<form action="{{route('categories.update', $category)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group m-4">
        <label for="title">edit category:</label>
        <input type="text" class="form-control mb-2" name="name" id="title" value="{{$category->name}}">
        <input type="file" name="image" >
        <img src="{{asset('storage/' . $category->image)}}" alt="category image">
    </div>
    <button type="submit" class="btn btn-primary mx-4">Submit</button>

</form>
@endsection