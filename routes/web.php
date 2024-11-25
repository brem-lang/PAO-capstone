<?php

use App\Http\Controllers\GraphController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/app');

Route::get('pie-chart-filter', [GraphController::class, 'PieChartFilter'])->name('pie-chart-filter')->middleware('auth');

Route::get('bar-chart-filter', [GraphController::class, 'BarChartFilter'])->name('bar-chart-filter')->middleware('auth');

Route::get('line-chart-filter', [GraphController::class, 'LineChartFilter'])->name('line-chart-filter')->middleware('auth');
