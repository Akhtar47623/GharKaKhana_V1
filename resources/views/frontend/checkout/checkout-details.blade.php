@extends('frontend.layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/checkout.css')}}">
@endsection
@section('content')
<section class="checkout-section">
    <div class="container">
        <h2 class="mb-4">Checkout</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('cart'))
        <form action="{{ route('place-order') }}" method="POST">
            @csrf
            <div class="row gx-5">
                <!-- Left: Shipping Information -->
                <div class="col-lg-8 col-md-7">
                    <div class="card h-100 shipping-info p-4">
                        <h4>Shipping Information</h4>

                        <div class="form-group mt-3">
                            <label>Full Name</label>
                            <input type="text" name="name" required class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label>Phone</label>
                            <input type="text" name="phone" required class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label>Email Address</label>
                            <input type="email" name="email" required class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label>Address</label>
                            <input type="text" name="address" id="autocomplete_address" required class="form-control">
                        </div>

                       <div class="form-group row mt-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label for="country">Country</label>
                                <input type="text" id="country" name="country" class="form-control" placeholder="Country" readonly disabled>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" class="form-control" placeholder="City" readonly disabled>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Street Address</label>
                            <input type="text" name="address_line1" class="form-control" placeholder="Street Address" readonly disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label>Apt, Suite, Floor (optional)</label>
                            <input type="text" name="address_line2" class="form-control" placeholder="Apt, Suite, Floor (optional)" readonly disabled>
                        </div>
                        <div class="form-group mt-3">
                            <label>Zipcode</label>
                            <input type="text" name="zipcode" placeholder="ZipCode" class="form-control" readonly disabled>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="col-lg-4 col-md-5">
                    <div class="card h-100 p-4">
                        <h4>Order Summary</h4>
                        <ul class="list-group mt-3">
                            @php $subTotal = 0; @endphp
                            @foreach(session('cart') as $date)
                                @foreach($date as $id => $item)
                                    @php
                                        $optionTotal = 0;
                                        if (!empty($item['option'])) {
                                            foreach ($item['option'] as $opt) {
                                                $optionTotal += $opt['rate'];
                                            }
                                        }
                                        $itemTotal = $item['quantity'] * ($item['price'] + $optionTotal);
                                        $subTotal += $itemTotal;
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $item['item_name'] }} × {{ $item['quantity'] }}</span>
                                        <strong>Rs {{ number_format($itemTotal, 2) }}</strong>
                                    </li>
                                @endforeach
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between font-weight-bold">
                                <span>Subtotal</span>
                                <span>Rs {{ number_format($subTotal, 2) }}</span>
                            </li>
                        </ul>
                        <h5 class="mt-4">Payment Method</h5>
                        <div class="w-100" aria-label="Payment Methods">
                            <input type="radio" class="btn-check" name="payment_method" id="payment_cod" value="cod" autocomplete="off" checked>
                            <label class="btn btn-outline-primary text-start py-3 w-100 mb-2" for="payment_cod">💵 Cash on Delivery</label>

                            <input type="radio" class="btn-check" name="payment_method" id="payment_wallet" value="wallet" autocomplete="off">
                            <label class="btn btn-outline-success text-start py-3 w-100 mb-2" for="payment_wallet">💰 Wallet Balance</label>

                            <input type="radio" class="btn-check" name="payment_method" id="payment_card" value="card" autocomplete="off">
                            <label class="btn btn-outline-dark text-start py-3 w-100" for="payment_card">💳 Credit / Debit Card</label>
                        </div>
                        <button class="btn mt-4" style="background-color:rgb(239 179 19); color:white;">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
        @else
            <div class="alert alert-warning">Your cart is empty!</div>
        @endif
    </div>
</section>
@endsection

@section('pagescript')
<script>
    function getAddressComponent(components, type) {
        for (let i = 0; i < components.length; i++) {
            if (components[i].types.includes(type)) {
                return components[i].long_name;
            }
        }
        return '';
    }

    function initializeAutocomplete() {
        const input = document.getElementById('autocomplete_address');
        if (!input) return;

        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['address'],
            componentRestrictions: { country: 'pk' }
        });

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
            if (!place.address_components) return;

            const components = place.address_components;

            let city = getAddressComponent(components, 'locality');
            if (!city) {
                city = getAddressComponent(components, 'administrative_area_level_2') || getAddressComponent(components, 'administrative_area_level_1');
            }

            const country = getAddressComponent(components, 'country');
            const postal_code = getAddressComponent(components, 'postal_code');

            const street_number = getAddressComponent(components, 'street_number');
            const route = getAddressComponent(components, 'route');
            const sublocality = getAddressComponent(components, 'sublocality') || getAddressComponent(components, 'neighborhood');

            const address_line1 = `${street_number} ${route}`.trim();
            const address_line2 = sublocality;

            // Use jQuery to populate fields
            $('input[name="city"]').val(city);
            $('input[name="country"]').val(country);
            $('input[name="zipcode"]').val(postal_code);
            $('input[name="address_line1"]').val(address_line1);
            $('input[name="address_line2"]').val(address_line2);
        });
    }

    $(document).ready(function () {
        if (typeof google !== 'undefined') {
            initializeAutocomplete();
        } else {
            console.warn("Google Maps API not loaded.");
        }
    });

</script>
@endsection

