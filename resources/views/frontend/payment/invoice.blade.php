
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>Home Chef</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="format-detection" content="telephone=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--css styles starts-->    
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">           
        <script> var BASEURL = '{{ url("/") }}/' </script>      
    </head>
<body>

<section class="payment-info-sec">
    <div class="panel panel-default credit-card-box">
        <div class="panel-heading" >
            <h3 class="panel-title display-td" >Invoice Details</h3>
            <h1>Order Id: #{{!empty($order)?$order->id:''}}</h1> 

        </div>
        <div class="panel-body form-main">
        	<div class="invoice-inst">
        	Fill this form to get invoice
        	</div> 
            
            
           
           {{ Form::open(['url' => route('invoice.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmInvoice', 'id' => 'frmInvoice','class'=>"form-main"]) }}
           <div class='form-row full-width'>
                <div class='form-group'>
                    <label class='control-label'>Chef: {{!empty($chef)?$chef->display_name:''}}</label>
                    <input type="hidden" name="order_id" value="{{!empty($order)?$order->id:''}}">
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group'>
                    <label class='control-label'>RFC<span style="color:red">*</span></label> 
                    <input class='form-control' name="rfc" type='text' required="" value="">
                </div>
            </div>

            <div class='form-row half-width'>
                <div class='form-group required'>
                    <label class='control-label'>Name<span style="color:red">*</span></label> 
                    <input class='form-control' name="name" type='text' required="" value="{{!empty($cust)?$cust->display_name:''}}">
                </div>
            </div>

            <div class='form-row'>
                <div class='form-group required'>
                    <label class='control-label'>CURP</label> <input 
                    class='form-control' name="curp" type='text'>
                </div>
            </div>

            <div class="form-row half-width">
                <div class='form-group required'>
                    <label class='control-label'>Email</label> <input
                    class='form-control' name="email" type='text' value="{{!empty($cust)?$cust->email:''}}">
                </div>
            </div>

            <div class="form-row full-width">
                <div class='form-group required'>
                    <label class='control-label'>Address</label> <input
                    class='form-control' name="address" type='text' value="{{!empty($location)?$location->address:''}}">
                </div>
            </div>

            <div class="form-row">
                <div class='form-group required'>
                    <label class='control-label'>Municipality</label> <input
                    class='form-control' name="city" type='text' value="{{!empty($location)?$location->city:''}}">
                </div>
            </div>

            <div class="form-row">
                <div class='form-group required'>
                    <label class='control-label'>State</label> <input
                    class='form-control' name="state" type='text' value="{{!empty($location)?$location->state:''}}">
                </div>
            </div>

            <div class="form-row">
                <div class='form-group required'>
                    <label class='control-label'>Country<span style="color:red">*</span></label> <input
                    class='form-control' name="country" type='text' required="" readonly value="{{!empty($location)?$location->country:''}}">
                </div>
            </div>

            <div class="form-row">
                <div class='form-group required'>
                    <label class='control-label'>Postal/Zip Code</label> <input
                    class='form-control' name="zip_code"type='text' value="{{!empty($location)?$location->zipcode:''}}">
                </div>
            </div>

            <div class="form-row ">
                <div class='form-group required'>
                    <label class='control-label'>Phone</label> <input
                    class='form-control' name="mobile" type='text' value="{{!empty($cust)?$cust->mobile:''}}">
                </div>
            </div>
           
           	<div class="form-row full-width">
           	 	<div class="col-md-12">
           	 		<div class="alert display-none alert-success"></div>
           	 		<div class="alert display-none alert-danger"></div>
           	 	</div>
            </div>
        </div>

        
        <div class="form-row">
            <button class="btn btn-primary btn-lg btn-block" id="btnSubmit" type="submit">
            Submit</button>                 
                 
        </div>

        {{ Form::close() }}  
        </div>
    </div>
</section>
</body>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/invoice.js')}}"></script>

