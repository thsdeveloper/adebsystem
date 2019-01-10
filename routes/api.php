<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/user', 'UserController@getUser');

        Route::get('/users', 'UserController@index');
        Route::get('/userFind', 'UserController@userFind');

        //Posts
        Route::get('/posts', 'PostController@getAll');
        Route::post('/post/create', 'PostController@store');

        //Notifications
        Route::get('/notifications', 'NotificationController@notifications');
        Route::put('/notification-read', 'NotificationController@markAsRead');
        Route::put('/notification-all-read', 'NotificationController@markAllAsRead');


        Route::patch('settings/profile', 'Settings\ProfileController@update');
        Route::patch('settings/password', 'Settings\PasswordController@update');
    });


});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
