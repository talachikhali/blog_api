@extends('layouts.app')

@section('title', 'create tag')

@section('content')

<form action="{{route('tags.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group m-4">
        <label for="title">add new tag:</label>
        <input type="text" class="form-control mb-2" name="name" id="title" placeholder="write the tag you want">
    </div>
    <button type="submit" class="btn btn-primary mx-4">Submit</button>

</form>
@endsection