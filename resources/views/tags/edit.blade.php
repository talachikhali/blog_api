@extends('layouts.app')

@section('title', 'edit tag')

@section('content')

<form action="{{route('tags.update',$tag)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group m-4">
        <label for="title">edit tag:</label>
        <input type="text" class="form-control mb-2" name="name" id="title" value="{{$tag->name}}">
    </div>
    <button type="submit" class="btn btn-primary mx-4">Submit</button>

</form>
@endsection