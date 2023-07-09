<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

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
        //        if (config('app.log_sql_queries')) {
        //            DB::listen(function ($query) {
        //                Log::channel('sql')->info('SQL Query', [
        //                    'sql'      => $query->sql,
        //                    'bindings' => $query->bindings,
        //                    'time'     => $query->time,
        //                ]);
        //            });
        //        }
    }
}
