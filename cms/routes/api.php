<?php

use App\Http\Controllers\Api\FamilyTreeController;
use Illuminate\Support\Facades\Route;

Route::get('/tree', [FamilyTreeController::class, 'index'])->name('api.tree');
