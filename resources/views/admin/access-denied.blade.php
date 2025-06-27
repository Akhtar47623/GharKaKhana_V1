@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    {{$title}}
                    <div class="card-body">
                        <h4 class="card-title">403 | Access Denied!</h4>
                        <h4 class="text-danger">Sorry, but you don't have permission to access this page!</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection