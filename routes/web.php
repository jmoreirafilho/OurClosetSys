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
    if (\Auth::check()) {
        return \Redirect('/home');
    } else {
        return \Redirect('/login');
    }
});

Auth::routes();

Route::get('/login', 'HomeController@index')->name('login');

Route::group(['middleware'=>'auth'], function(){
        Route::post('/profile', 'HomeController@getProfile')->name('profile');
        Route::post('/menu', 'HomeController@getMenu')->name('menu');
        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('/usuarios', 'HomeController@index')->name('usuarios');
        Route::get('/usuarios/create', 'HomeController@index')->name('usuarios.create');
        Route::get('/usuarios/{id}/edit', 'HomeController@index')->name('usuarios.edit');
        Route::post('/usuarios/pesquisar', ['as' => 'usuarios.pesquisar', 'uses' => 'UsuarioController@pesquisar']);
        Route::post('/usuarios', ['as' => 'usuarios.store', 'uses' => 'UsuarioController@store']);
        Route::put('/usuarios/edit', ['as' => 'usuarios.update', 'uses' => 'UsuarioController@update']);
        Route::delete('/usuarios/{id}', ['as' => 'usuarios.destroy', 'uses' => 'UsuarioController@destroy']);

        Route::get('/categorias', 'HomeController@index')->name('categorias');
        Route::get('/categorias/create', 'HomeController@index')->name('categorias.create');
        Route::get('/categorias/{id}/edit', 'HomeController@index')->name('categorias.edit');
        Route::post('/categorias/pesquisar', ['as' => 'categorias.pesquisar', 'uses' => 'CategoriaController@pesquisar']);
        Route::post('/categorias', ['as' => 'categorias.store', 'uses' => 'CategoriaController@store']);
        Route::put('/categorias/edit', ['as' => 'categorias.update', 'uses' => 'CategoriaController@update']);
        Route::delete('/categorias/{id}', ['as' => 'categorias.destroy', 'uses' => 'CategoriaController@destroy']);

        Route::get('/pecas', 'HomeController@index')->name('pecas');
        Route::get('/pecas/create', 'HomeController@index')->name('pecas.create');
        Route::get('/pecas/{id}/edit', 'HomeController@index')->name('pecas.edit');
        Route::post('/pecas/pesquisar', ['as' => 'pecas.pesquisar', 'uses' => 'PecaController@pesquisar']);
        Route::post('/pecas', ['as' => 'pecas.store', 'uses' => 'PecaController@store']);
        Route::put('/pecas/edit', ['as' => 'pecas.update', 'uses' => 'PecaController@update']);
        Route::delete('/pecas/{id}', ['as' => 'pecas.destroy', 'uses' => 'PecaController@destroy']);

        Route::get('/movimentacoes', 'HomeController@index')->name('movimentacoes');
        Route::get('/movimentacoes/create', 'HomeController@index')->name('movimentacoes.create');
        Route::post('/movimentacoes/pesquisar', ['as' => 'movimentacoes.pesquisar', 'uses' => 'MovimentacaoEstoqueController@pesquisar']);
        Route::post('/movimentacoes', ['as' => 'movimentacoes.store', 'uses' => 'MovimentacaoEstoqueController@store']);

        Route::get('/estoques', 'HomeController@index')->name('estoques');
        Route::post('/estoques/pesquisar', ['as' => 'estoques.pesquisar', 'uses' => 'EstoqueController@pesquisar']);

});

// Arquivos de tradução
Route::get('/js/traducao.js', function () {
    $lang = config('app.locale');

    $files   = glob(resource_path('lang/' . $lang . '/*.php'));
    $strings = [];

    foreach ($files as $file) {
        $name           = basename($file, '.php');
        $strings[$name] = require $file;
    }

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.traducao');
