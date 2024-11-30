<?php

use App\Http\Controllers\GraphController;
use App\Http\Controllers\PDFController;
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

Route::get('/generate-appointment-pdf/{interViewSheet}', [PDFController::class, 'generatePDF'])->name('generate-appointment-pdf')->middleware('auth');

Route::get('/generate-interviewsheet-pdf', [PDFController::class, 'sheet'])->name('generate-interviewsheet-pdf')->middleware('auth');

Route::get('/test', function () {

    $pdf = \PDF::loadView('pdf.advice')->setPaper('legal');

    return $pdf->stream(now()->format('Y-m-d h:i:s').'.pdf');
});
