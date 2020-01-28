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
    Route::get('/professions', 'ProficoesController@getProficoes');

    //Cargo Funções
    Route::get('/cargos-funcoes', 'CargoFuncoesController@getCargosFuncoes');

    //Members
    Route::get('/pastores', 'UserController@getPastores');

    //Membros
    Route::prefix('membro')->group(function () {
        Route::get('marital-status', 'MembroController@getTiposEstadoCivil');
        Route::get('genders', 'MembroController@getGeneros');
        Route::get('schoolings', 'MembroController@getNiveisEscolaridade');


        Route::post('cadastrar', 'MembroController@inserir');
        Route::get('visualizar/{id}', 'MembroController@visualizarMembroPorId');
        Route::post('desativar', 'MembroController@desativarMembro');
        Route::get('situacoes', 'MembroController@situacoesMembros');
        Route::post('tesoureiros', 'MembroController@getTesoureiros');
        Route::post('buscar-cadastro-membro-cpf', 'MembroController@getCadastroCpf');
    });

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

    //Igrejas
    Route::get('/igrejas/{id}', 'IgrejasController@buscarIgrejasPorSetor');
    Route::get('/igrejas', 'IgrejasController@buscarIgrejas');
    Route::post('/cadastrar-igreja', 'IgrejasController@cadastrarIgreja');
    Route::post('/excluir-igreja', 'IgrejasController@excluir');
    Route::post('/visualizar-igreja', 'IgrejasController@visualizarIgrejaPorId');

    Route::post('/upload/files', 'UploadController@setFiles');

    Route::get('carta-recomendacao/{id}', 'PDFController@pdfCartaRecomendacao');


    Route::prefix('financeiro')->group(function () {
        Route::post('inserir-tipo-categoria', 'TipoCategoriaFinanceiroController@inserir');
        Route::post('listar-tipo-categoria', 'TipoCategoriaFinanceiroController@listar');
        Route::post('editar-tipo-categoria', 'TipoCategoriaFinanceiroController@editar');
        Route::post('listar-contas', 'ContaFinanceiroController@listar');
        Route::post('inserir-transacao', 'TransacaoFinanceiroController@inserir');
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
