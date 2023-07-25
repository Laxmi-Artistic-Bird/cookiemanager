<?php

use Artisticbird\Cookies\Http\Controllers\CookiesController;
use Illuminate\Support\Facades\Route;


    Route::middleware(['web'])->group(function () {
        Route::get('/cookieClients',[CookiesController::class,'index'])->name('CookiesClient');
        Route::get('/datatablecookieClients',[CookiesController::class,'datatable'])->name('CookiesClientdatatable');
        Route::get('/cookieClientCreate',[CookiesController::class,'create'])->name('createCookiesClient');
        Route::post('/cookieClientCreate',[CookiesController::class,'store'])->name('storeCookiesClient');
        Route::get('/editCookieClient/{id}',[CookiesController::class,'edit'])->name('editCookiesClient');
        Route::post('/editCookieClient/{id}',[CookiesController::class,'update'])->name('updateCookiesClient');
        Route::DELETE('/deleteCookiesClient/{id}',[CookiesController::class,'deleteCookiesClient'])->name('deleteCookiesClient');

        Route::get('/createCookieContent/{user_id}',[CookiesController::class,'createCookieContent'])->name('createCookieContent');
        Route::get('/cookieContent/{id}/{user_id}',[CookiesController::class,'editcookieContent'])->name('editcookieContent');
        Route::post('/cookiesContentStore',[CookiesController::class,'cookiesContentStore'])->name('cookiesContentStore');
        Route::get('/webcookiedatatable',[CookiesController::class,'webcookiedatatable'])->name('webcookiedatatable');
        Route::get('/webcookies/{id}',[CookiesController::class,'webcookies'])->name('webcookies');
        Route::DELETE('/deletewebCookie/{id}',[CookiesController::class,'deletewebCookie'])->name('deletewebCookie');
    });


?>  