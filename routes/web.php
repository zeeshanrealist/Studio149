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

Route::get('/', function () {
    return view('index');
});


// API ROUTES ==================================  
Route::group(array('prefix' => 'api'), function() {

    //API for UserController
    Route::group(array('prefix' => 'user'), function() {
        
        Route::post('login', 'UserController@login');
        Route::post('register', 'UserController@register');
        Route::post('verify-email/{id}/{token}', 'UserController@verifyEmail');
        Route::post('forgot-password', 'UserController@forgotPassword');
        Route::post('reset-password', 'UserController@resetPassword');

        Route::group(array('prefix' => '', 'middleware' => 'userAuth'), function() {
    	    Route::get('/', 'UserController@index');
    	    Route::put('/{id}', 'UserController@update');
    	    Route::post('logout/{id}', 'UserController@logout');
    	});
    });

    Route::post('/admin/add-product', 'ProductController@store');
    Route::post('/products/selected', 'ProductController@selectedProducts');
    Route::post('/product-detail/{productId}', 'ProductController@show');
    //API for ProductController
    Route::group(array('prefix' => 'product'), function() {
        
        Route::get('/', 'ProductController@index');
        Route::get('/{categoryId}', 'ProductController@indexByCategory');

        Route::group(array('prefix' => ''/*, 'middleware' => 'userAuth'*/), function() {
            Route::put('/{id}', 'ProductController@update');
            Route::delete('/{id}', 'ProductController@destroy');
        });
    });
    Route::post('/enquiry', 'OrderController@enquiry');
    Route::post('/payment/{paymentId}', 'OrderController@payment');
});

// CATCH ALL ROUTE =============================  
// all routes that are not home or api will be redirected to the frontend 
// this allows angular to route them 
// App::missing(function($exception) { 
//     return View::make('index'); 
// });
