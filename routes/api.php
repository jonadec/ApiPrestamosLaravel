<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function(){
    Route::post('/login',[AuthController::class, 'login']);
});

Route::prefix('users')->group(function(){
    Route::get('/all',[UserController::class, 'getUsers']);
    Route::get('/{id}',[UserController::class, 'getUser']);
    Route::post('/create',[UserController::class, 'createUser']);
    Route::put('/update/{id}',[UserController::class, 'updateUser']);
    Route::delete('/delete/{id}',[UserController::class,'deleteUser']);
});

Route::prefix('products')->group(function() {
    Route::get('/all', [ProductController::class, 'getProducts']);
    Route::get('/{id}', [ProductController::class, 'getProduct']);
    Route::post('/create', [ProductController::class, 'createProduct']);
    Route::put('/update/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('/delete/{id}', [ProductController::class, 'deleteProduct']);
});

Route::prefix('loans')->group(function() {
    Route::get('/all', [LoanController::class, 'getLoans']);
    Route::get('/{id}', [LoanController::class, 'getLoan']);
    Route::post('/create', [LoanController::class, 'createLoan']);
    Route::put('/update/{id}', [LoanController::class, 'updateLoan']);
    Route::delete('/delete/{id}', [LoanController::class, 'deleteLoan']);
});

