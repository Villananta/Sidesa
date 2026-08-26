<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
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
Route::get('/resident/create', [ResidentController::class, 'create'])->name('resident.create')->middleware('role:Admin');
Route::post('/resident', [ResidentController::class, 'store'])->name('resident.store')->middleware('role:Admin');
Route::get('/resident/{id}/edit', [ResidentController::class, 'edit'])->name('resident.edit')->middleware('role:Admin');
Route::put('/resident/{id}', [ResidentController::class, 'update'])->name('resident.update')->middleware('role:Admin');
Route::delete('/resident/{id}', [ResidentController::class, 'destroy'])->name('resident.delete')->middleware('role:Admin');
Route::get('/account-request', [AccountController::class, 'account_request_view'])->name('account.request')->middleware('role:Admin');
Route::post('/account-request/{id}/approve', [AccountController::class, 'approve'])->name('account.approve')->middleware('role:Admin');
Route::post('/account-request/{id}/reject', [AccountController::class, 'reject'])->name('account.reject')->middleware('role:Admin');
Route::get('/account-list', [AccountController::class,'account_list_view'])->name('account.list')->middleware('role:Admin');
Route::patch('/account-list/{id}/activate', [AccountController::class, 'activate'])->name('account.activate')->middleware('role:Admin');
Route::patch('/account-list/{id}/deactivate', [AccountController::class, 'deactivate'])->name('account.deactivate')->middleware('role:Admin');
Route::patch('/account-list/{id}/link-resident', [AccountController::class, 'linkResident'])->name('account.link-resident')->middleware('role:Admin');
Route::get('/profile', [AccountController::class, 'profile_view'])->name('profile')->middleware('role:Admin,User');
Route::get('/change-password', [AccountController::class, 'change_password_view'])->middleware('role:Admin,User');
Route::post('/change-password/{id}', [AccountController::class, 'change_password'])->middleware('role:Admin,User');
Route::put('/profile/{id}', [AccountController::class, 'updateProfile'])->name('profile.update')->middleware('role:Admin,User');

Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint.index')->middleware('role:User');
Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store')->middleware('role:User');
Route::put('/complaint/{id}', [ComplaintController::class, 'update'])->name('complaint.update')->middleware('role:User');
Route::delete('/complaint/{id}', [ComplaintController::class, 'destroy'])->name('complaint.destroy')->middleware('role:User');