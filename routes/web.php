<?php

use App\Http\Controllers\PrototypePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PrototypePageController::class, 'home'])->name('home');
Route::get('/login', [PrototypePageController::class, 'login'])->name('prototype.login');
Route::get('/register', [PrototypePageController::class, 'register'])->name('prototype.register');
Route::get('/dashboard', [PrototypePageController::class, 'citizenDashboard'])->name('prototype.citizen.dashboard');
Route::get('/admin', [PrototypePageController::class, 'adminDashboard'])->name('prototype.admin.dashboard');
