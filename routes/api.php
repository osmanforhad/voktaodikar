<?php

use App\Http\Controllers\API\Admin\ComplainControllerAdmin;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\User\CaseSummeryController;
use App\Http\Controllers\API\User\ComplainController;
use App\Http\Controllers\API\User\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

     Route::get('/profile', [UserController::class, 'profileinfo']);
    Route::get('/edit_profile/{id}', [UserController::class, 'editprofile']);
    Route::post('/update_profile/{id}', [UserController::class, 'updateprofile']);

    Route::post('/create_complain', [ComplainController::class, 'createcomplain']);
    Route::get('/search_complain/{query}', [ComplainController::class, 'searchComplain']);

    Route::get('/pending_case', [CaseSummeryController::class, 'pendingCase']);
    Route::get('/previous_case', [CaseSummeryController::class, 'previousCase']);

    Route::post('/logout', [AuthController::class, 'logout']);

});

//__Route for Admin__//
Route::get('/all_complain', [ComplainControllerAdmin::class, 'allComplainList']);
Route::get('/all_pending_complain', [ComplainControllerAdmin::class, 'allPendingComplain']);
Route::get('/all_compleated_complain', [ComplainControllerAdmin::class, 'allCompleatedComplain']);
Route::get('/search_complain/{query}', [ComplainControllerAdmin::class, 'searchComplain']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
