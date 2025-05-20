<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

    // Redefinição de Senha
    Route::get('/esqueci-senha', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/esqueci-senha', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/redefinir-senha/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/redefinir-senha', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Rotas protegidas (acessíveis apenas para usuários autenticados)
Route::middleware('auth')->group(function () {
    // Verificação de Email
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard')->with('verified', true);
    })->middleware(['signed'])->name('verification.verify');

    // Rota de reenvio de verificação (aceita GET e POST)
    Route::match(['get', 'post'], '/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
    })->name('verification.resend');

    // Rotas que precisam de verificação de email
    Route::middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/feeding', [DashboardController::class, 'storeFeeding'])->name('feeding.store');
        Route::post('/dashboard/alarm/{alarmId}/toggle', [DashboardController::class, 'toggleAlarm'])->name('alarm.toggle');
        Route::post('/dashboard/baby', [DashboardController::class, 'storeBaby'])->name('baby.store');
        
        // Rotas de notificações
        Route::post('/notifications/subscribe', [NotificationController::class, 'subscribe'])->name('notifications.subscribe');
        Route::post('/notifications/send', [NotificationController::class, 'sendNotification'])->name('notifications.send');
    });

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});