<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Redirección personalizada post-login
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    public function boot(): void
    {
        // Aquí podés agregar personalizaciones de Fortify si las necesitás
        // (vistas de login, throttling, etc.)
    }
}
