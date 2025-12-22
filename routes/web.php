<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\KnowledgeController as AdminKnowledgeController;

// Главная – всегда публичная
Route::get('/', [HomeController::class, 'index'])->name('home');


// --- ПУБЛИЧНАЯ ЧАСТЬ (без auth) ---

// Новости
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Сотрудники
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

// Мероприятия
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// База знаний
Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
Route::get('/knowledge/{knowledge}', [KnowledgeController::class, 'show'])->name('knowledge.show');

Route::get('/meeting-rooms', [\App\Http\Controllers\MeetingRoomController::class, 'index'])
    ->name('meeting-rooms.index');

Route::get('/meeting-rooms/{room}', [\App\Http\Controllers\MeetingRoomController::class, 'show'])
    ->name('meeting-rooms.show');

// Поиск
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout.get');
// --- АДМИНКА (только для авторизованных + роль admin) ---
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('news', AdminNewsController::class);
        Route::resource('employees', AdminEmployeeController::class);
        Route::resource('events', AdminEventController::class);
	Route::resource('meeting-bookings', \App\Http\Controllers\Admin\MeetingBookingController::class)
    ->except(['show']);
        Route::resource('knowledge', AdminKnowledgeController::class);
Route::delete('knowledge/attachments/{attachment}', [AdminKnowledgeController::class, 'destroyAttachment'])
    ->name('knowledge.attachments.destroy');
    });


// Auth (Breeze)
require __DIR__.'/auth.php';
