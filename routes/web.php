<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/schedule', [DoctorController::class, 'index'])->name('schedule');
Route::post('/doctor/schedule', [DoctorController::class, 'storeSchedule'])->name('doctor.schedule.store');
