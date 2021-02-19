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
            __DIR__.'/Stubs/SearchCriteria.php' => app_path('Criteria/Search/SearchCriteria.php'),
        ], 'search-in-model-criteria');

        
           $this->publishes([
            __DIR__.'/Stubs/SearchRequest.php' => app_path('Http/Requests/SearchRequest.php'),
        ], 'search-in-model-request');

        
           $this->publishes([
            __DIR__.'/Stubs/BaseModel.php' => app_path('Models/BaseModel.php'),
        ], 'search-in-model-models');

           $this->publishes([
            __DIR__.'/Stubs/SearchInModel.php' => app_path('Actions/Search/SearchInModel.php'),
        ], 'search-in-model-classes');
        
           $this->publishes([
            __DIR__.'/Stubs/SearchInModel.php' => app_path('Actions/Search/SearchInModel.php'),
        ], 'search-in-model-classes');
        

           $this->publishes([
            __DIR__.'/Stubs/CollectionHelpers.php' => app_path('Traits/collection/CollectionHelpers.php'),
            __DIR__.'/Stubs/HasSearch.php' => app_path('Traits/controller/Search/HasSearch.php')
        
        ], 'search-in-model-traits');


    }



}