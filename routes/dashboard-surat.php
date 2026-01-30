<?php

use App\Http\Controllers\Surat\DashboardController as SuratDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'surat.access'])
    ->prefix('dashboard-surat')
    ->name('dashboard-surat.')
    ->group(function () {
        Route::get('/', [SuratDashboardController::class, 'index'])->name('index');

        Route::prefix('surat-masuk')->name('incoming.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'index'])->name('index')->middleware('surat.permission:incoming.view');
            Route::get('/arsip', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'archive'])->name('archive')->middleware('surat.permission:incoming.view');
            Route::patch('/{incomingLetter}/arsip', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'archiveStore'])->name('archive.store')->middleware('surat.permission:incoming.update');
            Route::get('/create', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'create'])->name('create')->middleware('surat.permission:incoming.create');
            Route::post('/', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'store'])->name('store')->middleware('surat.permission:incoming.create');
            Route::get('/{incomingLetter}', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'show'])->name('show')->middleware('surat.permission:incoming.view');
            Route::get('/{incomingLetter}/edit', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'edit'])->name('edit')->middleware('surat.permission:incoming.update');
            Route::put('/{incomingLetter}', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'update'])->name('update')->middleware('surat.permission:incoming.update');
            Route::delete('/{incomingLetter}', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'destroy'])->name('destroy')->middleware('surat.permission:incoming.delete');
            Route::get('/export/csv', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'exportCsv'])->name('exportCsv')->middleware('surat.permission:incoming.export');
            Route::get('/export/pdf', [\App\Http\Controllers\Surat\IncomingLetterController::class, 'exportPdf'])->name('exportPdf')->middleware('surat.permission:incoming.export');
        });

        Route::prefix('surat-keluar')->name('outgoing.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'index'])->name('index')->middleware('surat.permission:outgoing.view');
            Route::get('/arsip', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'archive'])->name('archive')->middleware('surat.permission:outgoing.view');
            Route::patch('/{outgoingLetter}/arsip', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'archiveStore'])->name('archive.store')->middleware('surat.permission:outgoing.update');
            Route::get('/create', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'create'])->name('create')->middleware('surat.permission:outgoing.create');
            Route::post('/', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'store'])->name('store')->middleware('surat.permission:outgoing.create');
            Route::get('/{outgoingLetter}', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'show'])->name('show')->middleware('surat.permission:outgoing.view');
            Route::get('/{outgoingLetter}/edit', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'edit'])->name('edit')->middleware('surat.permission:outgoing.update');
            Route::put('/{outgoingLetter}', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'update'])->name('update')->middleware('surat.permission:outgoing.update');
            Route::delete('/{outgoingLetter}', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'destroy'])->name('destroy')->middleware('surat.permission:outgoing.delete');
            Route::get('/export/csv', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'exportCsv'])->name('exportCsv')->middleware('surat.permission:outgoing.export');
            Route::get('/export/pdf', [\App\Http\Controllers\Surat\OutgoingLetterController::class, 'exportPdf'])->name('exportPdf')->middleware('surat.permission:outgoing.export');
        });

        Route::get('/disposisi-saya', [\App\Http\Controllers\Surat\DispositionController::class, 'index'])->name('disposisi.index')->middleware('surat.permission:disposisi.view');
        Route::post('/surat-masuk/{incomingLetter}/disposisi', [\App\Http\Controllers\Surat\DispositionController::class, 'store'])->name('disposisi.store')->middleware('surat.permission:incoming.disposition');
        Route::patch('/disposisi/{disposition}', [\App\Http\Controllers\Surat\DispositionController::class, 'updateStatus'])->name('disposisi.update')->middleware('surat.permission:disposisi.update');
        Route::get('/template-surat', [\App\Http\Controllers\Surat\TemplateController::class, 'index'])->name('template.index')->middleware('surat.permission:template.manage');
        Route::get('/template-surat/create', [\App\Http\Controllers\Surat\TemplateController::class, 'create'])->name('template.create')->middleware('surat.permission:template.manage');
        Route::post('/template-surat', [\App\Http\Controllers\Surat\TemplateController::class, 'store'])->name('template.store')->middleware('surat.permission:template.manage');
        Route::get('/template-surat/{template}/edit', [\App\Http\Controllers\Surat\TemplateController::class, 'edit'])->name('template.edit')->middleware('surat.permission:template.manage');
        Route::put('/template-surat/{template}', [\App\Http\Controllers\Surat\TemplateController::class, 'update'])->name('template.update')->middleware('surat.permission:template.manage');
        Route::delete('/template-surat/{template}', [\App\Http\Controllers\Surat\TemplateController::class, 'destroy'])->name('template.destroy')->middleware('surat.permission:template.manage');
        Route::get('/notifikasi', [\App\Http\Controllers\Surat\NotificationController::class, 'index'])->name('notifications.index')->middleware('surat.permission:notifications.view');
        Route::patch('/notifikasi/{notification}', [\App\Http\Controllers\Surat\NotificationController::class, 'markRead'])->name('notifications.read')->middleware('surat.permission:notifications.view');
        Route::get('/audit-log', [\App\Http\Controllers\Surat\AuditLogController::class, 'index'])->name('audit.index')->middleware('surat.permission:audit.view');
        Route::get('/pengaturan-surat', [\App\Http\Controllers\Surat\SettingsController::class, 'index'])->name('settings.index')->middleware('surat.permission:settings.manage');
        Route::post('/pengaturan-surat', [\App\Http\Controllers\Surat\SettingsController::class, 'update'])->name('settings.update')->middleware('surat.permission:settings.manage');
        Route::post('/pengaturan-surat/unit', [\App\Http\Controllers\Surat\SettingsController::class, 'storeUnit'])->name('settings.unit.store')->middleware('surat.permission:settings.manage');
        Route::delete('/pengaturan-surat/unit/{unit}', [\App\Http\Controllers\Surat\SettingsController::class, 'destroyUnit'])->name('settings.unit.destroy')->middleware('surat.permission:settings.manage');
        Route::post('/pengaturan-surat/jenis', [\App\Http\Controllers\Surat\SettingsController::class, 'storeType'])->name('settings.type.store')->middleware('surat.permission:settings.manage');
        Route::delete('/pengaturan-surat/jenis/{type}', [\App\Http\Controllers\Surat\SettingsController::class, 'destroyType'])->name('settings.type.destroy')->middleware('surat.permission:settings.manage');

        Route::middleware(['isAdmin'])->group(function () {
            Route::view('/users', 'dashboard-surat.users.index')->name('users.index')->middleware('surat.permission:users.manage');
        });
    });
