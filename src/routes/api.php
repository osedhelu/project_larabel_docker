<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\UsersController;
use App\Http\Controllers\V1\BranchsController;
use App\Http\Controllers\V1\ProfilesController;
use App\Http\Controllers\V1\TerminalsController;
use App\Http\Controllers\V1\CommercesController;
use App\Http\Controllers\V1\AffiliatesController;
use App\Http\Controllers\V1\TransactionsController;

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

Route::prefix('v1')->group(function () {
    // Prefijo V1, todo lo que este dentro de este grupo se accedera escribiendo v1 en el navegador, es decir /api/v1/*
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);
    // Users
    Route::get('users', [UsersController::class, 'index']);
    // With Authentication Routes
    Route::group(['middleware' => ['jwt.verify']], function () {
        // Todo lo que este dentro de este grupo requiere verificación de usuario.
        Route::post('logout', [AuthController::class, 'logout']);
        // Users
        Route::get('users/{id}', [UsersController::class, 'show']);
        Route::post('get-user', [AuthController::class, 'getUser']);
        Route::put('users/{id}', [UsersController::class, 'update']);
        Route::delete('users/{id}', [UsersController::class, 'destroy']);
        // Commerces
        Route::get('commerces', [CommercesController::class, 'index']);
        Route::get('commerces/{id}', [CommercesController::class, 'show']);
        Route::get('commerces-affiliates/{id}',[CommercesController::class,'showOneCommerceWithAffiliates']);
        Route::get('commerces-branches/{id}',[CommercesController::class,'showOneCommerceWithBranchs']);
        Route::post('commerces', [CommercesController::class, 'store']);
        Route::put('commerces/{id}', [CommercesController::class, 'update']);
        Route::delete('commerces/{id}', [CommercesController::class, 'destroy']);
        // Profiles
        Route::get('profiles', [ProfilesController::class, 'index']);
        Route::get('profiles/{id}', [ProfilesController::class, 'show']);
        Route::post('profiles', [ProfilesController::class, 'store']);
        Route::put('profiles/{id}', [ProfilesController::class, 'update']);
        Route::delete('profiles/{id}', [ProfilesController::class, 'destroy']);
        // Terminals
        Route::get('terminals', [TerminalsController::class, 'index']);
        Route::get('terminals/{id}', [TerminalsController::class, 'show']);
        Route::get('terminal-by-serial/{serial}', [TerminalsController::class, 'getTerminalBySerial']);
        Route::post('terminals', [TerminalsController::class, 'store']);
        Route::put('terminals/{id}', [TerminalsController::class, 'update']);
        Route::delete('terminals/{id}', [TerminalsController::class, 'destroy']);
        // Affiliates
        Route::get('affiliates', [AffiliatesController::class,'index']);
        Route::get('affiliates/{id}', [AffiliatesController::class,'show']);
        Route::post('affiliates',[AffiliatesController::class, 'store']);
        Route::put('affiliates/{id}',[AffiliatesController::class,'update']);
        Route::delete('affiliates/{id}',[AffiliatesController::class,'destroy']);
        // Transactions
        Route::get('transactions', [TransactionsController::class,'index']);
        Route::get('transactions/{id}', [TransactionsController::class,'show']);
        Route::post('transactions',[TransactionsController::class, 'store']);
        Route::put('transactions/{id}',[TransactionsController::class,'update']);
        Route::delete('transactions/{id}',[TransactionsController::class,'destroy']);
        // Branchs
        Route::get('branchs', [BranchsController::class,'index']);
        Route::get('branchs/{id}', [BranchsController::class,'show']);
        Route::post('branchs',[BranchsController::class, 'store']);
        Route::put('branchs/{id}',[BranchsController::class,'update']);
        Route::delete('branchs/{id}',[BranchsController::class,'destroy']);
    });
});
