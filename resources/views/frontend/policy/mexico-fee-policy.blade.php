@extends('frontend.layouts.app')
@section('content')
<div class="wrapper">

	<div class="fee-policy-content">
		<h2>{{__('sentence.fee-policy')}}</h2>
		<p>{{__('sentence.fee-policy-para1')}}</p>
		<ul>
	    	<li>{{__('sentence.fee-policy-para1-op1')}}</li>
			<li>{{__('sentence.fee-policy-para1-op2')}}</li>
			<li>{{__('sentence.fee-policy-para1-op3')}}</li>
		</ul>
		<p>{{__('sentence.fee-policy-para2')}}</p>
		<ul>
			<li>{{__('sentence.fee-policy-para2-op1')}}</li>
			<li>{{__('sentence.fee-policy-para2-op2')}}</li>
			<li>{{__('sentence.fee-policy-para2-op3')}}</li>
			<li>{{__('sentence.fee-policy-para2-op4')}}</li>
		</ul>
		<p>{{__('sentence.fee-policy-para3')}}</p>
 
		<p>{{__('sentence.fee-policy-para4')}}</p>
 
		<p>{{__('sentence.fee-policy-para5')}}</p>
		
		<p>{{__('sentence.fee-policy-para6')}}</p>
		<p><em>{{__('sentence.fee-updated-at')}}</em></p>
	</div>

</div>    
@endsection




