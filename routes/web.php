<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Tenant;
use App\Http\Controllers\Admin\UserController;

// Root
Route::get('/', fn() => redirect('/login'));

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── ADMIN ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('rooms',         Admin\RoomController::class);
    Route::resource('tenants',       Admin\TenantController::class);
    Route::resource('invoices',      Admin\InvoiceController::class)->except(['edit','update']);
    Route::resource('announcements', Admin\AnnouncementController::class)->except(['edit','update','show']);

    Route::resource('utilities', Admin\UtilityController::class)->except(['show']);
    Route::get('/utilities/preview', [Admin\UtilityController::class, 'preview'])->name('utilities.preview'); 
    Route::resource('users', UserController::class)->except(['show']);

    Route::patch('/invoices/{invoice}/paid', [Admin\InvoiceController::class, 'markPaid'])
        ->name('invoices.markPaid');
    Route::get('/invoices/{invoice}/download', [Admin\InvoiceController::class, 'download'])
        ->name('invoices.download');

    Route::get('/payments', [Admin\PaymentController::class, 'index'])->name('payments.index');
});

// ── TENANT ────────────────────────────────────────────────────────────
Route::prefix('tenant')->name('tenant.')->middleware('tenant')->group(function () {

    Route::get('/dashboard',     [Tenant\DashboardController::class,    'index'])->name('dashboard');
    Route::get('/invoices',      [Tenant\InvoiceController::class,      'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}/download', [Tenant\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/utilities',     [Tenant\UtilityController::class,      'index'])->name('utilities.index');
    Route::get('/contracts',     [Tenant\ContractController::class,     'index'])->name('contracts.index');
    Route::get('/contracts/download', [Tenant\ContractController::class, 'download'])->name('contracts.download');
    Route::get('/announcements', [Tenant\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/profile',       [Tenant\ProfileController::class,      'index'])->name('profile');
    Route::put('/profile',       [Tenant\ProfileController::class,      'update'])->name('profile.update');
});