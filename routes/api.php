<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['force_https'])->namespace('Api')->name('api.')->group(function () {
	
	Route::fallback(function () {
		return response()->json(['message' => 'Not Found!'], 404);
	})->name('404');
	

	// JWT PROTECTED ROUTES
	Route::middleware(['check_role_permissions'])->group(function () {

	    // PROFILE ROUTES
        Route::prefix('me')->name('me.')->group(function () {
            $c = 'ProfileController@';

            // POST
            Route::post('update-password', $c.'updatePassword')->name('update-password');
            Route::post('categories-of-interest', $c.'categoriesOfInterest')->name('categories-of-interest');
            Route::post('edit', $c.'edit')->name('edit');
            Route::post('delete', $c.'delete')->name('delete');
            Route::post('tos', $c.'tos')->name('tos');
            Route::post('facebook/revoke', $c.'revokeFacebook')->name('revoke-facebook');
            Route::post('facebook/connect', $c.'connectFacebook')->name('connect-facebook');
            Route::post('google/revoke', $c.'revokeGoogle')->name('revoke-google');
            Route::post('google/connect', $c.'connectGoogle')->name('connect-google');
            Route::post('stripe/disconnect', $c.'stripeDisconnect')->name('disconnect-stripe');


            // GET
            Route::get('', $c.'me')->name('get');
            Route::get('claims', $c.'claims')->name('claims');
            Route::get('instances', $c.'instances')->name('instances');


        });

        // STRIPE ROUTES
        Route::prefix('stripe')->name('stripe.')->group(function () {
            $c = 'StripeController@';

            // POST
            Route::post('payment', $c.'payment')->name('payment');

        });

        // INSTANCE ROUTES
        Route::prefix('instances')->name('instances.')->group(function () {
            $c = 'InstanceController@';

            // GET
            Route::get('{id}', $c.'show')->name('single');
            Route::get('', $c.'radius')->name('radius');
            Route::get('{instance_id}/claims', $c.'instanceClaim')->name('instanceClaim');


            //POST
            Route::post('new', $c.'create')->name('create');
            Route::post('{id}/set-active', $c.'active')->name('active');
            Route::post('{instance_id}/claim', $c.'createClaim')->name('createClaim');
            Route::post('{id}/edit', $c.'edit')->name('edit');
            Route::post('{id}/complete', $c.'complete')->name('complete');


            //DELETE
            Route::delete('{id}', $c.'delete')->name('delete');

        });

        // CLAIM ROUTES
        Route::prefix('claims')->name('claims.')->group(function () {
            $c = 'ClaimController@';

            // GET
            Route::get('{id}', $c.'show')->name('show');


            //POST
            Route::post('', $c.'clientToken')->name('clientToken');
            Route::post('{id}/confirm', $c.'confirm')->name('confirm');


        });


        // CUSTOMER DEVICES ROUTES
        Route::prefix('devices')->name('devices.')->group(function () {
            $c = 'CustomerDeviceController@';

            // GET
            Route::get('', $c.'index')->name('list');


            // PUT
            Route::put('', $c.'store')->name('store');


            // DELETE
            Route::delete('{device_id?}', $c.'remove')->name('remove');
        });

        // FEEDBACK ROUTES
        Route::prefix('feedback')->name('feedback.')->group(function () {
            $c = 'FeedbackController@';

            //POST
            Route::post('', $c.'create')->name('create');

        });

        // CLIENT FEEDBACK ROUTES
        Route::prefix('client')->name('stars.')->group(function () {
            $c = 'FeedbackController@';


            //POST
            Route::post('{id}/feedback', $c.'stars')->name('stars');

        });


    });

    // PUBLIC ROUTES
    Route::post('user/register', 'AppUserController@register');
    Route::post('user/register/facebook', 'AppUserController@facebookRegister');
    Route::post('user/register/google', 'AppUserController@googleRegister');
    Route::post('exists', 'ProfileController@exists');
    Route::post('client/register', 'AppClientController@register');
    Route::post('login', 'LoginController@login');
    Route::post('facebook/exists', 'LoginController@facebook')->name('facebook');
    Route::post('google/exists', 'LoginController@google')->name('google');
    Route::get('categories', 'CategoryController@index');
    Route::get('instance-types', 'InstanceTypeController@index');
    Route::get('app-info', 'AppInfoController@index');

    // CHART ROUTES
	Route::prefix('charts')->name('charts.')->group(function () {
		$c = 'ChartController@';

        // POST
        Route::post('customers', $c.'customers')->name('customers');
        Route::post('clients', $c.'clients')->name('clients');
        Route::post('instances', $c.'instances')->name('instances');
        Route::post('claims', $c.'claims')->name('claims');
	});
});
