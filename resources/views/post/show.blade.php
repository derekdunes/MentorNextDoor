@extends('layouts.master')

@section('contents')
	
	<div class="col-md-10 blog-main">
		      <!-- <h3 class="pb-3 mb-4 font-italic border-bottom">
		        From the Firehose
		      </h3> -->

		      <div class="blog-post">
		        <h2 class="blog-post-title border-bottom">
		        		{{ $post->title }}
		    	</h2>

		        <p class="blog-post-meta">
					{{ $post->updated_at->format('F d, Y') }} by
					<a href="#">{{ $post->user->name }}</a></p>

				<p>
					<img src="{{ url(Config::get('image.upload_folder') .
					 '/' . $post->image) }}" alt="{{ $post->descrption }}" style="width:100%; height: 400px">
				</p>

				@foreach($post->bits as $bit)

					@if($bit->body_type == 0)
						<h3 class="pb-3 mb-4 font-italic border-bottom">
		        			{{ $bit->body }}
		      			</h3>
					@endif

					@if($bit->body_type == 1)
						<p>
							{{ $bit->body }}
						</p>
					@endif

					@if($bit->body_type == 2)
						<p>
							<img src="{{ url(Config::get('image.upload_folder') .
					 '/' . $bit->body) }}" alt="" style="width:100%; height: 400px">
						</p>
					@endif

					@if($bit->body_type == 3)
						<blockquote>
				          	<p>
				          		<iframe width="100%" height="420px" src="{{ $bit->body }}"></iframe>
							</p>
				        </blockquote>
					@endif

				@endforeach

	<nav class="blog-pagination">
		@guest
			<a class="btn btn-outline-primary" href="{{ url(route('posts.index')) }}">back</a>
        	<a class="btn btn-outline-primary" href="#">Older</a>
        	<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
		@else
			<a class="btn btn-outline-primary" href="{{ url(route('posts.index')) }}">back</a>
			<a class="btn btn-outline-primary" href="{{ url(route('posts.edit',$post->id)) }}">Edit</a>
        	<a class="btn btn-outline-primary" href="#">Older</a>
        	<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
		@endguest

      </nav>

      <hr>
    	
    	<div class="comments">
		    <ul class="list-group">
		        		
		        	
		        	@foreach($post->comments as $comment)

		        		<li class="list-group-item">
		        			<strong>
		        				{{ $comment->created_at->diffForHumans() }}
		        			</strong>
		        			{{ $comment->body }}: &nbsp;
		        		</li>

		        	@endforeach

		    </ul>
		</div>

		<hr>

		<div class="card">
			<div class="card-block">
				<form method="POST" action="/posts/{{  $post->id }}/comments">
					{{ csrf_field() }}

					<div class="form-group">
						<textarea name="body" placeholder="Your comment here." class="form-control" required>
							
						</textarea>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Add Comment</button>
					</div>
				</form>

				@include('layouts.errors')

			</div>
			
		</div>



    </div><!-- /.blog-main -->

</div>

@endsection
