@php
$location = new \App\Model\Helper();
@endphp
<div class="landing-form">
    {{ Form::open(['url' => route('set-location'), 'method'=>'POST', 'files'=>true, 'name' => 'frmLocation', 'id' => 'frmLocation','class'=>"form-main"]) }}
    <ul>
        <li>
            <div class="form-wrap">
                @if ($displayLable)
                    <h5 style="font-size: 28px">Welcome Home<h5><h5>Enter a location to find delicious cooked meals in your area</h5>
                @endif
                @php
                $loc=$location::getDeserialize(Cookie::get('location'));
                @endphp

                <input type="text" name="location" id="location" placeholder="{{!empty($loc)?$loc['address']:''}}" value="" required="">
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="log" id="log">
                <input type="hidden" name="country" id="country">
                <input type="hidden" name="state" id="state">
                <input type="hidden" name="city" id="city">
                <input type="hidden" name="address" id="address">


            </div>

        </li>
    </ul>
    {{ Form::close() }}

</div>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('view.google_api_key') }}&libraries=places&callback=initializeAutocomplete"
    async defer>
</script>

<script type="text/javascript" src="{{ asset('public/frontend/js/pages/home.js')}}"></script>
