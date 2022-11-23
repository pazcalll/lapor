<?php

namespace App\Providers;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Interfaces\UserInterface;
use App\Repositories\AnotherUserRepository;
use App\Repositories\CustomerRepository;
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
        // $this->app->bind(UserInterface::class, UsersRepository::class);
        // $this->app->bind(UserInterface::class, AnotherUserRepository::class);
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