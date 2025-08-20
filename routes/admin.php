<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resources([
        'projects' => ProjectController::class,
        'tasks' => TaskController::class,
    ]);
});
