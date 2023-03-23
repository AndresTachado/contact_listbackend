<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

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

Route::post('auth/register', [UserController::class, 'Register']);
Route::post('auth/login', [UserController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {


    Route::get('/user', [UserController::class, 'user']);
    Route::post('/employees', [EmployeeController::class, 'store']);

    Route::post('auth/logout', [UserController::class, 'logout']);

    //Route::get('/employees/{userId}', [EmployeeController::class, 'index']);
    Route::get('/employees/{userId}', [EmployeeController::class, 'show']);

    Route::put('/employees{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees{id}', [EmployeeController::class, 'destroy']);
    

});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
