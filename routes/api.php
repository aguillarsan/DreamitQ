<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//CRUD User
Route::post('/createUser','UserApiRestController@store');
Route::put('/editUser/{id}','UserApiRestController@update');
Route::delete('/deleteUser/{id}','UserApiRestController@destroy');
Route::get('/showUser/{id}','UserApiRestController@show');
Route::get('/getAllUsers','UserApiRestController@getUsers');

//CRUD Bilding
Route::post('/createBilding','BuildingApiRestController@store');
Route::get('/showBilding/{id}','BuildingApiRestController@show');
Route::get('/getAllBuildings','BuildingApiRestController@getBuildings');
Route::put('/editBilding/{id}','BuildingApiRestController@update');
Route::delete('/deleteBilding/{id}','BuildingApiRestController@destroy');

//Registro de estado de acceso de usuario a edificios
Route::post('/regsiterStateAccessbuilding','BlockedAccessApiController@store');

//Registro de accesos de usuarios a edificios
Route::post('/registerAccess','AccessApiRestController@registerAccess');
//Retorno de listado de accesos
Route::get('/getAllRegisterAccess','AccessApiRestController@getAllRegisterAccess');