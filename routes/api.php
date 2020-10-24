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

Route::post('/Login','LoginController@Login');

Route::get('/GetUsers', 'UserManagementController@GetUsers');

Route::get('/GetRoles', 'UserManagementController@GetRoles');

Route::post('/UpdateRole', 'UserManagementController@UpdateRole');

Route::post('/AddRole', 'UserManagementController@AddRole');

Route::post('/DeleteRole', 'UserManagementController@DeleteRole');


Route::get('/GetUsers', 'UserManagementController@GetUsers');

Route::post('/UpdateUser', 'UserManagementController@UpdateUser');

Route::post('/DeleteUser', 'UserManagementController@DeleteUser');

Route::post('/AddUser', 'UserManagementController@AddUser');

Route::get('/GetCategories', 'ExpenseManagementController@GetCategories');

Route::post('/AddCategory', 'ExpenseManagementController@AddCategory'); 

Route::post('/DeleteCategory', 'ExpenseManagementController@DeleteCategory');

Route::post('/UpdateCategory', 'ExpenseManagementController@UpdateCategory');

Route::post('/AddExpense', 'ExpenseManagementController@AddExpense');

Route::post('/UpdateExpense', 'ExpenseManagementController@UpdateExpense');

Route::get('/GetExpense', 'ExpenseManagementController@GetExpense');

Route::post('/DeleteExpense', 'ExpenseManagementController@DeleteExpense');

Route::get('/GetChartData', 'ChartController@GetChartData');









