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

Route::apiResources(['user'=> 'API\UserController']);
Route::get('profile','API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');
Route::get('findUser','API\UserController@searchUser');
Route::get('count-users','API\UserController@countUsers');
Route::post('contact-us', 'API\ContactDeveloperController@store');
// Route::apiResources(['employee'=> 'API\EmployeesController']);
Route::post('employee', 'API\EmployeesController@store');
Route::get('employee', 'API\EmployeesController@index');
Route::put('employee/{employee}', 'API\EmployeesController@update');
Route::delete('employee/{employee}', 'API\EmployeesController@destroy');
Route::get('find-employee','API\EmployeesController@searchEmployee');
Route::get('print-employee','API\EmployeesController@printEmployees');
Route::get('count-employees','API\EmployeesController@numberOfEmployees');