<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CashCategoryController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\MeetingNoteController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin-only', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role:super-admin'])->name('admin.only');

Route::middleware('auth')->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('members', MemberController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('letters', LetterController::class);
    Route::resource('meeting-notes', MeetingNoteController::class);
    Route::resource('cash-categories', CashCategoryController::class);
    Route::resource('cash-transactions', CashTransactionController::class);
    Route::resource('documents', DocumentController::class);
    Route::get('attendances/bulk', [AttendanceController::class, 'bulkCreate'])->name('attendances.bulk.create');
    Route::post('attendances/bulk', [AttendanceController::class, 'bulkStore'])->name('attendances.bulk.store');
    Route::resource('attendances', AttendanceController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
