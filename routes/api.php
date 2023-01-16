<?php

use App\Http\Controllers\NewsController;
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

Route::middleware('auth:sanctum')
->prefix('news')->group(function() {
    Route::get('/', [NewsController::class, 'index']);
    Route::post('/create', [NewsController::class, 'store'])->name('api.news.store');
    Route::put('/{news}', [NewsController::class, 'update'])->name('api.news.update');
    Route::get('/{news}', [NewsController::class, 'show'])->name('api.news.show');
    Route::delete('/{news}', [NewsController::class, 'delete'])->name('api.news.destroy');
});