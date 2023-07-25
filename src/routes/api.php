<?php

use Artisticbird\Cookies\Http\Controllers\Apis\WebCookieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/getCookieContent',[WebCookieController::class,'index'])->name('getCookieContent');
Route::post('/storeCookieContent',[WebCookieController::class,'store'])->name('storeCookieContent');
?>