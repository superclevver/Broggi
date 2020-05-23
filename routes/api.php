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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("/incidencias", "Api\incidenciaController");
Route::apiResource("/alertant", "Api\alertantController");
Route::apiResource("/estats_incidencia", "Api\EstatincidenciaController");
Route::apiResource("/afectats", "Api\afectatsController");
Route::apiResource("/privincia", "Api\provinciaController");
Route::apiResource("/comarca", "Api\comarcaController");
Route::apiResource("/municipi", "Api\municipiController");
Route::apiResource("/recurso", "Api\RecursoController");
Route::apiResource("/rols", "Api\RolsController");
Route::apiResource("/TipusA", "Api\TipusAlertantController");
Route::apiResource("/TipusI", "Api\TipusIncidentController");
Route::apiResource("/TipusR", "Api\TipusRecursController");
Route::apiResource("/usuarios", "Api\UsuarioController");
Route::apiResource('/register', 'Auth\RegisterController');
