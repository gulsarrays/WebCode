<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        \Route::group(['prefix' => 'api/'.env('API_VERSION', 'v1'), 'middleware' => 'api'], function() {
            Passport::routes();
        });


        Passport::tokensExpireIn(Carbon::now()->addDays(14));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::pruneRevokedTokens();
    }
}
