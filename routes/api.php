<?php

use Illuminate\Http\Request;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|---------------------------------------------------------------------------
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->namespace('API')->group(function () {
    
    Route::match(['get','post'],'getcountry', 'WebController@getCountry');

    Route::match(['get','post'],'home', 'WebController@home'); 

    Route::match(['get','post'],'all-category','WebController@allCategory');
    Route::match(['get','post'],'all-chef','WebController@allChef');
    
    Route::match(['get','post'],'auto-complete-search','WebController@autoCompleteSearch');
    Route::match(['get','post'],'search','WebController@Search');

    Route::match(['get','post'],'chef-profile','ChefController@chefProfile');
    Route::match(['get','post'],'chef-profile/video/','ChefController@chefProfileVideo');
    Route::match(['get','post'],'chef-profile/blog/','ChefController@chefProfileBlog');

    Route::match(['get','post'],'signup','CustomerController@signUp');
    Route::match(['get','post'],'country-list','CustomerController@countryList');
    Route::match(['get','post'],'login', 'CustomerController@login');

    Route::match(['get','post'],'set-customer-location','CustomerController@customerLocation');

    Route::middleware('APIToken')->group(function () { 
        Route::match(['get','post'],'profile/{user_uuid}','CustomerController@getProfile');
        Route::match(['get','post'],'update-profile','CustomerController@updateProfile');
        Route::match(['get','post'],'update-password','CustomerController@updatePassword');
        Route::match(['get','post'],'update-location','CustomerController@updateLocation');
    }); 
});



