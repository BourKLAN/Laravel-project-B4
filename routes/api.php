<?php

use App\Http\Controllers\Api\MedaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
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
    Route::put('/updateProfile', [UserController::class, 'updateProfile']);

    //Post=================================================
    Route::get('/post/list',[PostController::class, 'index']);
    Route::post('/post/create',[PostController::class, 'store']);
    Route::get('/post/show/{id}',[PostController::class, 'show']);
    Route::delete('/post/delete/{id}',[PostController::class, 'destroy']);
    Route::post('/post/update/{id}',[PostController::class, 'update']);

    //Like===============================================
    Route::post('/like/toggleLike',[LikeController::class, 'toggleLike']);
    
    //Media================================================
    // Route::post('/photos/create', [MediaController::class, 'store']);

    //Comment==============================================
 
    Route::post('/comment/create',[CommentController::class,'store']);
    Route::put('/comment/update/{id}',[CommentController::class,'update']);
    Route::delete('/comment/delete/{id}',[CommentController::class, 'destroy']);
});


Route::post('/photos/create', [MedaiController::class, 'store']);
Route::get('/photos/list', [MedaiController::class, 'index']);


// Route::prefix('api')->group(function () {
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
//     Route::post('password/reset', [AuthController::class, 'reset']);

//     Route::middleware('auth:sanctum')->group(function () {
//         Route::get('/me', [AuthController::class, 'index']);
//         Route::post('/updateProfilePicture', [UserController::class, 'updateProfilePicture']);

//         //Post routes prefixed with /post
//         Route::prefix('post')->group(function () {
//             Route::get('/list', [PostController::class, 'index']);
//             Route::post('/create', [PostController::class, 'store']);
//             Route::get('/show/{id}', [PostController::class, 'show']);
//             Route::delete('/delete/{id}', [PostController::class, 'destroy']);
//             Route::post('/update/{id}', [PostController::class, 'update']);
//         });
//     });
// });




