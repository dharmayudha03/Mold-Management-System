<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CodeItemController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\FormSetupCetakanController;
use App\Http\Controllers\FormSandblastingController;
use App\Http\Controllers\FormRepairCetakanController;
use App\Http\Controllers\FormMjoController;
use App\Http\Controllers\FormScheduleController;
use App\Http\Controllers\PenomoranRakController;
use App\Http\Controllers\CetakanNaikController;
use App\Http\Controllers\HistoryCetakanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ListCodeItemController;
use App\Http\Controllers\SetCodeItemController;
use App\Http\Controllers\CavCodeItemController;
use App\Http\Controllers\ListMesinController;
use App\Http\Controllers\NameMesinController;
use App\Http\Controllers\ClassMesinController;
use App\Http\Controllers\ListRakController;
use App\Http\Controllers\ListNoRakController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DetailUserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/api-data', [DashboardController::class, 'apiData'])->name('dashboard.api-data');

    // Mold Comprehensive Reports & Exports
    Route::get('/reports/molds', [ReportController::class, 'moldReport'])->name('reports.molds');
    Route::get('/reports/molds/export-csv', [ReportController::class, 'exportCsv'])->name('reports.molds.export-csv');
    Route::get('/reports/molds/print-pdf', [ReportController::class, 'printPdf'])->name('reports.molds.print-pdf');
    Route::get('/reports/molds/{listCodeItem}/history', [ReportController::class, 'historyLog'])->name('reports.molds.history');

    // Export Form Setup Cetakan
    Route::get('/form-setup-cetakans-export-csv', [FormSetupCetakanController::class, 'exportCsv'])->name('form-setup-cetakans.export-csv');
    Route::get('/form-setup-cetakans-print-pdf', [FormSetupCetakanController::class, 'printPdf'])->name('form-setup-cetakans.print-pdf');

    // Export Form Sandblasting
    Route::get('/form-sandblastings-export-csv', [FormSandblastingController::class, 'exportCsv'])->name('form-sandblastings.export-csv');
    Route::get('/form-sandblastings-print-pdf', [FormSandblastingController::class, 'printPdf'])->name('form-sandblastings.print-pdf');

    // Cetakan & Mesin
    Route::resource('code-items', CodeItemController::class);
    Route::resource('mesins', MesinController::class);

    // Form
    Route::resource('form-setup-cetakans', FormSetupCetakanController::class);
    Route::resource('form-sandblastings', FormSandblastingController::class);
    Route::resource('form-repair-cetakans', FormRepairCetakanController::class);
    Route::resource('form-mjos', FormMjoController::class);
    Route::resource('form-schedules', FormScheduleController::class);

    // Info
    Route::resource('penomoran-raks', PenomoranRakController::class);
    Route::resource('cetakan-naiks', CetakanNaikController::class);
    Route::resource('history-cetakans', HistoryCetakanController::class);
    Route::resource('kategoris', KategoriController::class);

    // Master Data CodeItem
    Route::resource('list-code-items', ListCodeItemController::class);
    Route::resource('set-code-items', SetCodeItemController::class);
    Route::resource('cav-code-items', CavCodeItemController::class);

    // Master Data Mesin
    Route::resource('list-mesins', ListMesinController::class);
    Route::resource('name-mesins', NameMesinController::class);
    Route::resource('class-mesins', ClassMesinController::class);

    // Master Data Rak
    Route::resource('list-raks', ListRakController::class);
    Route::resource('list-no-raks', ListNoRakController::class);

    // Administration
    Route::resource('users', UserController::class);
    Route::resource('detail-users', DetailUserController::class);

    // Dynamic dropdown API routes
    Route::get('api/code-item/sets', [CodeItemController::class, 'getSets'])->name('api.code-item.sets');
    Route::get('api/code-item/cavs', [CodeItemController::class, 'getCavs'])->name('api.code-item.cavs');
    Route::get('api/mesin/names', [MesinController::class, 'getNames'])->name('api.mesin.names');
    Route::get('api/mesin/classes', [MesinController::class, 'getClasses'])->name('api.mesin.classes');
    Route::get('api/role/detail-users', [DetailUserController::class, 'getByRole'])->name('api.role.detail-users');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
