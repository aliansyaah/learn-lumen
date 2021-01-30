<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // Jika api_token disimpan di query params
        Auth::viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });

        /* Code di atas adalah code yg berada di dalam method boot() dimana boot
            ini sendiri adalah method yg digunakan utk mendapatkan data user
            berdasarkan token yg telah diverifikasi oleh middleware.
            
           Pada kasus ini kita melakukan query ke dalam table users berdasarkan 
           api_token yg telah kita terima dari middleware. 
         */

        // Jika api_token disimpan di header
        // Auth::viaRequest('api', function ($request) {
        //     if ($request->header('api_token')) {
        //         return User::where('api_token', $request->header('api_token'))->first();
        //     }
        // });
    }
}
