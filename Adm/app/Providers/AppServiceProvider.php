<?php

namespace App\Providers;

use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\News;
use App\Models\Admin\Team;
use App\Models\Admin\Vacancy;
use App\Models\Admin\StaticPage;
use App\Observers\AdminCategoryObserver;
use App\Observers\AdminProductObserver;
use App\Observers\AdminNewsObserver;
use App\Observers\AdminStaticPageObserver;
use App\Observers\AdminTeamObserver;
use App\Observers\AdminVacancyObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
        date_default_timezone_set('Europe/Minsk');
        Category::observe(AdminCategoryObserver::class);
        Product::observe(AdminProductObserver::class);
        News::observe(AdminNewsObserver::class);
        StaticPage::observe(AdminStaticPageObserver::class);
        
    }
}
