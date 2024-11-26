<?php

use App\Http\Controllers\GraphController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/homepage');

Route::redirect('/app', '/app/login');

Route::get('/homepage', function () {
    return view('index'); // 'yourview' is the name of the Blade view file
});

Route::get('pie-chart-filter', [GraphController::class, 'PieChartFilter'])->name('pie-chart-filter')->middleware('auth');

Route::get('bar-chart-filter', [GraphController::class, 'BarChartFilter'])->name('bar-chart-filter')->middleware('auth');

Route::get('line-chart-filter', [GraphController::class, 'LineChartFilter'])->name('line-chart-filter')->middleware('auth');

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');
