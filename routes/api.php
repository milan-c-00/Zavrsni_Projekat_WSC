<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
 * Routes for user registration and authorization
 * */

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


/*
 * Routes for other application functionalities (authentication required)
 * */

Route::middleware('auth:sanctum')->group( function () {

    Route::post('/logout', [AuthController::class, 'logout']);  // Every logged in user can log out

    /*
     * Routes that require admin role for access
     * */
    Route::middleware('check_role:admin')->group( function () {



    });

    Route::middleware('check_role:user')->group( function () {



    });

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
