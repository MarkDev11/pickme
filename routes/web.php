<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BodyAnalysisController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\GrowthRecordController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard - Main Feature: Child Growth Monitoring
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // MAIN FEATURE: Children & Growth Monitoring
    // ==========================================
    Route::prefix('children')->name('children.')->group(function () {
        Route::get('/', [ChildController::class, 'index'])->name('index');
        Route::get('/create', [ChildController::class, 'create'])->name('create');
        Route::post('/', [ChildController::class, 'store'])->name('store');
        Route::get('/{id}', [ChildController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ChildController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ChildController::class, 'update'])->name('update');
        Route::delete('/{id}', [ChildController::class, 'destroy'])->name('destroy');
    });

    // Growth Records Routes
     Route::prefix('growth')->name('growth.')->group(function () {
        Route::get('/create/{childId}', [GrowthRecordController::class, 'create'])->name('create');
        Route::post('/store/{childId}', [GrowthRecordController::class, 'store'])->name('store');
        Route::get('/{id}', [GrowthRecordController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GrowthRecordController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GrowthRecordController::class, 'update'])->name('update');
        Route::delete('/{id}', [GrowthRecordController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // SECONDARY FEATURE: Body Analysis (General)
    // ==========================================
    Route::prefix('analysis')->name('analysis.')->group(function () {
        Route::get('/', [BodyAnalysisController::class, 'index'])->name('index');
        Route::get('/create', [BodyAnalysisController::class, 'create'])->name('create');
        Route::post('/', [BodyAnalysisController::class, 'store'])->name('store');
        Route::get('/{id}', [BodyAnalysisController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BodyAnalysisController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BodyAnalysisController::class, 'update'])->name('update');
        Route::delete('/{id}', [BodyAnalysisController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv', [BodyAnalysisController::class, 'export'])->name('export');
    });

    // ==========================================
    // ADMIN ROUTES
    // ==========================================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
        Route::get('/users/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showUser'])->name('users.show');
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::post('/users/{id}/toggle-role', [App\Http\Controllers\Admin\AdminController::class, 'toggleRole'])->name('users.toggle-role');
        
        // Body Analysis Management
        Route::get('/analyses', [App\Http\Controllers\Admin\AdminController::class, 'analyses'])->name('analyses');
        Route::delete('/analyses/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroyAnalysis'])->name('analyses.destroy');
        
        // Children Management
        Route::get('/children', [App\Http\Controllers\Admin\AdminController::class, 'children'])->name('children');
        Route::get('/children/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showChild'])->name('children.show');
        
        // Growth Records Management
        Route::get('/growth-records', [App\Http\Controllers\Admin\AdminController::class, 'growthRecords'])->name('growth-records');
        
        // Activity Logs
        Route::get('/activity-logs', [App\Http\Controllers\Admin\AdminController::class, 'activityLogs'])->name('activity-logs');
        Route::post('/activity-logs/clear-old', [App\Http\Controllers\Admin\AdminController::class, 'clearOldLogs'])->name('activity-logs.clear-old');
        
        // System Status
        Route::get('/system-status', [App\Http\Controllers\Admin\AdminController::class, 'systemStatus'])->name('system-status');
        
        // Export Routes
        Route::get('/export/users', [App\Http\Controllers\Admin\AdminController::class, 'exportUsers'])->name('export.users');
        Route::get('/export/analyses', [App\Http\Controllers\Admin\AdminController::class, 'exportAnalyses'])->name('export.analyses');
        Route::get('/export/growth-records', [App\Http\Controllers\Admin\AdminController::class, 'exportGrowthRecords'])->name('export.growth');
        Route::get('/export/activity-logs', [App\Http\Controllers\Admin\AdminController::class, 'exportActivityLogs'])->name('export.activity-logs');
    });
});

require __DIR__.'/auth.php';