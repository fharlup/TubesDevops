<?php

use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AnnouncementController; 
use App\Http\Controllers\TagihanController;
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/doctor/schedule', [DoctorController::class, 'storeSchedule'])->name('doctor.schedule.store');
Route::middleware(['auth'])->group(function () {
    Route::resource('medical_records', MedicalRecordController::class);
    Route::get('/schedule', [DoctorController::class, 'index'])->name('schedule');
    Route::resource('announcements', AnnouncementController::class); 
    Route::resource('tagihan', TagihanController::class);
});

use App\Http\Controllers\ObatController;

Route::resource('obat', ObatController::class);


