<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ReportNotification;
use Illuminate\Support\Facades\View;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('reportsNotification', ReportNotification::orderBy('id', 'desc')->get());
    }
}
