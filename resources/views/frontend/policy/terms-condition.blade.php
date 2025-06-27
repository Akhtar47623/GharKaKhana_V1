@extends('frontend.layouts.app')
@section('content')
<!-- Termly Tracking Code -->
<style>
		/* This only works with JavaScript, 
		   if it's not present, don't show loader */
		   .Iframe-content-97a9de img {
		   		display: none;
		   }
		
</style>
<div name="termly-embed" data-id="a2d3a97c-63d7-4bae-a470-d95dd3d3de36" data-type="iframe"></div>
<script type="text/javascript">(function(d, s, id) {
  var js, tjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://app.termly.io/embed-policy.min.js";
  tjs.parentNode.insertBefore(js, tjs);
}(document, 'script', 'termly-jssdk'));</script>
@endsection