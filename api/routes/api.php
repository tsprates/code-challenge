<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [AuthController::class, 'me'])->name('me');
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('transactions', [TransactionController::class, 'index']);

    Route::get('expenses', [TransactionController::class, 'expenses']);
    Route::post('expenses', [TransactionController::class, 'addPurchase']);

    Route::get('incomes', [TransactionController::class, 'incomes']);
    Route::post('incomes', [TransactionController::class, 'depositCheck']);

    Route::get('checks/pending', [TransactionController::class, 'checkList']);
    Route::get('checks/{id}', [TransactionController::class, 'checkById']);
    Route::patch('checks/{check}/status', [TransactionController::class, 'updateStatus']);
});
