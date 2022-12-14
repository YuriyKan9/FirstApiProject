<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/post',[PostController::class,'index']);
Route::get('/post/{id}',[PostController::class,'show']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/post/search/{title}',[PostController::class,'search']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/post', [PostController::class, 'store']);
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::delete('/post/{id}', [PostController::class, 'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
});