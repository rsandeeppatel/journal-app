<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

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
        /** D in timestampsD stand for defaults */
        Blueprint::macro('timestampsD', function ($precision = 0): void {
            /** @var Blueprint $this */
            $this->timestamp('created_at')->useCurrent();
            $this->timestamp('updated_at')->nullable()->default(null)->useCurrentOnUpdate();
        });
    }
}
