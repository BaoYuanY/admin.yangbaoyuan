<?php

use App\Http\Controllers\web\PasswordController;
use App\Http\Controllers\web\UploadFileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/pwd')->group(function () {
    Route::get('/add', [PasswordController::class, 'indexAdd']);
    Route::get('/', [PasswordController::class, 'index']);
    Route::post('/search', [PasswordController::class, 'search']);
    Route::post('/add', [PasswordController::class, 'add']);
    Route::get('/getPlatforms', [PasswordController::class, 'getPlatforms']);
});


Route::prefix('/upload')->group(function () {
    Route::get('/', [UploadFileController::class, 'view']);
    Route::post('/save', [UploadFileController::class, 'upload']);
});


Route::get('/success', function () {
    return '连接成功';
});
