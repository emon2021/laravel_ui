<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth','verified']);
//email verificaiton

//email link sent for verification
Route::get('/email/verify/{id}/{hash}',[HomeController::class,'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

//email verify notice about verification link sent
Route::get('/email/notice',[HomeController::class,'verify_notice'])->middleware('auth')->name('verification.notice');

//email verify link resend -> link
Route::get('/email/resend', [HomeController::class,'verify_resend'])->middleware('auth')->name('verification.resend');

//change password view
Route::get('/view/change/password',[HomeController::class,'change_password_view'])->middleware(['verified','auth'])->name('change.password');
//update Password
Route::post('/password/updated',[HomeController::class,'update_password'])->middleware(['auth','verified'])->name('update.password');

