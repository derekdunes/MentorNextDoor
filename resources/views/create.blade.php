<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Blog Template · Bootstrap</title>

    <!-- Bootstrap core CSS -->
<!-- <link href="https://getbootstrap.com/docs/4.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"> -->

<link href="./css/bootstrap.min.css" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./css/blog.css" rel="stylesheet">
  </head>

<body>

	<div class="container">

		<!-- include the navigation view-->
		@include("layouts.header")

		<!-- include the navigation view-->
		@include("layouts.nav")

		@yield('carousel')


	</div>

	<main role="main" class="container">
		
		<div class="row">

			<div class="col-md-12 blog-main">

				<h1>Url Shortener</h1>

				<form method="POST" action="/store">
					
					{{ csrf_field() }}

					<div class="form-group">
						<input type="link" class="form-control" id="link" name="link" placeholder="Insert your URL here and Click the submit button">
					</div>

					<div class="form-group">
						<button type="submit" class=" btn btn-primary">Shorten</button>
					</div>
					<div class="form-group">
						{{ $link }}	
					</div>
					
					@include('layouts.errors')

				</form>
			
			</div>
		
		</div>

	</main>
	<!-- include the footer layout -->
	@include ("layouts.footer");

</body>

</html>