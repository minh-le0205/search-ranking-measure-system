<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\KeywordsController;
use App\Http\Controllers\SearchEnginesController;

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



// Urls routes
Route::prefix('urls')->group(function () {
  Route::get('/', [DomainController::class, 'index']);
  Route::get('/{id}', [DomainController::class, 'show']);
  Route::get('/ranking/search', [DomainController::class, 'getUrlRankings']);
});

// Keywords routes
Route::prefix('keywords')->group(function () {
  Route::get('/', [KeywordsController::class, 'index']);
});

// Search Engines routes
Route::prefix('search-engines')->group(function () {
  Route::get('/', [SearchEnginesController::class, 'index']);
});
