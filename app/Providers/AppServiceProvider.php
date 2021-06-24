<?php

namespace App\Providers;

use App\Models\Branch;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Stevebauman\Location\Facades\Location;

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
        //
        $ip = '27.34.30.148'; //For static IP address get
        //$ip = request()->ip(); //Dynamic IP address get
        // $userlocation = Location::get($ip); //Get user coordinates
        // $branch = Branch::where('status', 1)->distance($userlocation->latitude, $userlocation->longitude)->orderBy('distance', 'ASC')->first(); //Choose nearest branch

        $branch = Branch::first();
        $setting = Setting::first();
        view()->share('branch', $branch);
        view()->share('setting', $setting);
    }
}
