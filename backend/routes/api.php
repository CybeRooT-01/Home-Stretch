<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserRessource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

  Route::get('user', function (Request $request) {
    return new UserRessource($request->user());
  });

  Route::get('users', [UserController::class, 'allUsers']);

  Route::post('logout', function (Request $request) {
    $request->user()->token()->revoke();
    return response()->json(['message' => 'Logged out'], 200);
  });
});
