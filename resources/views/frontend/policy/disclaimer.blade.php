@extends('frontend.layouts.app')
@section('content')
<!-- Termly Tracking Code -->
<style>
		/* This only works with JavaScript, 
		   if it's not present, don't show loader */
		   .Iframe-content-97a9de img {
		   		display: none;
		   }
		.no-js #loader { display: none;  }
		.js #loader { display: block; position: absolute; left: 100px; top: 0; }
	</style>
<div name="termly-embed" data-id="794c8a76-6a34-4605-ac89-8c1c5e1a651d" data-type="iframe"></div>
<script type="text/javascript">(function(d, s, id) {
  var js, tjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://app.termly.io/embed-policy.min.js";
  tjs.parentNode.insertBefore(js, tjs);
}(document, 'script', 'termly-jssdk'));</script>
@endsection