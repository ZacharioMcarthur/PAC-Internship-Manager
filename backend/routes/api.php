<?php

use App\Http\Controllers\Api\ActiviteController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PresenceController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);

    Route::get('/presences', [PresenceController::class, 'index']);
    Route::post('/presences/check-in', [PresenceController::class, 'checkIn']);
    Route::post('/presences/check-out', [PresenceController::class, 'checkOut']);

    Route::get('/activites', [ActiviteController::class, 'index']);
    Route::post('/activites', [ActiviteController::class, 'store']);
    Route::post('/activites/{activite}/approve', [ActiviteController::class, 'approve']);

    Route::get('/admin/departements', [AdminController::class, 'listDepartements']);
    Route::post('/admin/departements', [AdminController::class, 'createDepartement']);
    Route::post('/admin/affectations', [AdminController::class, 'assignStagiaire']);
    Route::get('/admin/reports/stagiaires.csv', [AdminController::class, 'exportStagiairesReport']);
});
