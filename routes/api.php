<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterControler;
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
Route::prefix('product')->group(function () {
    // thêm mới 1 sp
    Route::post('add', [ProductController::class, 'add']);
    // cập nhật 1 sp
    Route::put('update/{id}', [ProductController::class, 'update']);
    // xóa mềm 1 sp
    Route::delete('delete/{id}', [ProductController::class, 'delete']);
    // xóa vĩnh viễn 1 sp
    Route::delete('force-delete/{id}', [ProductController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
    Route::options('force-delete/all', [ProductController::class, 'forceDeleteAll']);
    // danh sách tất cả các sp chưa bị xóa mềm
    Route::get('all', [ProductController::class, 'index']);
    // danh sách tất cả các sp đã bị xóa mềm
    Route::get('deleted', [ProductController::class, 'deleted']);
    // chi tiết 1 sp
    Route::get('detail/{id}', [ProductController::class, 'detail']);
    // backup 1 sp đã bị xóa mềm
    Route::options('backup-one/{id}',[ProductController::class,'backupOne']);
    // backup tất cả các sp đã bị xóa mềm
    Route::options('backup-all',[ProductController::class,'backupAll']);

});
Route::prefix('blog')->group(function () {
    Route::get('',[BlogController::class,'index']);
    Route::post('store',[BlogController::class,'store']);
    Route::put('update/{id}',[BlogController::class,'update']);
    Route::delete('delete/{id}',[BlogController::class,'destroy']);
    Route::get('{id}',[BlogController::class,'show']);
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

//// Register Login Logout
Route::post('register',[RegisterControler::class,'store']);
Route::post('login',[LoginController::class,'login']);
Route::get('logout',[LoginController::class,'logout']);
