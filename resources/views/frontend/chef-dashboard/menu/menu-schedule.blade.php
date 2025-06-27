@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css')}}">
<style type="text/css">
.error-help-block {
    color: red;
    display: flex;
}
</style>
@endsection
@section('content')
<div class="content-body">
    <div class="container-fluid">
    @section('pageHeading')
    <h2>{{__('sentence.menuschedule') }}</h2>
    @endsection
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="mr-auto d-none d-lg-block">
                <a class="text-warning d-flex align-items-center mb-3 font-w500" href="{{route('chef-dashboard')}}">
                    <svg class="mr-3" width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.274969 5.14888C0.27525 5.1486 0.275484 5.14827 0.275812 5.14799L5.17444 0.272997C5.54142 -0.0922061 6.135 -0.090847 6.5003 0.276184C6.86555 0.643168 6.86414 1.23675 6.49716 1.60199L3.20822 4.87499H23.0625C23.5803 4.87499 24 5.29471 24 5.81249C24 6.33027 23.5803 6.74999 23.0625 6.74999H3.20827L6.49711 10.023C6.86409 10.3882 6.8655 10.9818 6.50025 11.3488C6.13495 11.7159 5.54133 11.7171 5.17439 11.352L0.275764 6.47699C0.275483 6.47671 0.27525 6.47638 0.274921 6.4761C-0.0922505 6.10963 -0.0910778 5.51413 0.274969 5.14888Z" fill="#ffb800"></path>
                    </svg>
                {{__('sentence.back') }}</a>

            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{__('sentence.setting') }}</a></li>
                <li class="breadcrumb-item active"><a href="{{route('chef-dashboard')}}">{{__('sentence.menuschedule') }}</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>{{__('sentence.menuschedule') }}</h4>
                            <p class="mb-0 subtitle">{{__('sentence.aotn') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($ChefSchedule==NULL)
                        {{ Form::open(['url' => route('save-chef-schedule'), 'method'=>'POST', 'files'=>true, 'name' => 'frmMenu', 'id' => 'frmMenu','class'=>"form-main"]) }}
                        @else
                        {{ Form::open(['url' => route('edit-chef-schedule',$ChefSchedule->id), 'method'=>'POST', 'files'=>true, 'name' => 'frmMenu', 'id' => 'frmMenu','class'=>"form-main"]) }}
                        @endif
                    <div class="row">
                        <div class="form-group col-md-2">
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-mon" name="mon" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->mon==1?'checked':'':''}}>
                                <label for="weekday-mon">{{__('sentence.mon') }}</label>
                                <div class="time-sec">
                                    <label for="">{{__('sentence.startt') }}</label>
                                    <input type="time" id="mon_start_time" name="mon_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->mon_start_time:''}}">
                                    <label for="">{{__('sentence.endt') }}</label>
                                    <input type="time" id="mon_end_time" name="mon_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->mon_end_time:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-tue" name="tue" class="weekday"
                                {{!empty($ChefSchedule)?$ChefSchedule->tue==1?'checked':'':''}}>
                                <label for="weekday-tue">{{__('sentence.tue') }}</label>
                                <div class="time-sec">
                                    <label for="">{{__('sentence.startt') }}</label>
                                    <input type="time" id="tue_start_time" name="tue_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->tue_start_time:''}}">
                                    <label for="">{{__('sentence.endt') }}</label>
                                    <input type="time" id="tue_end_time" name="tue_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->tue_end_time:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-wed" name="wed" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->wed==1?'checked':'':''}}>
                                <label for="weekday-wed">{{__('sentence.wends') }}</label>
                                <div class="time-sec">
                                    <label for="">{{__('sentence.startt') }}</label>
                                    <input type="time" id="wed_start_time" name="wed_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->wed_start_time:''}}">
                                    <label for="">{{__('sentence.endt') }}</label>
                                    <input type="time" id="wed_end_time" name="wed_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->wed_end_time:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-thu" name="thu" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->thu==1?'checked':'':''}}>
                                <label for="weekday-thu">{{__('sentence.thu') }}</label>
                                <div class="time-sec">
                                    <label for="">{{__('sentence.startt') }}</label>
                                    <input type="time" id="thu_start_time" name="thu_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->thu_start_time:''}}">
                                    <label for="">{{__('sentence.endt') }}</label>
                                    <input type="time" id="thu_end_time" name="thu_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->thu_end_time:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-fri" name="fri" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->fri==1?'checked':'':''}}>
                                <label for="weekday-fri">{{__('sentence.fri') }}</label>
                                <div class="time-sec">
                                    <label for="">{{__('sentence.startt') }}</label>
                                    <input type="time" id="fri_start_time" name="fri_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->fri_start_time:''}}">
                                    <label for="">{{__('sentence.endt') }}</label>
                                    <input type="time" id="fri_end_time" name="fri_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->fri_end_time:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-sat" name="sat" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->sat==1?'checked':'':''}}>
                                <label for="weekday-sat">{{__('sentence.sat') }}</label>
                                <div class="time-sec">
                                    <label for="">{{__('sentence.startt') }}</label>
                                    <input type="time" id="sat_start_time" name="sat_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sat_start_time:''}}">
                                    <label for="">{{__('sentence.endt') }}</label>
                                    <input type="time" id="sat_end_time" name="sat_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sat_end_time:''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-sun" name="sun" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->sun==1?'checked':'':''}}>
                                <label for="weekday-sun">{{__('sentence.sun') }}</label>
                                <div class="time-sec">
                                    <label for="">{{__('sentence.startt') }}</label>
                                    <input type="time" id="sun_start_time" name="sun_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sun_start_time:''}}">
                                    <label for="">{{__('sentence.endt') }}</label>
                                    <input type="time" id="sun_end_time" name="sun_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sun_end_time:''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" name="btnSubmit" class="btn mr-2 btn-warning" value="newMenu" style="margin-bottom: 10px">{{__('sentence.savefnm') }}</button>
                                <button type="submit" name="ebtnSubmit" class="btn mr-2 btn-warning" value="existingMenu">{{__('sentence.applytaem') }}</button>
                                <img id="loader" src="{{ asset('public/frontend/images/loader.gif')}}" alt="" />
                                <button type="button" name="btnCancel" class="btn mr-2 btn-warning" onclick=" window.history.back()">{{__('sentence.cancel') }}</button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/menu-schedule.js')}}"></script>
@endsection