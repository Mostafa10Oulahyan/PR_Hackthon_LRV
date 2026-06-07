<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/livres', [ApiController::class, 'getLivres']);
Route::get('/emprunts', [ApiController::class, 'getEmprunts']);
Route::post('/emprunts', [ApiController::class, 'storeEmprunt']);
