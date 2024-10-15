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
use App\Http\Controllers\BusinessPlanController;
use App\Http\Controllers\PowerFailureController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\OutageScheduleController;
use App\Http\Controllers\MaintenancePlanController;
use App\Http\Controllers\EquipmentHistoryController;
use App\Http\Controllers\PowerlineGeojsonController;
use App\Http\Controllers\UserTierResearchController;
use App\Http\Controllers\ProtectionZoneViolationController;

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
    Route::post('/power_outage/{id}/upload-act', [PowerOutageController::class, 'uploadAct'])->name('power_outage.upload-act');
    Route::get('/power_outage/{id}/upload', [PowerOutageController::class, 'showUploadPage'])->name('power_outage.upload');
    Route::resource('power_failures', PowerFailureController::class);
    Route::resource('power_cuts', PowerCutController::class);
    Route::resource('schemas', SchemaController::class);
    Route::resource('powerlines', PowerlineController::class);
    Route::resource('equipment-histories', EquipmentHistoryController::class);
    Route::get('equipment/{equipment}/history/create', [EquipmentHistoryController::class, 'create'])
        ->name('equipment-history.create');
    Route::resource('powerlinegeojson', PowerlineGeojsonController::class);
    Route::resource('user_tier_research', UserTierResearchController::class);
    Route::resource('business-plans', BusinessPlanController::class);
    Route::resource('outage_schedules', OutageScheduleController::class);
    Route::resource('protection-zone-violations', ProtectionZoneViolationController::class);
    Route::resource('maintenance-plans', MaintenancePlanController::class);
    Route::get('maintenance-plan/{equipment}/create', [MaintenancePlanController::class, 'create'])->name('maintenance-plans.create');
});