<?php

namespace App\Repository;

use DB;
use App\User;
use App;
use Illuminate\Support\Facades\Artisan;
use App\Models\Main\WebAppTenants;
use App\Models\WebAppTenant\Posts;
use Config;
use Illuminate\Support\Collection;

class WebAppTenantRepository {

    static $webAppTenantConnection;

    public function __construct(UserRepository $user) {
        // constructor function for user
        $this->user = $user;
    }

    static public function createWebAppTenantDB($userId = null, $userName = null) {
        if (!empty($userId)) {
            $web_app_tenant_db = 'web_app_tenant_' . $userId;

            self::createSchema($web_app_tenant_db);


//          $databaseConnection = $this->configureConnectionByName(getTenantDBName(Auth::user()->account_id));
            $webAppTenantConnection = self::configureConnectionByName($web_app_tenant_db);


            Artisan::call('migrate', array('--database' => $web_app_tenant_db, '--path' => '/database/migrations/webAppTenant', '--verbose' => 'vvv'));

            self::sampleWebAppTenantDataSeeder($userId.'_'.$userName, $web_app_tenant_db);
            self::updateWebAppTenantTable($web_app_tenant_db, $userId);
            
            
//            config::set('database.connections.webAppTenant.database', $web_app_tenant_db);
//            Config::set('database.default', 'webAppTenant');
//            DB::reconnect('webAppTenant');
            
            // Set the context connection
            \Session::put('tenant_connection_db', $web_app_tenant_db);
                
            // return DB name
            return $web_app_tenant_db;
        }
    }

    static private function createSchema($schemaName) {
        // We will use the `statement` method from the connection class so that
        // we have access to parameter binding.
//        return DB::statement("CREATE DATABASE :schema", array('schema' => $schemaName));
        return DB::statement("CREATE DATABASE $schemaName");
    }

    /**
     * Configures a tenant's database connection.

     * @param  string $tenantName The database name.
     * @return void
     */
    static public function configureConnectionByName($web_app_tenant_db) {
        // Just get access to the config. 
        $config = App::make('config');

        // Will contain the array of connections that appear in our database config file.
        $connections = $config->get('database.connections');

        // This line pulls out the default connection by key (by default it's `mysql`)
        $defaultConnection = $connections['webAppTenant'];
        //$defaultConnection = $connections[$config->get('database.default')];
        // Now we simply copy the default connection information to our new connection.
        $newConnection = $defaultConnection;
        // Override the database name.
        $newConnection['database'] = $web_app_tenant_db;

        // This will add our new connection to the run-time configuration for the duration of the request.
        App::make('config')->set('database.connections.' . $web_app_tenant_db, $newConnection);
        // set the DB name for webAppTenant connection
        config::set('database.connections.webAppTenant.database', $web_app_tenant_db);
    }

    static private function updateWebAppTenantTable($web_app_tenant_db, $userId) {
        // insert user DB details for superadmin
        WebAppTenants::create([
            'db_host' => env('DB_HOST'),
            'db_name' => $web_app_tenant_db,
            'db_user' => env('DB_USERNAME'),
            'db_password' => env('DB_PASSWORD'),
            'user_id' => $userId
        ]);
    }

    static private function sampleWebAppTenantDataSeeder($userId, $web_app_tenant_db) {
        // sample data for newly created users DB
        Posts::create([
            'title' => 'Post Title for UserId : ' . $userId,
            'body' => 'Post Body for UserId : ' . $userId
        ]);
    }

}
