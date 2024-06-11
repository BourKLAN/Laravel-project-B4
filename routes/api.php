<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [AuthController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'index']);
    Route::put('/updateProfilePicture', [UserController::class, 'updateProfilePicture']);
    //Post=================================================
    Route::get('/post/list',[PostController::class, 'index']);
    Route::post('/post/create',[PostController::class, 'store']);
    Route::get('/post/show/{id}',[PostController::class, 'show']);
    Route::delete('/post/delete/{id}',[PostController::class, 'destroy']);

});




