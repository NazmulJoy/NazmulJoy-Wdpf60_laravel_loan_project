<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepaymentController;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';


Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');


    Route::resource('loan-types', LoanTypeController::class);

    Route::resource('users', UserController::class);

    Route::resource('loans', LoanController::class);

    Route::patch('loans/{loan}/status', [LoanController::class, 'updateStatus'])->name('loans.updateStatus');
    Route::get('/loan/details/{loanId}', [LoanController::class, 'showLoanDetails']);

    Route::resource('repayments', RepaymentController::class);
    Route::put('repayments/{repayment}/update-status', [RepaymentController::class, 'updateStatus'])->name('repayments.updateStatus');

    Route::resource('payments', PaymentController::class);
    Route::patch('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
    Route::get('payments/get-repayments/{userId}', [PaymentController::class, 'getRepayments']);
Route::get('payments/get-repayment-details/{repaymentId}', [PaymentController::class, 'getRepaymentDetails']);


});
