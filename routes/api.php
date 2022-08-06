<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function(){

    // Post routes
    Route::post('create_post', [PostController::class, 'store']);
    Route::get('get_posts', [PostController::class, 'index']);
    Route::get('get_post/{id}', [PostController::class, 'show']);
    Route::post('update_post/{id}', [PostController::class, 'update']);
    Route::delete('delete_post/{id}', [PostController::class, 'destroy']);

    // Comment routes
    Route::post('add_comment', [CommentController::class, 'store']);
    Route::delete('delete_comment/{id}', [CommentController::class, 'destroy']);

    // User routes
    Route::post('logout', [AuthController::class, 'logout']);
});
