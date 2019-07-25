<?php

use App\Models\User;
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

    Route::prefix('profile')->group(function () {

        // usage inside a laravel route
        Route::get('/thiago', function() {
            $base64 = "data:image/jpeg;base64,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";
            $img = Image::make($base64);

//            $user = User::find(1);
//            $user->addMedia($img->response('jpg'))->toMediaCollection('perfil');
            return $img->response('jpg');
        });
    });

    //users
    Route::get('/user', 'UserController@getUser');
    Route::get('/get-permissions', 'UserController@getPermission');
    Route::get('/users', 'UserController@index');
    Route::get('/userFind', 'UserController@userFind');

    //Posts
    Route::get('/posts', 'PostController@getAll');
    Route::post('/post/create', 'PostController@store');

    //Notifications
    Route::get('/notifications', 'NotificationController@notifications');
    Route::put('/notification-read', 'NotificationController@markAsRead');
    Route::put('/notification-all-read', 'NotificationController@markAllAsRead');

    //Settings
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    //Members
    Route::get('/professions', 'UserController@getProfessions');

    Route::get('/member/detail/{id}', 'UserController@getMemberId');
    Route::get('/member/marital-status', 'UserController@getMaritalStatus');
    Route::get('/member/trusts', 'UserController@getTrusts');
    Route::post('/member/store', 'UserController@store');
    Route::get('/member/genders', 'UserController@getGenders');
    Route::get('/member/schoolings', 'UserController@getSchoolings');

    //Address
    Route::get('/states', 'AddressController@getStates');
    Route::get('/states/{id}/cities', 'AddressController@getCities');

    //Deppartments
    Route::get('/departments', 'DepartmentsController@getAll');

    //Setores
    Route::get('/setores', 'SetoresController@getAll');
    Route::get('/igrejas/{id}', 'IgrejasController@buscarIgrejasPorSetor');



});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
