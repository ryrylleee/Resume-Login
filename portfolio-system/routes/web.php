<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Auth;

// 1️⃣ Auth Flow: Root route
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

// 2️⃣ Auth Flow: Security & Private Routes
Route::middleware(['auth'])->group(function () {
    
    // FIX: Changed this route.
    // It now points to the 'dashboard' view and is named 'dashboard'.
// This now points to the ResumeController
    Route::get('/dashboard', [ResumeController::class, 'dashboard'])->name('dashboard');    
    // The "Edit Resume" page (the form)
    Route::get('/resume/edit', [ResumeController::class, 'edit'])->name('resume.edit');
    // The "Update Resume" action (for the form submission)
    Route::post('/resume/update', [ResumeController::class, 'update'])->name('resume.update');

    // Default Breeze profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3️⃣ Public Resume View (Public)
Route::get('/public/{id}', [ResumeController::class, 'show'])->name('resume.public');

// 4️⃣ Auth routes (login/register/etc)
require __DIR__.'/auth.php';