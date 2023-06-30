<?php

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
    Route::get('/add', [\App\Http\Controllers\web\PasswordController::class, 'indexAdd']);
    Route::get('/', [\App\Http\Controllers\web\PasswordController::class, 'index']);
    Route::post('/search', [\App\Http\Controllers\web\PasswordController::class, 'search']);
    Route::post('/add', [\App\Http\Controllers\web\PasswordController::class, 'add']);
});

Route::get('/success', function () {
    return '连接成功';
});
