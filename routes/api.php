<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        Route::get('/thiago', function () {
            return Auth::user()->getAllPermissionsAttribute();
        });
    });

    Route::group(['middleware' => ['role:presidente']], function () {

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

    //Profissões
    Route::get('/professions', 'UserController@getProfessions');

    //Members
    Route::get('/member/detail/{id}', 'UserController@getMemberId');
    Route::get('/member/marital-status', 'UserController@getMaritalStatus');
    Route::get('/member/trusts', 'UserController@getTrusts');
    Route::post('/member/store', 'UserController@store');
    Route::get('/member/genders', 'UserController@getGenders');
    Route::get('/member/schoolings', 'UserController@getSchoolings');

    Route::get('/tipos-cadastros', 'MembroController@getTiposCadastros');
    Route::get('/cargos-ministeriais', 'MembroController@getCargosMinisteriais');

    //Secretária
    Route::post('/secretaria/salvar-visitante', 'SecretariaController@salvarVisitante');
    Route::get('/secretaria/listar-visitante', 'SecretariaController@listarVisitantes');

    //Endereços
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
