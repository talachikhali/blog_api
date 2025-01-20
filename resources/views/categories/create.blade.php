@extends('layouts.app')

@section('title', 'add category')

@section('content')

<form action="{{route('categories.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group m-4">
        <label for="title">add new category:</label>
        <input type="text" class="form-control mb-2" name="name" id="title" placeholder="write the category name">
        <input type="file" name="image" >
    </div>
    <button type="submit" class="btn btn-primary mx-4">Submit</button>

</form>
@endsection