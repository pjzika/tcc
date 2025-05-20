<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TipsController;

// Rotas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/recursos', [ResourceController::class, 'index'])->name('resources');
Route::get('/sobre', [AboutController::class, 'index'])->name('about');

// Rotas de autenticação (acessíveis apenas para visitantes)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    
    // Registro
    Route::get('/cadastro', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/cadastro', [RegisterController::class, 'register'])->name('register.submit');
});

// Rotas protegidas (acessíveis apenas para usuários autenticados)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/feeding', [DashboardController::class, 'storeFeeding'])->name('feeding.store');
    Route::get('/dashboard/feeding/recent', [DashboardController::class, 'getRecentFeedings'])->name('feeding.recent');
    Route::post('/dashboard/alarm/{alarmId}/toggle', [DashboardController::class, 'toggleAlarm'])->name('alarm.toggle');
    Route::post('/dashboard/baby', [DashboardController::class, 'storeBaby'])->name('baby.store');
    Route::get('/dashboard/tips/daily', [TipsController::class, 'getDailyTips'])->name('tips.daily');
    
    // Rotas de notificações
    Route::post('/notifications/subscribe', [NotificationController::class, 'subscribe'])->name('notifications.subscribe');
    Route::post('/notifications/send', [NotificationController::class, 'sendNotification'])->name('notifications.send');
});