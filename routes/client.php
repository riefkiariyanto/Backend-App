<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;


Route::prefix('client')->name('client.')->group(function(){

    Route::middleware(['guest:client'])->group(function(){
        Route::view('/login','back.pages.client.auth.login')->name('login');
        Route::post('/login_handler',[ClientController::class,'loginHandler'])->name('login_handler');
    });

    Route::middleware(['auth:client'])->group(function(){
        Route::view('/home','back.pages.client.home')->name('home'); 
    });
    
});