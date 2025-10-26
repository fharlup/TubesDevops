<?php

use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/doctor/schedule', [DoctorController::class, 'storeSchedule'])->name('doctor.schedule.store');
Route::middleware(['auth'])->group(function () {
    Route::resource('medical_records', MedicalRecordController::class);
    Route::get('/schedule', [DoctorController::class, 'index'])->name('schedule');
});
