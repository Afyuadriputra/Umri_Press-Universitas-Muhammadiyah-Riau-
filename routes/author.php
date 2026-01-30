<?php

use App\Http\Controllers\Author\AuthorDashboardController;
use App\Http\Controllers\Author\AuthorPayoutController;
use App\Http\Controllers\Author\AuthorSalesController;
use App\Http\Controllers\Author\AuthorSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role.author'])
    ->prefix('dashboard-author')
    ->name('author.')
    ->group(function () {
        Route::get('/', [AuthorDashboardController::class, 'index'])
            ->name('index')
            ->middleware('author.permission:author.dashboard.view');
        Route::get('/sales', [AuthorSalesController::class, 'index'])
            ->name('sales')
            ->middleware('author.permission:author.sales.view');
        Route::get('/payouts', [AuthorPayoutController::class, 'index'])
            ->name('payouts')
            ->middleware('author.permission:author.payouts.view');
        Route::post('/payouts', [AuthorPayoutController::class, 'store'])
            ->name('payouts.store')
            ->middleware('author.permission:author.payouts.create');
        Route::get('/settings', [AuthorSettingsController::class, 'index'])
            ->name('settings')
            ->middleware('author.permission:author.settings.view');
        Route::post('/settings', [AuthorSettingsController::class, 'update'])
            ->name('settings.update')
            ->middleware('author.permission:author.settings.update');
    });
