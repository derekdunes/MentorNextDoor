@extends('layouts.master')

@section('contents')
	
	<div class="col-md-8 blog-main">
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

		        <p>{{ $post->body }}</p>

		        <blockquote>
		          	<p>
		          		<iframe width="100%" height="420px" src="{{ $post->utube }}"></iframe>
					</p>
		        </blockquote>
		        
		        <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
		        <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
		      </div><!-- /.blog-post -->

	<nav class="blog-pagination">
		<a class="btn btn-outline-primary" href="{{ url(route('posts.index')) }}">back</a>
        <a class="btn btn-outline-primary" href="#">Older</a>
        <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
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


@endsection
