@extends('layouts.master')


@section('contents')

<div class="col-md-8 blog-main">

	<h1> Edit a Post </h1>

	<hr>

	<form method="POST" action="/posts">
		
		{{ csrf_field() }}

		<div class="form-group">
			
			<label for="title">Title:</label>
			
			<input type="text" class="form-control" id="title" name="title" value="{{ post->title }}">

		</div>

		<div class="form-group">
			
			<label for="body">Body</label>
			
			<textarea id="body" name="body" class="form-control">{{ post->body }}</textarea>	
		
		</div>

		<div class="form-group">
			
			<label for="description">Image Title:</label>
			
			<input type="text" class="form-control" id="description" name="title" value="{{ post->description }}">

		</div>

		<div class="form-group">
			
			<label for="image">Image</label>
			
			<input type="file" class="form-control" id="image" name="image" accept="image/*">

		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Update</button>	
		</div>
		
		@include('layouts.errors')

	</form>


</div>

@endsection 