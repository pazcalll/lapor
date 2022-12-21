<?php

namespace App\Providers;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\UserController;
use App\Interfaces\UserInterface;
use App\Repositories\AdminRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OpdRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->when(UserController::class)
            ->needs(UserInterface::class)
            ->give(function () {
                return new UsersRepository;
            });

        $this->app->when(CustomerController::class)
            ->needs(UserInterface::class)
            ->give(function () {
                return new CustomerRepository;
            });

        $this->app->when(AdminController::class)
            ->needs(UserInterface::class)
            ->give(function () {
                return new AdminRepository;
            });

        $this->app->when(OpdController::class)
            ->needs(UserInterface::class)
            ->give(function () {
                return new OpdRepository;
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
