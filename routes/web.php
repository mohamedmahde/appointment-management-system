<?php

// حل سريع لخدمة ملفات static مباشرة من مجلد assets
Route::get('assets/{path}', function ($path) {
    $file = base_path('assets/' . $path);
    if (file_exists($file)) {
        return response()->file($file);
    }
    abort(404);
})->where('path', '.*');

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // مسارات إدارة المستخدمين
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    
    // مسارات المستندات والطلبات
    Route::resource('documents', DocumentController::class);
    Route::get('/requests/{id}/download', [App\Http\Controllers\RequestController::class, 'download'])->name('requests.download');
    Route::get('requests/accepted', [App\Http\Controllers\RequestController::class, 'accepted'])->name('requests.accepted');
    Route::get('requests/rejected', [App\Http\Controllers\RequestController::class, 'rejected'])->name('requests.rejected');
    Route::get('requests/scheduled', [App\Http\Controllers\RequestController::class, 'scheduled'])->name('requests.scheduled');
    Route::resource('requests', RequestController::class); // يشمل تلقائياً edit/update/destroy
    
    // مسارات المواعيد
    Route::resource('appointments', AppointmentController::class);
    
    // مسارات المحادثات الداخلية
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/messages/{user}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
    
    // مسارات الإعدادات
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');
    Route::put('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
