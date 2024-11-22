<?php

use App\Http\Controllers\API\AttractionController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group( function () {
//    Route::resource('products', ProductController::class);
    Route::post('test', [RegisterController::class, 'test'])->name('test');
    Route::post('/logout', [RegisterController::class, 'logout']);

});

Route::get('/attractions', [AttractionController::class, 'showView'])->name('attractions.index');

Route::prefix('attractions')->group(function () {
    Route::get('/get', [AttractionController::class, 'index'])->name('attractions.index');
    Route::post('/create', [AttractionController::class, 'store'])->name('attractions.store');
    Route::get('/get/{id}', [AttractionController::class, 'show'])->name('attractions.show');
    Route::put('/update/{id}', [AttractionController::class, 'update'])->name('attractions.update');
    Route::delete('/delete/{id}', [AttractionController::class, 'destroy'])->name('attractions.destroy');
});
