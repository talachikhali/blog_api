@extends('layouts.app')

@section('title', 'home')

@section('content')

<div class="m-3 ">
<h4>Admin :{{Illuminate\Support\Facades\Auth::user()->name }} </h4>
<p>number of users in the system: {{$count_users}}</p>
<p>number of ucategories in the system: {{$count_categories}}</p>
<p>number of tags in the system: {{$count_tags}}</p>
</div>
@endsection