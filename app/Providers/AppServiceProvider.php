<?php

namespace App\Providers;

use App\Models\Stock;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
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
        Paginator::useBootstrap();

        Validator::extend('unique_item_id_for_position_three', function ($attribute, $value, $parameters, $validator) {
            $count = Stock::where('item_id', $value)
                ->where('position_id', 3)
                ->count();

            return $count === 0;
        });
    }
}
