<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;


Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class,'authenticate']);
Route::post('/logout', [AuthController::class,'logout']);
Route::get('/register', [AuthController::class,'registerView']);
Route::post('/register', [AuthController::class,'register']);
 

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,User');
Route::get('/resident', [ResidentController::class, 'index'])->name('resident.index')->middleware('role:Admin');
Route::get('/resident/create', [ResidentController::class, 'create'])->name('resident.create');
Route::post('/resident', [ResidentController::class, 'store'])->name('resident.store');
Route::get('/resident/{id}/edit', [ResidentController::class, 'edit'])->name('resident.edit');
Route::put('/resident/{id}', [ResidentController::class, 'update'])->name('resident.update');
Route::delete('/resident/{id}', [ResidentController::class, 'destroy'])->name('resident.delete');
Route::get('/account-request', [AccountController::class, 'account_request_view'])->name('account.request');
Route::post('/account-request/{id}/approve', [AccountController::class, 'approve'])->name('account.approve');
Route::post('/account-request/{id}/reject', [AccountController::class, 'reject'])->name('account.reject');