<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\TranzactionRepositoryInterface;
use App\Repositories\TranzactionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TranzactionRepositoryInterface::class, TranzactionRepository::class);
    }
}
