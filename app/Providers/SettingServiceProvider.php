<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SiteSetting;
use App\Models\Offer;
use App\Models\Occassion;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view){
            $setting = SiteSetting::find('1');
            $currentDate = date('Y-m-d');
            $currentDate = date('Y-m-d', strtotime($currentDate));
            $nav_offers = Offer::whereDate('expire_date','>',$currentDate)->get(['name', 'slug']);
            $nav_occassion = Occassion::where('display',1)->get();
            return $view->with('setting', $setting)->with('nav_offers', $nav_offers)->with('nav_occassion', $nav_occassion);
        });
    }
}
