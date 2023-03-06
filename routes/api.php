<?php

use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\AuthController;
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
Route::group([
    "prefix"=> "v1",
    "middleware"=>["auth:api"]
],function(){
    Route::apiResource('posts', PostController::class);
});

Route::post('login',[AuthController::class,'login']);
Route::post('signup',[AuthController::class,'signup']);