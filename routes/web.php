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

use Illuminate\Http\Request;

Route::middleware(['force_https'])->group(function () {
	Auth::routes();


	Route::middleware(['check_role_permissions'])->group(function () {

		// MISC ROUTES - GET
		Route::get('', 'DashboardController@index')->name('home');
		Route::get('dashboard', 'DashboardController@index')->name('dashboard');
		Route::get('tech-info', 'TechInfoController@index')->name('tech-info');


		// SETTINGS ROUTES
		Route::prefix('settings')->name('settings.')->group(function () {
			$c = 'SettingController@';

			// GET
			Route::get('', $c.'edit')->name('edit');

			// PUT
			Route::put('', $c.'update')->name('update');
		});

        // TOS ROUTES
        Route::prefix('tos')->name('tos.')->group(function () {
            $c = 'TosController@';

            // GET
            Route::get('', $c.'edit')->name('edit');

            // PUT
            Route::put('', $c.'update')->name('update');
        });


		// USER ROUTES
		Route::prefix('users')->name('users.')->group(function () {
			$c = 'UserController@';

			// GET
			Route::get('', $c.'index')->name('list');
			Route::get('add', $c.'create')->name('add');
			Route::get('{id}', $c.'edit')->name('edit');

			// POST
			Route::post('', $c.'store')->name('store');

			// PUT
			Route::put('{id}', $c.'update')->name('update');

			// PATCH
			Route::patch('activate', $c.'multiActivate')->name('activate');
			Route::patch('deactivate', $c.'multiDeactivate')->name('deactivate');

			// DELETE
			Route::delete('', $c.'multiRemove')->name('remove-multi');
			Route::delete('{id}', $c.'destroy')->name('remove');
		});

        // APP USER ROUTES
        Route::prefix('app-users')->name('app-users.')->group(function () {
            $c = 'AppUserController@';

            // GET
            Route::get('', $c.'index')->name('list');
            Route::get('add', $c.'create')->name('add');
            Route::get('{id}', $c.'edit')->name('edit');

            // POST
            Route::post('', $c.'store')->name('store');

            // PUT
            Route::put('{id}', $c.'update')->name('update');

            // PATCH
            Route::patch('activate', $c.'multiActivate')->name('activate');
            Route::patch('deactivate', $c.'multiDeactivate')->name('deactivate');

            // DELETE
            Route::delete('', $c.'multiRemove')->name('remove-multi');
            Route::delete('{id}', $c.'destroy')->name('remove');
        });

        // APP CLIENT ROUTES
        Route::prefix('app-clients')->name('app-clients.')->group(function () {
            $c = 'AppClientController@';

            // GET
            Route::get('', $c.'index')->name('list');
            Route::get('add', $c.'create')->name('add');
            Route::get('{id}', $c.'edit')->name('edit');

            // POST
            Route::post('', $c.'store')->name('store');

            // PUT
            Route::put('{id}', $c.'update')->name('update');

            // PATCH
            Route::patch('activate', $c.'multiActivate')->name('activate');
            Route::patch('deactivate', $c.'multiDeactivate')->name('deactivate');

            // DELETE
            Route::delete('', $c.'multiRemove')->name('remove-multi');
            Route::delete('{id}', $c.'destroy')->name('remove');
        });

        // NOTIFICATION ROUTES
        Route::prefix('notifications')->name('notifications.')->group(function () {
            $c = 'NotificationController@';

            // GET
            Route::get('', $c.'index')->name('list');
            Route::get('add', $c.'create')->name('add');
            Route::get('{id}', $c.'edit')->name('edit');

            // POST
            Route::post('', $c.'store')->name('store');
            Route::post('fire', $c.'multiFire')->name('fire-multi');
            Route::post('fire/{id}', $c.'fire')->name('fire');

            // PUT
            Route::put('{id}', $c.'update')->name('update');

            // DELETE
            Route::delete('', $c.'multiRemove')->name('remove-multi');
            Route::delete('{id}', $c.'destroy')->name('remove');
        });

        // ROLE ROUTES
		Route::prefix('roles')->name('roles.')->group(function () {
			$c = 'RoleController@';

			// GET
			Route::get('', $c.'index')->name('list');
			Route::get('add', $c.'create')->name('add');
			Route::get('{id}', $c.'edit')->name('edit');

			// POST
			Route::post('', $c.'store')->name('store');

			// PUT
			Route::put('{id}', $c.'update')->name('update');

			// DELETE
			Route::delete('', $c.'multiRemove')->name('remove-multi');
			Route::delete('{id}', $c.'destroy')->name('remove');
		});
        // CATEGORIES ROUTES
        Route::prefix('categories')->name('categories.')->group(function () {
            $c = 'CategoryController@';

            // GET
            Route::get('', $c.'index')->name('list');
            Route::get('add', $c.'create')->name('add');
            Route::get('{id}', $c.'edit')->name('edit');

            // POST
            Route::post('', $c.'store')->name('store');

            // PUT
            Route::put('{id}', $c.'update')->name('update');

            // DELETE
            Route::delete('remove', $c.'multiRemove')->name('remove-multi');
            Route::delete('{id}', $c.'destroy')->name('remove');
        });

        // CATEGORIES ROUTES
        Route::prefix('instances')->name('instances.')->group(function () {
            $c = 'InstanceController@';

            // GET
            Route::get('', $c.'index')->name('list');
            Route::get('add', $c.'create')->name('add');
            Route::get('{id}', $c.'edit')->name('edit');

            // POST
            Route::post('', $c.'store')->name('store');

            // PUT
            Route::put('{id}', $c.'update')->name('update');

            // DELETE
            Route::delete('remove', $c.'multiRemove')->name('remove-multi');
            Route::delete('{id}', $c.'destroy')->name('remove');
        });



	});
        // TERMS ROUTES
        Route::prefix('terms')->name('terms.')->group(function () {
            $c = 'AppInfoController@';

            // GET
            Route::get('', $c.'index')->name('list');
            Route::get('add', $c.'create')->name('add');
            Route::get('{id}', $c.'edit')->name('edit');

            // POST
            Route::post('', $c.'store')->name('store');

            // PUT
            Route::put('{id}', $c.'update')->name('update');

            // DELETE
            Route::delete('remove', $c.'multiRemove')->name('remove-multi');
            Route::delete('{id}', $c.'destroy')->name('remove');
        });

        // FEEDBACK ROUTES
        Route::prefix('feedback')->name('feedback.')->group(function () {
            $c = 'FeedbackController@';

            // GET
            Route::get('', $c.'index')->name('list');
            Route::get('add', $c.'create')->name('add');
            Route::get('{id}', $c.'edit')->name('edit');

            // POST
            Route::post('', $c.'store')->name('store');

            // PUT
            Route::put('{id}', $c.'update')->name('update');

            // DELETE
            Route::delete('remove', $c.'multiRemove')->name('remove-multi');
            Route::delete('{id}', $c.'destroy')->name('remove');
        });

});
// STRIPE OAUTH CONNECT
Route::get('/oauth', 'StripeController@oauth')->name('oauth');

// APP PRIVACY STATEMENT
Route::get('privacy-policy', 'AppInfoController@index' );

