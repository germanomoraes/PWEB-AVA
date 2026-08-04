<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Rotas da Lixeira (Soft Deletes)
    Route::get('/notas/lixeira', [NotaController::class, 'lixeira'])->name('notas.lixeira');
    Route::patch('/notas/{id}/restaurar', [NotaController::class, 'restaurar'])->name('notas.restaurar');
    Route::delete('/notas/{id}/forcar-exclusao', [NotaController::class, 'forcarExclusao'])->name('notas.forcar-exclusao');
    
    // Rotas normais do CRUD
    Route::resource('notas', NotaController::class);
});


