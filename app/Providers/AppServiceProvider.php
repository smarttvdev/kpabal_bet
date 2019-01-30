<?php

namespace App\Providers;

use View;
use App\Menu;
use App\Event;
use App\Social;
use App\Service;
use App\Advertisment;
use App\GeneralSettings;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        $data['basic'] = GeneralSettings::first();
        $data['events'] =  Event::whereStatus(1)->get();
        $data['menus'] =  Menu::all();
        $data['social'] =  Social::all();
        $data['services'] =  Service::all();

        view::share($data);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
