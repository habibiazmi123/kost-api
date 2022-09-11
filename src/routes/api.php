<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\PropertyApiController;
use App\Http\Controllers\API\RoomDiscussionApiController;
use App\Http\Resources\AuthenticatedResource;
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

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

Route::get('/room/explore', [PropertyApiController::class, 'getExploreProperty']);
Route::get('/room/{id}', [PropertyApiController::class, 'getDetailProperty']);

Route::middleware("auth:api")->group( function () {
    Route::get('/user', function (Request $request) {
        return new AuthenticatedResource($request->user());
    });

    Route::apiResource("property", PropertyApiController::class);

    Route::post('/check/availability', [RoomDiscussionApiController::class, 'createDiscussion']);
    Route::get('/discussion/message', [RoomDiscussionApiController::class, 'getAllMessage']);
    Route::get('/discussion/{id}', [RoomDiscussionApiController::class, 'getDiscussion']);
});

