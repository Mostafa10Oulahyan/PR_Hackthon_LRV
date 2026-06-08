<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/livres', [ApiController::class, 'getLivres']);
Route::get('/membres', [ApiController::class, 'getMembres']);
Route::get('/emprunts', [ApiController::class, 'getEmprunts']);
Route::post('/emprunts', [ApiController::class, 'storeEmprunt']);
