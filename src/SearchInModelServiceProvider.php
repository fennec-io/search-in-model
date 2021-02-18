<?php

namespace Fennecio\SearchInModel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SearchInModelServiceProvider extends ServiceProvider {


    
    public function register()
    {
        
        // $this->mergeConfigFrom(__DIR__.'/config/phone_verification.php', 'phone_verification');

    }

    public function boot(){

        // publish 

        $this->publishes([
            __DIR__.'/Resources/ExampleSearch.vue' => resource_path('js/Pages/Search/ExampleSearch.vue'),
           ], 'search-in-model-components');


           $this->publishes([
            __DIR__.'/Exceptions/SearchException.php' => app_path('Exceptions/Search/SearchException.php'),
        ], 'search-in-model-exception');

        
           $this->publishes([
            __DIR__.'/Requests/SearchRequest.php' => app_path('Http/Requests/SearchRequest.php'),
        ], 'search-in-model-request');

        
           $this->publishes([
            __DIR__.'/Models/BaseModel.php' => app_path('Models/BaseModel.php'),
        ], 'search-in-model-models');

           $this->publishes([
            __DIR__.'/Repositories/BaseRepository.php' => app_path('Repositories/BaseRepository.php'),
        ], 'search-in-model-repositories');


           $this->publishes([
            __DIR__.'/Traits/collection/CollectionHelpers.php' => app_path('Traits/collection/CollectionHelpers.php'),
            __DIR__.'/Traits/controller/HasSearch.php' => app_path('Traits/controller/HasSearch.php')
        
        ], 'search-in-model-traits');


    }



}