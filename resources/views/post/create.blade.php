@extends('layouts.master')


@section('contents')

<div class="col-md-8 blog-main">

	<h1> Publish a Post </h1>

	<hr>

	<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
		
		{{ csrf_field() }}

		<div class="form-group">
			
			<label for="title">Title:</label>
			
			<input type="text" class="form-control" id="title" name="title">

		</div>

		<div class="form-group">
			
			<label for="body">Body</label>
			
			<textarea id="body" name="body" class="form-control"></textarea>	
		
		</div>

		<div class="form-group">
			
			<label for="description">Image Title:</label>
			
			<input type="text" class="form-control" id="description" name="description" placeholder="Please insert your image title here">

		</div>

		<div class="form-group">
			
			<label for="image">Image</label>
			
			<input type="file" class="form-control" id="image" name="image" accept="image/*">

		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Publish</button>	
		</div>
		
		@include('layouts.errors')

	</form>


</div>

@endsection 