<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services.
     * here database connection information is updated based on the domains
     *
     * @return void
     */
    public function boot(){
       try {
           $domain = explode(".", parse_url($this->app['request']->root(),PHP_URL_HOST)); 

           if($this->app['config']->has("domains.connections.".$domain[0])){
             $this->app['config']->set(
                  "database.connections.mysql",
                  $this->app['config']->get("domains.connections.".$domain[0])
             );
              $this->app['config']->set(
                  "xmpp.address",
                  $this->app['config']->get("xmpp.connections.".$domain[0])
             );
             
           }
       } catch (\Exception $e) {
           $this->app['log']->error($e->getMessage());
       }
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        //
    }
}
