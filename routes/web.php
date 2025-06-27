<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;


Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/', function () {

    return view('welcome');
});
/* Web Route */
Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function() {
    Route::get('/checkout','OrderController@checkout')->name('checkout');
    Route::post('/checkout','OrderController@placeOrder')->name('place-order');
    Route::post('/update-cart', 'OrderController@update')->name('update-cart');
    Route::post('/remove-from-cart', 'OrderController@remove')->name('remove-from-cart');

    Route::get('/', 'WebController@index')->name('home');
    Route::post('/cookie', 'WebController@setCookie');
    Route::post('save-location', 'WebController@saveLocation')->name('save-location');

    Route::get('all-category','WebController@allCategory')->name('all-category');

    Route::get('/chef-sign-up','ChefController@chefRegistration')->name('chef-sign-up');
    Route::post('get-state-info','ChefController@chefRegStateInfo');
    Route::get('/customer-sign-up','WebController@custRegistration')->name('customer-sign-up');
    Route::get('/social-sign-up/{uuid}','WebController@socialRegistration')->name('social-sign-up');

    Route::get('/search/{display}/{cat}/{str}','WebController@Search')->name('search');
    Route::get('/autocompleteajax','WebController@autoCompleteAjax');

    Route::get('/chef-sign-in','ChefController@chefSignin')->name('chef-sign-in');
    Route::get('/customer-sign-in','WebController@custSignin')->name('customer-sign-in');

    Route::post('/save-chef-registration','ChefController@saveChefRegistration')->name('save-chef-registration');
    Route::post('/save-customer-registration','WebController@saveCustomerRegistration')->name('save-customer-registration');
    Route::post('/save-customer-location','WebController@saveCustomerLocation')->name('save-customer-location');

    Route::post('/chef-login','ChefController@chefLogin')->name('chef-login');
    Route::post('/customer-login','WebController@custLogin')->name('customer-login');
    Route::get('/validate/{code}','ChefController@validateChefLogin')->name('validate');

    Route::post('/chef-validate','ChefController@chefValidate')->name('chef-validate');
    Route::post('/resend','ChefController@chefResendValidate')->name('resend');
    Route::get('/thank-you','ChefController@thankYou')->name('thank-you');

    Route::get('get-state-lists','WebController@getStateList');
    Route::get('get-city-lists','WebController@getCityList');

    Route::get('login/{provider}', 'WebController@redirect');
    Route::get('login/{provider}/callback','WebController@Callback');

    Route::get('/password-recovery', 'WebController@showForgotPassword')->name('password-recovery');
    Route::post('/password-recovery', 'WebController@forgotPassword')->name('password-recovery-create');
    Route::get('/password-reset/{token}', 'WebController@resetPassword')->name('password-reset');
    Route::post('/password-reset-store', 'WebController@saveResetPassword')->name('password-reset-store');

    Route::get('/chef-profile/{id}','ChefController@chefProfile')->name('chef-profile');
    Route::get('/chef-profile/video/{id}','ChefController@chefProfileVideo')->name('chef-profile.video');
    Route::get('/chef-profile/blog/{id}','ChefController@chefProfileBlog')->name('chef-profile.blog');
    Route::get('view-all-item/{service}','WebController@viewAllItem')->name('view-all-item');
    Route::post('/option-cart','ChefController@optionCart')->name('option-cart');

    Route::get('clear-cart/{date}', 'ChefController@clearCart')->name('clear-cart');

    Route::patch('update-cart', 'ChefController@update');
    Route::delete('remove-from-cart', 'ChefController@removeCart')->name('remove-from-cart');
    Route::post('change-cart-qty','ChefController@changeCartQty')->name('change-cart-qty');
    Route::get('continue-cart/{date}','ChefController@continueCart')->name('continue-cart');
    Route::post('set-location', 'WebController@setLocation')->name('set-location');

    Route::get('terms-condition','WebController@termsCondition')->name('terms-condition');
    Route::get('privacy','WebController@privacyPolicy')->name('privacy');
    Route::get('contactus','WebController@contactUs')->name('contactus');
    Route::post('contactus','WebController@contactUsStore')->name('contactus.store');
    Route::get('refresh-captcha', 'WebController@refreshCaptcha')->name('refresh-captcha');
    Route::get('disclaimer','WebController@disclaimer')->name('disclaimer');

    Route::get('mexico-fee-policy','WebController@mexicoFeePolicy')->name('mexico-fee-policy');
    //Banner
    Route::get('mexico-more-info','WebController@mexicoMoreInfo')->name('mexico-more-info');

    Route::group(['middleware' => 'front'], function() {

        Route::post('save-delivery-address','ChefController@saveDeliveryAddress')->name('save-delivery-address');

        //Chef profile to message
        Route::post('message','CustomerController@addCustMessage')->name('cust.message');

        //Customer Side Message
        Route::post('get-order-messages','CustomerController@getOrderMessages')->name('get.order.messages');
        Route::post('add-order-message','CustomerController@addOrderMessage')->name('add-order-message');
        Route::post('responder-message','CustomerController@responderMessage')->name('add-responder-message');

        Route::get('get-chef-list','CustomerController@getChefList')->name('get-chef-list');
        Route::get('get-chef-messages','CustomerController@getMessages')->name('get-chef-messages');
        Route::post('add-chef-message','CustomerController@addMessage')->name('add-chef-message');
        Route::get('get-ticket-messages','CustomerController@getTicketMessages')->name('get-ticket-messages');
        Route::post('add-ticket-message','CustomerController@addTicketMessage')->name('add-ticket-message');


        Route::get('wlogout', 'WebController@logout')->name('wlogout');


        //Customer Orders
        Route::get('your-order','CustomerController@custOrders')->name('your.order');
        Route::get('/login-customer-location','WebController@setLoginUserCookies');

         //Customer profile
        Route::get('customer-profile','CustomerController@customerProfile')->name('customer.profile');
        Route::get('edit-profile','CustomerController@editProfile')->name('edit.profile');
        Route::put('update-profile/{uuid}','CustomerController@updateProfile')->name('update.profile');
        Route::put('update-password/{uuid}','CustomerController@updatePassword')->name('update.password');
        Route::put('update-location/{id}','CustomerController@updateLocation')->name('update.location');

        //Customer Stripe Payment Gatway Route
        Route::get('payment-success', 'StripePaymentController@paymentSuccess')->name('payment.success');
        Route::get('cash-on-delivery', 'StripePaymentController@codSuccess');
        Route::get('stripe', 'StripePaymentController@stripe')->name('stripe.create');
        Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
        Route::post('cash', 'StripePaymentController@cashOnDelivery')->name('cash.post');
        Route::get('invoice/{order_id}','StripePaymentController@invoice');
        Route::post('invoice','StripePaymentController@storeInvoice')->name('invoice.store');

        Route::post('add-tips','ChefController@addTips')->name('add-tips');
        Route::post('add-discount','ChefController@addDiscount')->name('add-discount');
        Route::post('remove-del-charge','ChefController@removeDelCharge')->name('remove-del-charge');

        Route::post('review/store','WebController@storeReview')->name('review.store');
        Route::post('review/skip','WebController@skipReview')->name('review.skip');

    });

    Route::group(['middleware' => 'chef'], function() {

        //Chef Dashboard (Chef Login after display page)
        Route::get('/chef-dashboard', 'ChefDashboardController@chefDashboard')->name('chef-dashboard');
        Route::get('stripe-account','ChefDashboardController@stripeAccount')->name('stripe-account');
        //Chef Menu
        Route::resource('menu', 'MenuController');
        Route::post('suggetion','MenuController@suggetion')->name('suggetion');
        Route::get('menu-schedule','MenuController@menuSchedule')->name('menu-schedule');
        Route::get('get-chef-address','PickupDeliveryController@getChefAddress')->name('get-chef-address');
        Route::post('change-menu-status', 'MenuController@changeStatus')->name('change-menu-status');
        Route::post('change-all-menu-status', 'MenuController@changeAllMenuStatus')->name('change-all-menu-status');
        Route::post('change-menu-visibility', 'MenuController@changeVisibility')->name('change-menu-visibility');
        Route::post('/delete-item', 'MenuController@deleteItem')->name('delete-item');

        //Chef Profile Update
        Route::get('chef-dashboard-profile','ChefDashboardController@chefDashboardProfile')->name('chef-dashboard-profile');
        Route::match(['put', 'patch'],'chef-profile/{id}','ChefDashboardController@updateChefBasicInfo')->name('chef-basic-info.update');
        Route::match(['put','patch'],'chef-location/{id}','ChefDashboardController@updateChefLocation')->name('chef-location.update');
        Route::match(['put','patch'],'chef-business/{id}','ChefDashboardController@updateChefBusiness')->name('chef-business.update');
        Route::match(['put', 'patch'],'chef-banking/{id}','ChefDashboardController@updateChefBanking')->name('chef-banking.update');
        Route::match(['put', 'patch'],'chef-tax/{id}','ChefDashboardController@updateChefTax')->name('chef-tax.update');
        Route::match(['put', 'patch'], 'change-password','ChefDashboardController@changePassword')->name('chef-change-password');

        //Chef Profile Image
        Route::post('image/upload/store','ChefDashboardController@gelleryFileStore');
        Route::delete('image/delete/{id}','ChefDashboardController@gelleryFileDestroy');

        //Print Label
        Route::get('/generate-label-pdf/{orderId}','OrderController@generateLabelPDF')->name('generate.label');
        Route::get('/generate-order-pdf/{orderId}','OrderController@generateOrderPDF')->name('generate.order');

        //Chef Report
        Route::get("report","ChefReportController@index")->name('report');
        Route::get('/export', 'ChefReportController@export');

        //Chef Logout
        Route::get('clogout', 'ChefController@logout')->name('clogout');

        //Chef Discount
        Route::resource('chef-discount',"ChefDiscountController");
        Route::get('change-discount-status', 'ChefDiscountController@changeStatus')->name('change-discount-status');

        //Chef Video
        Route::resource('video', 'VideoController');

        //Chef Blog
        Route::resource('blog', 'BlogController');

        //Chef Certificate
        Route::resource('certificate', 'CertificateController');
        Route::post('change-certi-status', 'CertificateController@changeStatus')->name('change-certi-status');

        //Chef Menu Group
        Route::resource('group','GroupController');

        //Chef Pickup Delivery
        Route::resource('pickup-delivery','PickupDeliveryController');
        Route::post('delivery-detail','PickupDeliveryController@deliveryDetail')->name('delivery-detail');

        //Chef Order Queue
        Route::get('order-view','OrderController@orderView')->name('order.view');
        Route::post('change-status','OrderController@changeStatus')->name('order.change-status');
        Route::post('set-flag','OrderController@setFlag')->name('order.set-flag');
        Route::get('order-detail/{id}',"OrderController@orderDetail")->name('order-detail');

        //Chef Menu Schedule
        Route::post('save-chef-schedule','MenuController@saveChefSchedule')->name('save-chef-schedule');
        Route::post('edit-chef-schedule/{id}','MenuController@updateChefSchedule')->name('edit-chef-schedule');

        //Review & Rating
        Route::get('review-rating','ChefDashboardController@reviewRatingView')->name('review-rating.view');

        //Completed Order(Dashboard Show)
        Route::get('completed-order','ChefDashboardController@completedOrder')->name('completed-order.view');

        //Messages
        Route::get('get-cust-list','ChefDashboardController@getCustList')->name('get-cust-list');
        Route::post('show-message', 'ChefDashboardController@showMessage')->name('show-message');
        Route::post('send', 'ChefDashboardController@sendMessage')->name('send');

        //Tickets
        Route::post('show-ticket', 'ChefDashboardController@showTicket')->name('show-ticket');
        Route::post('send-ticket-message', 'ChefDashboardController@sendTicketMessage')->name('send-ticket-message');

        //seen message
        Route::post('seen-message', 'ChefDashboardController@seenMessage')->name('seen-message');
        Route::post('seen-ticket', 'ChefDashboardController@seenTicket')->name('seen-ticket');
        Route::post('ticket-close', 'ChefDashboardController@ticketClose')->name('ticket-close');

        //Customer List
        Route::get('custlist','ChefDashboardController@custList')->name('custlist');

        //Gallery List
        Route::get('gallery','ChefDashboardController@gallery')->name('gallery');
    });


});

/* Admin Route */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

    Route::get('/', 'AdminController@showlogin')->name('admin');
    Route::post('/', 'AdminController@login')->name('admin');
    Route::get('/admin-forgot-password','AdminController@ShowForgotPassword')->name('forgot-password');
    Route::post('/admin-forgot-password', 'AdminController@forgotpassword')->name('forgot-password.create');
    Route::get('/reset/password/{token}', 'AdminController@showResetForm')->name('reset.show');
    Route::post('/reset-password', 'AdminController@resetPassword')->name('reset.create');

    //admin auth route
    Route::group(['middleware' => 'admin'], function() {

        /* Dashboard */
        Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');


        /* Admin Route List */
        Route::resource('users', 'AdminController');
        Route::get('get-state-list','AdminController@getStateList');
        Route::get('get-city-list','AdminController@getCityList');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profileUpdate', 'AdminController@profileUpdate')->name('profileUpdate');

        /* Roles Route List */
        Route::resource('roles', 'RolesController');
        Route::post('rolesmultidelete', 'RolesController@multiDelete')->name('rolesmultidelete');
        Route::get('roles/permission/{uuid}', 'RolesController@permission')->name('roles.permission');
        Route::post('roles/permission/{uuid}', 'RolesController@permissionstore')->name('roles.permission.store');
        Route::post('roles/list', 'RolesController@getdata')->name('roles.list');

        /* Admin Logout Route*/
        Route::get('logout', 'AdminController@logout')->name('logout');

        //Chef List
        Route::get('chef-list','AdminController@chefList')->name('chef-list');
        Route::post('changeverifystatus','AdminController@changeVerifyStatus')->name('changeverifystatus');

        /* Country Route List */
        Route::resource('country','CountriesController');
        Route::post('countrymultidelete', 'CountriesController@multiDelete')->name('countrymultidelete');
        Route::get('country/category/{uuid}', 'CountriesController@countryCategory')->name('country.category');
        Route::post('country/category', 'CountriesController@countryCategoryStore')->name('country.category.store');
        Route::post('country/category', 'CountriesController@countryCategoryUpdate')->name('country.category.update');

        /* State Route List */
        Route::resource('state','StatesController');
        Route::post('statemultidelete', 'StatesController@multiDelete')->name('statemultidelete');
        Route::post('state/list', 'StatesController@getData')->name('city.list');
        Route::get('country/subcategory/{uuid}', 'StatesController@stateSubCategory')->name('state.subcategory');

        /* City Route List */
        Route::resource('city','CitiesController');
        Route::post('citymultidelete', 'CitiesController@multiDelete')->name('citymultidelete');
        Route::get('get-state-list','CitiesController@getStateList');
        Route::post('city/list', 'CitiesController@getData')->name('city.list');

        /* Cuisine Route List */
        Route::resource('cuisine','CuisineController');
        Route::post('cuisinemultidelete', 'CuisineController@multiDelete')->name('cuisinemultidelete');
        Route::post('cuisine/list', 'CuisineController@getData')->name('cuisine.list');
        Route::post('changestatus', 'CuisineController@changeStatus')->name('changestatus');

        /* Taxes Route List */
        Route::resource('taxes','TaxesController');
        Route::post('taxesmultidelete', 'TaxesController@multiDelete')->name('taxesmultidelete');
        Route::post('taxes/list', 'TaxesController@getData')->name('cuisine.list');

        /* Categories Route List */
        Route::resource('category','CategoriesController');
        Route::post('categorymultidelete', 'CategoriesController@multiDelete')->name('categorymultidelete');
        Route::post('category/list', 'CategoriesController@getData')->name('category.list');

        /* Chef Registration Info Route List */
        Route::resource('chef-registration-info','ChefRegistrationInfoController');
        Route::post('chefreginfomultidelete', 'ChefRegistrationInfoController@multiDelete')->name('chefreginfomultidelete');
        Route::post('chef-registration-info/list', 'ChefRegistrationInfoController@getData')->name('chef-registration-info.list');

        //Discount
        Route::resource("discount","DiscountController");
        Route::get('discount-changestatus', 'DiscountController@changeStatus')->name('discount-changestatus');
        Route::post('discountmultidelete', 'DiscountController@multiDelete')->name('discountmultidelete');

         //Vendor Discount
        Route::resource("vendor-discount","VendorDiscountController");
        Route::get('vendor-discount-changestatus', 'VendorDiscountController@changeStatus')->name('vendor-discount-changestatus');
        Route::post('vendordiscountmultidelete', 'VendorDiscountController@multiDelete')->name('vendordiscountmultidelete');

        //Ticket Category
        Route::resource("ticket-category","TicketCategoryController");
        Route::post('changestatuscat', 'TicketCategoryController@changeStatus')->name('changestatuscat');

        //Ticket
        Route::get('ticket','TicketController@index')->name('ticket');
        Route::post('changestatusticket', 'TicketController@changeStatus')->name('changestatusticket');
        Route::delete('ticket-delete/{id}','TicketController@destroy')->name('ticket-delete');
        Route::post('seenmessage', 'TicketController@seenMessage')->name('seenmessage');
        Route::post('sendmessage','TicketController@sendMessage')->name('sendmessage');

         //Order Detail
        Route::get('admin-order-detail/{orderid}',"TicketController@orderDetail")->name('admin-order-detail');

        /* Country Location Route List */
         Route::resource('country-location','CountryLocationController');
        Route::post('countrylocationmultidelete', 'CountryLocationController@multiDelete')->name('countrylocationmultidelete');

        //Invoice
        Route::resource("mexico-invoice","MexicoInvoiceController");
        Route::get('mexico-invoice-changestatus', 'MexicoInvoiceController@changeStatus')->name('mexico-invoice-changestatus');
        Route::post('mexicoinvoicemultidelete', 'MexicoInvoiceController@multiDelete')->name('mexicoinvoicemultidelete');
        Route::post('mexico-invoice/list', 'MexicoInvoiceController@getData')->name('mexico-invoice.list');
        Route::get('mexico-invoice-detail/{id}',"MexicoInvoiceController@invoiceDetail")->name('mexico-invoice-detail');

         //Invoice
        Route::resource("contact-us","ContactusController");
        Route::post('contactusmultidelete', 'ContactusController@multiDelete')->name('contactusmultidelete');

    });
});

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "Cleared!";
});


