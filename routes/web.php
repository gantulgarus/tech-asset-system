<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoltController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\CauseCutController;
use App\Http\Controllers\PowerCutController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\PowerlineController;
use App\Http\Controllers\ProtectionController;
use App\Http\Controllers\CauseOutageController;
use App\Http\Controllers\PowerOutageController;
use App\Http\Controllers\PowerFailureController;
use App\Http\Controllers\EquipmentTypeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    // Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::resource('users', UserController::class);

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('volts', VoltController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('stations', StationController::class);
    Route::resource('equipment-types', EquipmentTypeController::class);
    Route::resource('equipment', EquipmentController::class);
    Route::get('/equipments/{stationId}', [EquipmentController::class, 'getEquipments']);
    Route::resource('protections', ProtectionController::class);
    Route::resource('cause_outages', CauseOutageController::class);
    Route::resource('cause_cuts', CauseCutController::class);
    Route::resource('power_outages', PowerOutageController::class);
    Route::get('/power_outages', [PowerOutageController::class, 'index'])->name('power_outages.index');
    Route::resource('power_failures', PowerFailureController::class);
    Route::resource('power_cuts', PowerCutController::class);
    Route::resource('schemas', SchemaController::class);
    Route::resource('powerlines', PowerlineController::class);
});