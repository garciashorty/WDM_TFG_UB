<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        Route::macro('catch', function ($action){
            $this->any('{anything}', $action)->where('anything', '.*')->fallback();
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        //$this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
        $this->mapUserRoutes();
        $this->mapDoctorRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     * require authentication and admin user etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'auth:admin'])
             ->namespace($this->namespace.'\Admin')
             ->prefix('/admin')
             ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "user" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     * require authentication and default user etc.
     *
     * @return void
     */
    protected function mapUserRoutes()
    {
        Route::middleware(['web', 'auth','user'])
             ->namespace($this->namespace.'\User')
             ->prefix('/user')
             ->group(base_path('routes/user.php'));
    }

    /**
     * Define the "doctor" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     * require authentication and doctor user etc.
     *
     * @return void
     */
    protected function mapDoctorRoutes()
    {
        Route::middleware(['web', 'auth', 'doctor'])
             ->namespace($this->namespace.'\Doctor')
             ->prefix('/doctor')
             ->group(base_path('routes/doctor.php'));
    }

    // /**
    //  * Define the "api" routes for the application.
    //  *
    //  * These routes are typically stateless.
    //  *
    //  * @return void
    //  */
    // protected function mapApiRoutes()
    // {
    //     Route::prefix('api')
    //          ->middleware('api')
    //          ->namespace($this->namespace)
    //          ->group(base_path('routes/api.php'));
    // }
}
