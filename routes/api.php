<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\RegisterController;
use App\Http\Controllers\api\ReservationController;
use App\Http\Controllers\api\VehicleController;
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

    Route::post('/logout', [AuthController::class, 'logout']);  // Every logged user can log out

    Route::get('/vehicles', [VehicleController::class, 'index']);       // Get all vehicles
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']);      // Get a single vehicle

    /*
     * Routes that require admin role for access
     * */
    Route::middleware('check_role:admin')->group( function () {

        // Get brands (for creating vehicle or search filtering)
        Route::get('/brands', [BrandController::class, 'index']);

        // Routes for CRUD operations on vehicles
        Route::post('/vehicles', [VehicleController::class, 'store']);      // Store vehicle
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update']);    // Update vehicle
        // Route::post('/vehicles/{vehicle}', [VehicleController::class, 'update']);   // Only for testing update with postman
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy']);    // Delete vehicle

        Route::get('/reservations', [ReservationController::class, 'index']);       // List all existing reservations

        Route::get('/reservations-export', [ReservationController::class, 'export']);

    });

    /*
     * Routes that require user role for access
     */
    Route::middleware('check_role:regular_user')->group( function () {

        Route::get('/my-reservations', [ReservationController::class, 'myReservations']);       // Get only current users reservations

        // ApiResource routes for default CRUD operations on reservations
        Route::apiResource('/reservations', ReservationController::class)->except('index');

    });
//    Route::apiResource('/brands', BrandController::class);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
