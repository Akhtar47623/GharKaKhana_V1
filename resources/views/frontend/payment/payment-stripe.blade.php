
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
    <script src="https://js.stripe.com/v3/"></script>
           
    </head>
<body>
<form id="payment-form">
  <div id="card-element">
    <!-- Elements will create input elements here -->
  </div>

  <!-- We'll put the error messages in this element -->
  <div id="card-errors" role="alert"></div>

  <button id="submit">Pay</button>
</form>
<!--<section class="payment-info-sec">-->
<!--    <div class="panel panel-default credit-card-box">-->
<!--        <div class="panel-heading" >-->
<!--            <h3 class="panel-title display-td" >Payment Details</h3>-->
<!--            <div class="display-td" >                            -->
<!--                <img class="img-responsive pull-right" src="{{ asset('public/frontend/images/payment-card.png')}}">-->
<!--            </div>                   -->
<!--        </div>-->
<!--        <div class="panel-body form-main">-->

<!--            @if (Session::has('success'))-->
<!--            <div class="alert alert-success text-center">-->
<!--                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>-->
<!--                <p>{{ Session::get('success') }}</p>-->
<!--            </div>-->
<!--            @endif-->

            
<!--            <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"-->
<!--            data-cc-on-file="false"-->
<!--            data-stripe-publishable-key="{{env('STRIPE_KEY')}}"-->
<!--            id="payment-form">-->
<!--            @csrf -->
<!--            <input type="hidden" name="timezone" class="timezone"> -->
<!--            <div class='form-row full-width'>-->
<!--                <div class='form-group required'>-->
<!--                    <label class='control-label'>Name on Card</label> <input-->
<!--                    class='form-control' size='4' type='text'>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class='form-row full-width'>-->
<!--                <div class='form-group card required'>-->
<!--                    <label class='control-label'>Card Number</label> <input-->
<!--                    autocomplete='off' class='form-control card-number' size='20'-->
<!--                    type='text'>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class='form-row '>-->
<!--                <div class='form-group cvc required'>-->
<!--                    <label class='control-label'>CVC</label> <input autocomplete='off'-->
<!--                    class='form-control card-cvc' placeholder='ex. 311' size='4'-->
<!--                    type='text'>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-row">-->
<!--                <div class='form-group expiration required'>-->
<!--                    <label class='control-label'>Expiration Month</label> <input-->
<!--                    class='form-control card-expiry-month' placeholder='MM' size='2'-->
<!--                    type='text'>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-row">-->
<!--                <div class='form-group expiration required'>-->
<!--                    <label class='control-label'>Expiration Year</label> <input-->
<!--                    class='form-control card-expiry-year' placeholder='YYYY' size='4'-->
<!--                    type='text'>-->
<!--                </div>-->
<!--            </div>-->
            
<!--        </div>-->

<!--        <div class='form-row '>-->
<!--            <div class="form-group invoice-checkbox">-->
<!--                <input type="checkbox" name="">-->
<!--                <label>Si quieres la factura</label>-->
<!--            </div>-->
<!--        </div>-->

<!--        <div class='form-row '>-->
<!--            <div class='error form-group hide'>-->
<!--                <div class='alert-danger alert'>Please correct the errors and try again.</div>-->
<!--            </div>-->
<!--        </div>-->

<!--        @if (Session::has('error'))-->
<!--            <div class='error form-group'>-->
<!--                <div class='alert-danger alert'>{{ Session::get('error') }}</div>-->
<!--            </div>-->
<!--        @endif-->

<!--        <div class="form-row">-->
<!--            <button class="btn btn-primary btn-lg btn-block" type="submit">-->
<!--            Pay Now</button>-->
<!--            </form>-->
<!--            <span class="or-text">OR</span>-->
<!--            <form action="{{ route('cash.post') }}" method="post">-->
<!--            @csrf-->
<!--            <input type="hidden" class="timezone" name="timezone">-->
<!--            @if($dispPayChkbx) -->
<!--            <div class="form-row full-width">-->
<!--                <div class='form-group'>-->
<!--                    <input class='form-control' name="invoice" type='checkbox'>-->
<!--                    <label class='control-label' for="invoice"> Si quieres la factura</label><br>-->
<!--                </div>-->
<!--            </div>-->
<!--            @endif-->
<!--            <button class="btn btn-primary btn-lg btn-block cash-on-delivery" type="submit">-->
<!--            Cash On Delivery</button>-->
<!--        </form>-->
           
<!--        </div>-->

        
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
</body>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script>
var stripe = Stripe('{{env('STRIPE_KEY')}}');
var elements = stripe.elements();

var style = {
  base: {
    color: "#32325d",
  }
};

var card = elements.create("card", { style: style });
card.mount("#card-element");
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});
var form = document.getElementById('payment-form');

form.addEventListener('submit', function(ev) {
  ev.preventDefault();
  stripe.confirmCardPayment('<?php echo $client_secret ?>', {
    payment_method: {
      card: card,
      billing_details: {
        name: 'Jenny Rosen'
      }
    }
  }).then(function(result) {
    if (result.error) {
      // Show error to your customer (e.g., insufficient funds)
      console.log(result.error.message);
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
        // Show a success message to your customer
        // There's a risk of the customer closing the window before callback
        // execution. Set up a webhook or plugin to listen for the
        // payment_intent.succeeded event that handles any business critical
        // post-payment actions.
      }
    }
  });
});
</script>
{{-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
        
        $inputs.each(function(i, el) {
        var $input = $(el);
        if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
        }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});

</script> --}}
<!-- timezone -->
<script src="{{ asset('public/frontend/js/moment.min.js')}}"></script>
<script src="{{ asset('public/frontend/js/moment-timezone.min.js')}}"></script>
<script>
        $( document ).ready(function() {
            $('.timezone').val(moment().utcOffset(0, true).format("YYYY-MM-DD h:mm A"))
        });        
    </script>
<!-- timezone end -->