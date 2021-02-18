<?php

namespace Fennecio\PhoneVerification;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SearchInModelServiceProvider extends ServiceProvider {


    
    public function register()
    {
        
        // $this->mergeConfigFrom(__DIR__.'/config/phone_verification.php', 'phone_verification');

    }

    public function boot(){

        // publish 
        // $this->publishes([
        //     __DIR__.'/config/phone_verification.php' => config_path('phone_verification.php'),

        // ],'phone-verification-config');

        // components 
        $this->publishes([
            __DIR__.'/Resources/ExampleSearch.vue' => resource_path('js/Pages/Search/ExampleSearch.vue'),
           ], 'search-in-model-components');


           $this->publishes([
            __DIR__.'/Exceptions/SearchException.php' => app_path('Exceptions/Search/SearchException.php'),
        ], 'search-in-model-exception');

        
           $this->publishes([
            __DIR__.'/Requests/SearchRequest.php' => app_path('Http/Requests/SearchRequest.php'),
        ], 'search-in-model-request');



        // // routes
        // $this->publishes([
        //     __DIR__.'/routes/phone_verification.php' => base_path('routes/phone_verification.php'),
        // ], 'phone_verification-routes');
       


        // Route::group([
        //     'namespace' => 'Fennecio\PhoneVerification\Http\Controllers',
        // ], function () {
        //     $this->loadRoutesFrom(__DIR__.'/routes/phone_verification.php');
        // });
    }



}