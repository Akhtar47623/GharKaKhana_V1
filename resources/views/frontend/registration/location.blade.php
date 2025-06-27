<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Prep By Chef</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!--css styles starts-->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
    <style>.error-help-block{color:red;}</style>
    <script> var BASEURL = '{{ url("/") }}/' </script>
</head>

<body>      
<div class="wrapper">
    <section class="login-sec registration-sec">
        <div class="login-wrap">
            <div class="login-left" style="background-image: url({{asset('public/frontend/images/location-bg-img.jpg')}})"></div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="login-logo">
                            <a href="#" title="">
                                <img src="{{asset('public/frontend/images/white-logo.png')}}">
                            </a>
                        </div>
                        <div class="login-title">
                            <h1>Location</h1>
                        </div>
                        <div class="login-form-sec two-col-form location-form">
                            {{ Form::open(['url' => route('save-chef-location-details'), 'method'=>'POST', 'files'=>true, 'name' => 'frmChefLocation', 'id' => 'frmChefLocation','class'=>"form-main"]) }}
                                <span class="note"><em>*</em> Fields Required.</span>
                                <input type="hidden" name="chef_id" value="{{$user->id}}">
                                <ul>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">Email</label>
                                            <input type="email" value="{{$user->email}}" disabled="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">First Name</label>
                                            <input type="text" value="{{$user->first_name}}" disabled="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">Last Name</label>
                                            <input type="text" value="{{$user->last_name}}" disabled="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">Mobile</label>
                                            <input type="text" value="{{$user->mobile}}" disabled="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">Address<em>*</em></label>
                                            <input type="text" value="" name="address" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">Country</label>
                                            {{ Form::select('country',!empty($countries) ? $countries : [], $user->country_id,["required","class"=>"form-control","style"=>"width:100%","placeholder"=>'Select Country',"id"=>"country","name"=>"country", 'disabled' => 'true']) }}
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">State<em>*</em></label>
                                            {{ Form::select('state',!empty($states) ? $states : [], $user->state_id,["required","class"=>"form-control","style"=>"width:100%","placeholder"=>'Select State',"id"=>"state","name"=>"state"]) }}
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">City<em>*</em></label>
                                            <select name="city" id="city" required="">
                                                <option value="" selected="">Select City</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">Zip Code<em>*</em></label>
                                            <input type="text" name="zip_code" id="zip_code" required="">                                          
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">Profile<em>*</em></label>
                                             {{ Form::file('profile', ["required","class"=>"form-control","placeholder"=>"Profile","id"=>"profile","name"=>"profile","onchange"=>"previewImage(this)", "accept"=>"image/*"]) }}
                                             <br>
                                            <div id="previewImage" class="m-t-20" style="padding: 10px;">        
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class="full">
                                        <div class="form-wrap">
                                            <button type="reset">Reset</button>
                                            <button type="submit"  name="btnSubmit">Continue: Business Details</button>
                                        </div>
                                    </li>
                                </ul>
                            {{ Form::close() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert display-none alert-success"></div>
                                    <div class="alert display-none alert-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </section>
</div>  
<!--scripts starts here-->
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-loc.js')}}"></script>
<script type="text/javascript">
    $('#country').change(function(){
        var countryID = $(this).val();    
        if(countryID){
            $.ajax({
                type:"GET",
                url:BASEURL+"get-state-lists?country_id="+countryID,
                success:function(res){
                    if(res)
                    {
                        $("#state").empty();
                        $("#state").append('<option>Select State ...</option>');
                        $.each(res,function(key,value){
                            $("#state").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }
                    else
                    {
                        $("#state").empty();
                    }
                }

            });

        }
        else
        {
            $("#state").empty();
        }      

    });
    $('#state').change(function(){
        var stateID = $(this).val();    
        if(stateID){
            $.ajax({
                type:"GET",
                url:BASEURL+"get-city-lists?state_id="+stateID,
                success:function(res){
                    if(res)
                    {
                        $("#city").empty();
                        $("#city").append('<option>Select City ...</option>');
                        $.each(res,function(key,value){
                            $("#city").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }
                    else
                    {
                        $("#city").empty();
                    }
                }

            });

        }
        else
        {
            $("#city").empty();
        }      

    });
</script>
<!--scripts ends here-->
        
</body>
</html>