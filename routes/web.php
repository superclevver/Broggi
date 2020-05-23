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

Route::get('/home', 'HomeController@comprovarRol')->name('home');

Route::get('/login', 'Auth\LoginController@showLogin')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Auth\RegisterController@showRegister')->name('register');
Route::post('/register', 'Auth\RegisterController@create');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/recurs-mobil', function () {
        return view('menu1');
    });
    Route::get('/cecos', function () {
        return view('menu2');
    });

    Route::get('/admin', function () {
        return view('menuadmin');
    });

    Route::get('/incidencies', function () {
        return view('incidencies');
    });

    Route::get('/incidenciesasignades', function () {
        return view('incidenciesasignades');
    });

    Route::get('/recursos-mobils', function () {
        return view('recursos');
    });

    Route::get('/alertants', function () {
        return view('alertants');
    });

    Route::get('/usuarios', function () {
        return view('usuarios');
    });

    Route::get('/ajuda', function () {
        return view('ajuda');
    });
});
