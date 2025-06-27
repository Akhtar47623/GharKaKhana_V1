@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border content-header">
                        <h3>{{$title}}</h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="{{ route('ticket-category.index') }}"> {{ Config::get('constants.title.ticket') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('ticket-category.update', $ticketCate->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmTicketCat', 'id' => 'frmTicketCat']) }}
                     <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('name','Name') }}
                                {{ Form::text('name',  $ticketCate->name, ["required","class"=>"form-control","placeholder"=>'Enter Category Name',"id"=>"name","name"=>"name","maxlength"=>100]) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('parent_id', 'Parent') }}
                                 {{ Form::select('parent_id',!empty($categories) ? $categories : [], $ticketCate->parent_id,["required","class"=>"form-control","placeholder"=>'-----Select Category------',"id"=>"parent_id","name"=>"parent_id"]) }}
                               
                            </div>
                        </div>               
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('ticket-category.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert display-none alert-success"></div>
                            <div class="alert display-none alert-danger"></div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('pagescript')
<script src="{{ asset('public/backend/js/pages/ticket-category.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>

@stop