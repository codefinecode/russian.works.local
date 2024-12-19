<?php

namespace App\Providers;

use App\Models\ArticleCounter;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        ArticleCounter::all()->each(function ($counter) {
            Redis::setnx("article:{$counter->article_id}:likes", $counter->likes);
            Redis::setnx("article:{$counter->article_id}:views", $counter->views);
        });
;
    }
}
