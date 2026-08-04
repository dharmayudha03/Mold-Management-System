<?php

namespace App\Providers;

use App\Models\FormMjo;
use App\Models\FormRepairCetakan;
use App\Models\FormSandblasting;
use App\Models\FormSetupCetakan;
use App\Observers\FormMjoObserver;
use App\Observers\FormRepairCetakanObserver;
use App\Observers\FormSandblastingObserver;
use App\Observers\FormSetupCetakanObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.custom');

        FormSetupCetakan::observe(FormSetupCetakanObserver::class);
        FormSandblasting::observe(FormSandblastingObserver::class);
        FormRepairCetakan::observe(FormRepairCetakanObserver::class);
        FormMjo::observe(FormMjoObserver::class);
    }
}
