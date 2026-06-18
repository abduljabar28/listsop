<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListSopController;

Route::get('/', [ListSopController::class, 'index'])->name('home');

Route::get('list_sop/unit/{workUnit}', [ListSopController::class, 'unit'])->name('list_sop.unit');
Route::resource('list_sop', ListSopController::class);
