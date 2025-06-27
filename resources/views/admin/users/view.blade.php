@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('users.index') }}"> {{ Config::get('constants.title.admin_users') }} </a></li>
            <li><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-4 col-md-offset-3">
                <div class="box box-success">
                    <div class="box-body box-warning">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/users/'.$adminuser->profile) }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $adminuser->name }}</h3>
                            <li class="list-group-item">
                                <b>Email</b> <label class="pull-right">{{ $adminuser->email }}</label>
                            </li>
                            <a href="{{ route('users.index') }}" class="btn btn-flat btn-default  btn-block"><b>Back</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection