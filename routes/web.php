<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// use App\Http\Controllers\authController;
// use App\Http\Controllers\adminController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Sections\SectionController;

use App\Http\Controllers\FullCalenderController;
// use App\Http\Controllers\Students\StudentController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Users\UserController;


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

Route::get('/',[HomeController::class,'index'])->name('selection');

Route::group(['namespace'=>'Auth'],function(){
  Route::get('/login/{type}',[AuthenticatedSessionController::class,'loginForm'])
  ->middleware('guest')
  ->name('login.show');
  Route::post('/login',[AuthenticatedSessionController::class,'login'])->name('login');
 
  Route::get('/logout/{type}',[AuthenticatedSessionController::class,'logout'])->name('logout');
});


  Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth','verifyusercode']
    ], function () 
    { 

     //Users
      Route::group(['namsespace'=>'Users'],function(){
        Route::get('/user/dashboard',[UserController::class,'index'])->name('dashboard.user');

      });
});

Route::group(['middleware'=>'auth:web'],function(){
  Route::post('/verifyuser',[RegisteredUserController::class,'verifyuser'])->name('Sure_verifycode');
  
});


  //reste password
Route::get('/resetpassword',[PasswordResetController::class,'index'])->name('resetpassword');

Route::post('send_resetotp',[PasswordResetController::class,'resetpass'])->name('send_resetotp');
Route::post('changepassword',[PasswordResetController::class,'changepassword'])->name('changepassword');
Route::post('updatepassword',[PasswordResetController::class,'updatepassword'])->name('updatepassword');


Route::get('/put_otpcode',function(){
  return view('auth.verification');
})->name('put_otpcode');



require __DIR__.'/auth.php';

