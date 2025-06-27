@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content" style="min-height:0px;">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Users</span>
            <span class="info-box-number">{{$users}}</span>
          </div>
        </div>
      </div>

     

    </div>
  </section>

</div>
<!-- end second section -->

@endsection