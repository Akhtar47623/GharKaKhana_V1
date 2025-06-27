
	<!--scripts starts here-->	 
    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/menu.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/backend/bower_components/jquery-ui/jquery-ui.js')}}"></script>
	<script type="text/javascript">
	$(document).ready(function(){$("#search").autocomplete({source:"{{ url('autocompleteajax') }}"}).data("ui-autocomplete")._renderItem=function(e,a){var i="<div>"+a.heading+'</div><a href="'+a.url+'" ><div class="list_item_container"><div class="image"><img src="'+a.image+'" ></div><div class="label"><h4><b>'+a.title+"</b></h4></div></div></a>";return $("<li></li>").data("item.autocomplete",a).append(i).appendTo(e)}});
	</script>
    @yield('pagescript')  
    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.selectbox.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/general.js')}}"></script>    
	<script src="{{asset('public/backend/toastr.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/pages/home.js')}}"></script>
	<script src="{{asset('public/frontend/js/jquery.raty.js')}}"></script>
	<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
	<script src="{{asset('public/frontend/js/pages/review-rating.js')}}"></script>
	<script type="text/javascript" src="https://app.termly.io/embed.min.js" data-auto-block="on" data-website-uuid="90ac6305-05ab-4de0-91de-ecdb8728697d">
	<script type="text/javascript">if(location.hash=='#_=_'){location.replace(location.href.split('#')[0])}</script>
	{!! Toastr::message() !!}  
<!--scripts ends here-->

