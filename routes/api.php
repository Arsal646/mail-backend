<?php

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



use App\Http\Controllers\FakeEmailController;
use App\Http\Controllers\SavedEmailController;

// Save email routes
Route::post('/save-email', [SavedEmailController::class, 'saveEmail']);
Route::get('/saved/{token}', [SavedEmailController::class, 'getSavedEmail']);
Route::post('/check-saved', [SavedEmailController::class, 'checkSaved']);

Route::post('/fakeemails', [FakeEmailController::class, 'store']);
Route::get('/fakeemails', [FakeEmailController::class, 'index']);
Route::get('/fakeemails/count', [FakeEmailController::class, 'getTotalCount']);


