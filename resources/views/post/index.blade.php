
@extends('layouts.master')

@section('carousel')
	
	@include("layouts.carousel")

@endsection

@section('contents')
	
	<div class="col-md-8 blog-main">
		      <h3 class="pb-3 mb-4 font-italic border-bottom">
		        From the Firehose
		      </h3>

	@foreach ($posts as $post)
	 
		@include('post.post')<!-- /.blog-post -->
	
	@endforeach

	<nav class="blog-pagination">
        <a class="btn btn-outline-primary" href="#">Older</a>
        <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
      </nav>
    </div><!-- /.blog-main -->

@endsection