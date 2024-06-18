<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::group(['prefix' => 'category', 'middleware' => (['auth:sanctum']) ,'namespace' => 'App\Http\Controllers'], function() {
    Route::get('/data', 'CategoryController@index');
    Route::post('/store', 'CategoryController@store');
    Route::patch('update/{id}', 'CategoryController@update');
    Route::delete('delete/{id}','CategoryController@destroy');
});

Route::group(['prefix' => 'product', 'middleware' => (['auth:sanctum']) ,'namespace' => 'App\Http\Controllers'], function() {
    Route::get('/data', 'ProductController@index');
    Route::post('/store', 'ProductController@store');
    Route::patch('update/{id}', 'ProductController@update');
    Route::delete('delete/{id}','ProductController@destroy');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::get('/profile', [AuthController::class, 'me'])->middleware(['auth:sanctum']);
