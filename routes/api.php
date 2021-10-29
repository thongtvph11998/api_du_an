<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\InforUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('product')->group(function(){
    Route::get('all',[ProductController::class,'index']);
    Route::post('add',[ProductController::class,'create']);
    Route::get('{id}',[ProductController::class,'show']);
    Route::put('update/{id}',[ProductController::class,'update']);
    Route::delete('delete/{id}',[ProductController::class,'destroy']);
});
Route::prefix('blog')->group(function () {
    Route::get('',[BlogController::class,'index']);
    Route::post('store',[BlogController::class,'store']);
    Route::put('update/{blog}',[BlogController::class,'update']);
    Route::delete('delete/{blog}',[BlogController::class,'destroy']);
    Route::get('{blog}',[BlogController::class,'show']);
});
Route::prefix('user')->group(function () {
    Route::get('',[UserController::class,'index']);
    Route::post('store',[UserController::class,'store']);
    Route::put('update/{user}',[UserController::class,'update']);
    Route::delete('delete/{user}',[UserController::class,'destroy']);
    Route::get('{user}',[UserController::class,'show']);
});
Route::prefix('inforuser')->group(function () {
    Route::get('',[InforUserController::class,'index']);
    Route::post('store',[InforUserController::class,'store']);
    Route::put('update/{infor}',[InforUserController::class,'update']);
    Route::delete('delete/{infor}',[InforUserController::class,'destroy']);
    Route::get('{infor}',[InforUserController::class,'show']);
});
