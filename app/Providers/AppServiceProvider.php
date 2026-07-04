<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
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
        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            if (config('database.default') === 'mysql') {
                config(['database.default' => 'sqlite']);
                config(['database.connections.sqlite.database' => database_path('database.sqlite')]);

                if (!file_exists(database_path('database.sqlite'))) {
                    touch(database_path('database.sqlite'));
                }
            }
        }
    }
}
