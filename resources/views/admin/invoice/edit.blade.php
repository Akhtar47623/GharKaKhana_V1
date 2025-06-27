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
                            <li><a href="{{ route('mexico-invoice.index') }}"> {{ Config::get('constants.title.invoice') }} </a>
                            </li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('mexico-invoice.update', $invoiceData->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmMexicoInvoice', 'id' => 'frmMexicoInvoice']) }}
                    {{ method_field('PATCH') }}
                    @php
                        $required = 'required';
                    @endphp

                    <div class="box-body">
                        <div class="row">               
                       
                            <div class=" form-group col-sm-6">
                                {{ Form::label('invoice', 'Invoice') }}
                                {{ Form::file('invoice', ["class"=>"form-control","placeholder"=>"Invoice","id"=>"invoice","name"=>"invoice","onchange"=>"previewImage(this)", "accept"=>"image/*"]) }}
                                <div id="previewImage" class="m-t-20" style="padding:20px">
                                    
                                    @if(!empty($invoiceData->invoice))
                                        <embed src="{{ asset('public/backend/images/invoice/'.$invoiceData->invoice) }}" width="200px" height="200px" />
                                    @endif
                                </div>
                                {{ Form::hidden('oldImage', $invoiceData->invoice) }}
                                
                            </div>
                            <div class="form-group col-sm-3">
                                {{ Form::label('status','Status') }}                                     
                                {{ Form::select('status',["1"=>"PENDING","2"=>"PROCESSING","3"=>"READY"], $invoiceData->status,["required","class"=>"form-control","style"=>"width:100%","id"=>"status","name"=>"status"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('mexico-invoice.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<script src="{{ asset('public/backend/js/pages/invoice.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
@stop