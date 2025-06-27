<div class="deznav">
	<div class="deznav-scroll">
		<ul class="metismenu" id="menu">
			<li>
				<a class="" href="{{route('chef-dashboard')}}" aria-expanded="false">
					<i class="fa fa-star"></i>
					<span class="nav-text">{{__('sentence.dashboard') }}</span>
				</a>
			</li>
			<li class="{{ request()->is('menu/*/edit') || request()->is('menu/create') ? 'mm-active' : '' }}">
				<a class="" href="{{ route('menu.index') }}" >
					<i class="flaticon-381-networking"></i>
					<span class="nav-text">Menu</span>
				</a>
				
			</li>
			<li>
				<a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
					<i class="fa fa-shopping-cart"></i>
					<span class="nav-text">{{__('sentence.order') }}</span>
				</a>
				<ul aria-expanded="false">
					<li><a  aria-expanded="false" href="{{ route('order.view') }}">{{__('sentence.orderq') }}</a></li>
					<li><a  aria-expanded="false"  href="{{ route('completed-order.view') }}">{{__('sentence.completeorder') }}</a></li>
				</ul>
			</li>
			<li>
				<a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
					<i class="flaticon-381-networking"></i>
					<span class="nav-text">{{__('sentence.report') }}</span>
				</a>
				<ul aria-expanded="false">
					<li><a href="{{route('report')}}">{{__('sentence.salesreport') }}</a></li>
					<li><a href="{{route('custlist')}}">{{__('sentence.custreport') }}</a></li>
				</ul>
			</li>
			<li>
				<a class="" href="{{ route('review-rating.view') }}" aria-expanded="false">
					<i class="fa fa-star"></i>
					<span class="nav-text">{{__('sentence.review') }}</span>
				</a>
			</li>
			<li>
				<a class="" href="{{route('gallery')}}" aria-expanded="false">
					<i class="fa fa-picture-o"></i>
					<span class="nav-text">{{__('sentence.gallery') }}</span>
				</a>
				
			</li>
			<li class="{{ request()->is('video/*/edit') || request()->is('video/create') ? 'mm-active' : '' }}">
				<a class="" href="{{route('video.index')}}" aria-expanded="false">
					<i class="fa fa-video-camera"></i>
					<span class="nav-text">Videos</span>
				</a>
			
			</li>
			<li class="{{ request()->is('blog/*/edit') || request()->is('blog/create') ? 'mm-active' : '' }}">
				<a class="" href="{{route('blog.index')}}" aria-expanded="false">
					<i class="fa fa-newspaper-o"></i>
					<span class="nav-text">Blog</span>
				</a>
			</li>
			@if(auth('chef')->user()->country_id != 142)
			<li class="{{ request()->is('chef-discount/*/edit') || request()->is('chef-discount/create') ? 'mm-active' : '' }}">
				<a class="" href="{{route('chef-discount.index')}}" aria-expanded="false">
					<i class="fa fa-percent"></i>
					<span class="nav-text">{{__('sentence.promotions') }}</span>
				</a>
				
			</li>
			@endif
			<li class="{{ request()->is('certificate/*/edit') || request()->is('certificate/create') ? 'mm-active' : '' }}">
				<a class="" href="{{ route('certificate.index') }}" aria-expanded="false">
					<i class="fa fa-certificate"></i>
					<span class="nav-text">{{__('sentence.certificate') }}</span>
				</a>
			</li>
			<li>
				<a class="has-arrow ai-icon" href="javascript:void()"  aria-expanded="false">
					<i class="fa fa-cog"></i>
					<span class="nav-text">{{__('sentence.setting') }}</span>
				</a>
				<ul aria-expanded="false">
					<li><a  href="{{ route('chef-dashboard-profile') }}" aria-expanded="false">{{__('sentence.profile') }}</a></li>
					<li><a href="{{route('pickup-delivery.index')}}">{{__('sentence.picdel') }}</a></li>
					<li><a href="{{route('menu-schedule')}}">{{__('sentence.menuschedule') }}</a></li>
					<li><a  href="{{route('group.index')}}" aria-expanded="false">{{__('sentence.menugroup') }}</a></li>
				</ul>
			</li>
			<li>
				<a class="" href="{{ route('clogout') }}" aria-expanded="false">
					<i class="flaticon-381-networking"></i>
					<span class="nav-text">{{__('sentence.logout') }}</span>
				</a>
			</li>
		</ul>
	</div>
</div>
	