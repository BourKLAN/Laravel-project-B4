<?php

use App\Http\Controllers\Api\MedaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SharePostController;
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

// Route::post('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
// Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
// Route::post('password/reset', [AuthController::class, 'reset']);

// Password Reset Request Route
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');

// Password Reset Route
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'index']);
    Route::get('/view/profile', [UserController::class, 'myProfile']);
    Route::put('/updateProfilePicture', [UserController::class, 'uploadProfilePicture']);
    Route::put('/updateProfile', [UserController::class, 'updateProfile']);

    //Post=================================================
    Route::get('/post/list',[PostController::class, 'index']);
    Route::post('/post/create',[PostController::class, 'store']);
    Route::get('/post/show/{id}',[PostController::class, 'show']);
    Route::delete('/post/delete/{id}',[PostController::class, 'destroy']);
    Route::put('/post/update/{id}',[PostController::class, 'update']);

    //Like===============================================
    Route::post('/like/toggleLike',[LikeController::class, 'toggleLike']);
    
    //Media================================================
    // Route::post('/photos/create', [MediaController::class, 'store']);

    //Comment==============================================
    Route::post('/comment/create',[CommentController::class,'store']);
    Route::put('/comment/update/{id}',[CommentController::class,'update']);
    Route::delete('/comment/delete/{id}',[CommentController::class, 'destroy']);

    //RequestFriend
    Route::get('/requestFriend/list',[FriendRequestController::class,'index']);
    Route::post('/requestFriend/create',[FriendRequestController::class,'addFriend']);

    Route::get('/FriendhaveRequest/list',[FriendRequestController::class,'displayRequestFriend']);

    //Handle request friend================
    Route::post('/handleRequest',[FriendRequestController::class,'handleRequestFriend']);


    //Unfriend================
    Route::post('/unfriend',[FriendRequestController::class,'unfriend']);

    //Get all friend of each User================
    Route::get('/friend/list',[FriendRequestController::class,'getFriends']);


    //share Post
    Route::post('/share/post',[SharePostController::class,'sharePost']);



});


Route::post('/photos/create', [MedaiController::class, 'store']);
Route::get('/photos/list', [MedaiController::class, 'index']);







