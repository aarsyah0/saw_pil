<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot(); // Panggil method boot dari parent class

        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::middleware('api')
            ->group(base_path('routes/api.php'));
    }
}

