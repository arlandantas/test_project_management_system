<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'user' => Auth::user(),
    ]);
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return redirect('home');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
