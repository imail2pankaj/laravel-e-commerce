<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(
            [
                'frontend.layout.header',
                'frontend.layout.footer',
            ],
            function ($view) {

                $categories = Cache::rememberForever('nav_categories', function () {
                    return Category::where('status', 'published')
                        ->select('id', 'name', 'slug')
                        ->orderBy('name')
                        ->get();
                });

                $view->with('categories', $categories);
            }
        );
    }
}
