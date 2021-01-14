<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MBTIController;
use App\Http\Controllers\ResponsesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\Auth\ApiLoginController;

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

Route::post('/mbti', [ MBTIController::class, 'store' ]);
Route::get('/questions', [ QuestionsController::class, 'index' ]);

Route::post('login', Auth\ApiLoginController::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Protected using sanctum API auth tokens
    Route::get('mbti_profile', [ MBTIController::class, 'getUserMBTIProfile']);
    Route::get('responses', [ ResponsesController::class, 'index' ]);
});
