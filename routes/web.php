<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpruntController;

Route::get('/', function () {
    return redirect()->route('emprunts.index');
});

Route::get('/emprunts', [EmpruntController::class, 'index'])->name('emprunts.index');
Route::get('/emprunts/create', [EmpruntController::class, 'create'])->name('emprunts.create');
Route::post('/emprunts', [EmpruntController::class, 'store'])->name('emprunts.store');
