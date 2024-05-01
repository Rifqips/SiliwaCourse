<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CheckoutController as AdminCheckout;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Models\Camp;
use App\Models\Checkout;

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
})->name('welcome');

Route::get('login', function () {
    return view('login');
})->name('login');



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// page can access if login
Route::middleware(['auth'])->group(function () {
    // user checkout
    Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success')->middleware('ensureUserRole:user');
    Route::get('checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout.create')->middleware('ensureUserRole:user');
    Route::POST('checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('ensureUserRole:user');
    // Dashboard
    Route::get('dashboard',[HomeController::class, 'dashboard'] )->name('user.dashboard');
    // User Dashboard
    Route::prefix('user/dashboard')->namespace('User')->name('user.')->middleware('ensureUserRole:user')->group(function(){
        Route::get('/', [UserDashboard::class,'index'])->name('dashboard');
    });
   // Admin Dashboard
   Route::prefix('admin/dashboard')->namespace('Admin')->name('admin.')->middleware('ensureUserRole:admin')->group(function(){
    Route::get('/', [AdminDashboard::class,'index'])->name('dashboard');
    Route::post('checkout/{checkout}', [AdminCheckout::class, 'update'])->name('checkout.update');
});

});

// socialite routes
Route::get('sign-in-google', [UserController::class, 'google'])->name('user.login.google');
Route::get('auth/google/callback', [UserController::class, 'handleProviderCallback'])->name('user.google.callback');



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
