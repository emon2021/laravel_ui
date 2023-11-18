<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

//email verify notice 
Route::get('/email/notice', function () {
    $auth = Auth::user()->email_verified_at;
    if($auth != null){
        return redirect('/home');
    }
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

//email verify link resend -> link
Route::get('/email/resend', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.resend');
