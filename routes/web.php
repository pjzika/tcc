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
use App\Http\Controllers\TipsController;
use Illuminate\Support\Facades\Storage;

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

    Route::match(['get', 'post'], '/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
    })->name('verification.resend');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rotas que precisam de verificação de email
    Route::middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Feedings
        Route::post('/dashboard/feeding', [DashboardController::class, 'storeFeeding'])->name('feeding.store');
        Route::get('/dashboard/feeding/recent', [DashboardController::class, 'getRecentFeedings'])->name('feeding.recent');
        
        // Alarms
        Route::post('/dashboard/alarm/{alarmId}/toggle', [DashboardController::class, 'toggleAlarm'])->name('alarm.toggle');
        Route::post('/dashboard/alarm/{alarm}/update', [DashboardController::class, 'updateAlarm'])->name('alarm.update');
        
        // Baby
        Route::post('/dashboard/baby', [DashboardController::class, 'storeBaby'])->name('baby.store');
        
        // Tips
        Route::get('/dashboard/tips/daily', [TipsController::class, 'getDailyTips'])->name('tips.daily');
        
        // Notificações
        Route::post('/notifications/subscribe', [NotificationController::class, 'subscribe'])->name('notifications.subscribe');
        Route::post('/notifications/send', [NotificationController::class, 'sendNotification'])->name('notifications.send');

        // perfil
        Route::middleware('auth')->get('/profile', function () {
            return view('profile', ['user' => auth()->user()]);
        })->name('profile');

        // editar perfil
        
        Route::middleware('auth')->get('/profile/edit', function () {
            $user = auth()->user();
            return view('profile_edit', compact('user'));
        })->name('profile.edit');
        
        Route::middleware('auth')->post('/profile/edit', function (Request $request) {
            $user = auth()->user();
        
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'profile_photo' => 'nullable|image|max:2048',
            ]);
        
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    \Storage::delete('public/profile_photos/' . $user->profile_photo);
                }
        
                $filename = $request->file('profile_photo')->store('profile_photos', 'public');
                $data['profile_photo'] = basename($filename);
            }
        
            $user->update($data);
        
            return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
        });  
    });
});