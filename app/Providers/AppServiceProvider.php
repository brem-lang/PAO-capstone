<?php

namespace App\Providers;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as ContractsLoginResponse;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ContractsLoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

        FilamentColor::register([
            'primary' => Color::Teal,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
