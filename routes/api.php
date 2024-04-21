<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\AuthController;
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
/**************************/
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


/***************************product**********/
// Route::post('/addproduct',[ProductController::class,'add_product']);
// Route::get('/getallproducts',[ProductController::class,'index'])->middleware('auth:sanctum');

// Route::get('/getallproducts',[ProductController::class,'index']);
// Route::get('/product/{id}',[ProductController::class,'getsingleproduct']);
// Route::post('updateproduct/{id}',[ProductController::class,'updateproduct']);
// Route::delete('Deleteproduct/{id}',[ProductController::class,'destroy']);

/**********************user********************/
// Route::post('/register',[UsersController::class,'register']);
// Route::post('/login',[UsersController::class,'login']);
// Route::get('/logout',[UsersController::class,'logout']);

/**********google login */
// Route::get('/auth/google', [GoogleController::class, 'formg'])->name("formg");
// Route::get('/auth/google/callback', [GoogleController::class, 'loging'])->name("loging");

/*******************laravellreact post how to deliver data to api */
// Route::post('/apitest', [PostController::class, 'apitest']);

/*****************stripe payment */
// Route::get('paymentform',[StripeController::class, 'showform'])->name('showform');
// Route::post('payment', [StripeController::class, 'payment'])->name('payment');
// Route::get('success', [StripeController::class, 'success'])->name('success');

/********************laravel_Jwt*****/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});