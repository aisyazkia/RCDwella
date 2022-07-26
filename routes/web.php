<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsLogin;
use App\Http\Middleware\IsUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', [HomeController::class,'index'])->name('home');

Route::get('mail', function(){
    return view('mail.tes-email');
});
Route::get('home', [HomeController::class,'index'])->name('home.index');

Route::get('schedule', [HomeController::class,'schedule'])->name('schedule');

Route::get('product', [HomeController::class,'product'])->name('product');

Route::middleware(IsLogin::class)->name('auth.')->group(function(){

    Route::get('login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('login', [AuthController::class,'login'])->name('login.send');
    Route::post('register', [AuthController::class,'register'])->name('register.send');

});

Route::get('logout', [AuthController::class,'logout'])->name('auth.logout');

Route::middleware(IsUser::class)->name('user.')->group(function(){

    Route::resource('schedule-order', User\ScheduleBookedController::class);

    Route::resource('checkout', CheckoutController::class)->only('index','store');
    Route::resource('cart', CartController::class)->only('index','store','update','destroy');
    

    Route::put('profile/image', [User\ProfileController::class,'update_image'])->name('profile.image.update');
    Route::resource('profile', User\ProfileController::class)->only('index','update');
    Route::prefix('profile')->name('profile.')->group(function(){
        Route::prefix('history')->name('history.')->group(function(){

            Route::put('booked/cancel',[User\ProfileController::class,'booked_cancel'])->name('booked.cancel');
            Route::put('booked/done',[User\ProfileController::class,'booked_done'])->name('booked.done');
            Route::post('booked/payment-upload',[User\ProfileController::class,'book_payment_proof'])->name('booked.payment.upload');
            Route::get('booked/{id}',[User\ProfileController::class,'booked_detail'])->name('booked.detail');

            Route::put('transaction/cancel',[User\ProfileController::class,'transaction_cancel'])->name('transaction.cancel');
            Route::put('transaction/received',[User\ProfileController::class,'transaction_received'])->name('transaction.received');
            Route::put('transaction/done',[User\ProfileController::class,'transaction_done'])->name('transaction.done');
            Route::get('transaction/{id}',[User\ProfileController::class,'transaction_detail'])->name('transaction.detail');
        });
    });

});

Route::middleware(IsAdmin::class)->name('admin.')->prefix('admin')->group(function(){

    Route::get('', function(){
        return redirect()->route('admin.dashboard.index');
    });

    Route::put('profile/image', [Admin\ProfileController::class,'update_image'])->name('profile.image.update');
    Route::resource('profile', Admin\ProfileController::class)->only('index','update');

    Route::resource('dashboard', Admin\DashboardController::class)->only('index');
    Route::resource('product', Admin\ProductController::class);
    Route::put('transaction/process', [Admin\TransactionController::class,'process'])->name('transaction.process');
    Route::put('transaction/delivered', [Admin\TransactionController::class,'delivered'])->name('transaction.delivered');
    Route::put('transaction/reject', [Admin\TransactionController::class,'reject'])->name('transaction.reject');
    Route::resource('transaction', Admin\TransactionController::class);
    Route::resource('treatment', Admin\TreatmentController::class);
    Route::resource('schedule', Admin\ScheduleController::class);
    Route::put('schedule-booked/approve', [Admin\ScheduleBookedController::class,'approve'])->name('schedule-booked.approve');
    Route::put('schedule-booked/payment-confirm', [Admin\ScheduleBookedController::class,'payment_confirm'])->name('schedule-booked.payment-confirm');
    Route::put('schedule-booked/reject', [Admin\ScheduleBookedController::class,'reject'])->name('schedule-booked.reject');
    Route::resource('schedule-booked', Admin\ScheduleBookedController::class)->only('index','show');

});