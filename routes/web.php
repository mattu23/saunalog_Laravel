<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaunalogController;

Route::get('/', [SaunalogController::class, 'index']);
