<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;

use App\Http\Controllers\Api\DivisiController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\JobController;


Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', LogoutController::class);

Route::middleware('auth:api')->group(function () {
    Route::resource('/divisi', DivisiController::class);
    Route::resource('/employee', EmployeeController::class);
    Route::resource('/job', JobController::class);
});


