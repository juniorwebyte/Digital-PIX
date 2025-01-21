<?php

namespace App\Providers;

use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale('pt_BR');

        view()->composer('*', function ($view) use ($auth) {

            $social = DB::table('consulting_environments')
                ->first();

            $user = User::find(1);

            $view->with('data', [
                'social' => @$social,
                'user' => @$user
            ]);
        });
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
