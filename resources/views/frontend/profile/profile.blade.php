@extends('frontend.layouts.app')
@section('content')

<section class="user-profile-sec">
    <div class="container">
        <div class="user-profile-wrap">
            <div class="user-profile-left">
                @if(!empty($custProfile))
                    @if($custProfile->provider_id==NULL)
                        <div class="user-profile-img" style="background-image: 
                        url('{{asset('public/frontend/images/users/'.$custProfile->profile)}}');"></div>
                    @else
                        <div class="user-profile-img" style="background-image: url('{{$custProfile->profile}}');"></div>
                    @endif
                @endif
            </div>
            <div class="user-profile-right">
                <div class="user-profile-info">
                    
                    <ul>
                        <li>
                            <span>{{__('sentence.name')}}</span>
                            <h6>{{!empty($custProfile)?$custProfile->display_name:''}}</h6>
                        </li>
                        <li>
                            <span>{{__('sentence.email')}}</span>
                            <h6>{{!empty($custProfile)?$custProfile->email:''}}</h6>
                        </li>
                        @if(!empty($custProfile) && !empty($custProfile->mobile))
                        <li>
                            <span>{{__('sentence.mobile')}}</span>
                            <h6>{{$custProfile->mobile}}</h6>
                        </li>
                        @endif
                        <li>
                            <span>{{__('sentence.address')}}</span>
                            <h6>{{!empty($custProfile)?$custProfile->location->address:''}}</h6>
                        </li>
                        <li>
                            <span>{{__('sentence.city')}}</span>
                            <h6>{{!empty($custProfile)?$custProfile->location->city:''}}</h6>
                        </li>
                        <li>
                            <span>{{__('sentence.state')}}</span>
                            <h6>{{!empty($custProfile)?$custProfile->location->state:''}}</h6>
                        </li>
                        <li>
                            <span>{{__('sentence.country')}}</span>
                            <h6>{{!empty($custProfile)?$custProfile->location->country:''}}</h6>
                        </li>
                    </ul>
                    @if(!empty($custProfile))
                    <div class="edit-profile-btn">
                        <a href="{{ route('edit.profile') }}" title="">{{__('sentence.eprofile')}}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
