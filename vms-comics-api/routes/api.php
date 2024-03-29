<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ComicController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => ['auth:api']], function(){
//     Route::get('/authors', [AuthorController::class, 'index']);
//     Route::get('/authors/{id}/comics', [AuthorController::class, 'authorComics']);
// });

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::get('/authors/{id}/comics', [AuthorController::class, 'authorComics']);
    Route::get('/comics', [ComicController::class, 'index']);
});

