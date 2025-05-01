<?php

namespace App\Providers;

use App\Repositories\Interfaces\EwaletTransactionInterface;
use App\Repositories\Interfaces\OrderPatternInterface;
use App\Repositories\Interfaces\PaymentInterface;
use App\Repositories\Interfaces\ShippingInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Patterns\EwaletTransactionRepository;
use App\Repositories\Patterns\OrderRepository;
use App\Repositories\Patterns\PaymentRepository;
use App\Repositories\Patterns\ProductRepository;
use App\Repositories\Interfaces\ProductPatternInterface;
use App\Repositories\Patterns\ShippingRepository;
use App\Repositories\Patterns\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductPatternInterface::class, ProductRepository::class);
        $this->app->bind(OrderPatternInterface::class, OrderRepository::class);
        $this->app->bind(EwaletTransactionInterface::class, EwaletTransactionRepository::class);
        $this->app->bind(PaymentInterface::class, PaymentRepository::class);
        $this->app->bind(ShippingInterface::class, ShippingRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
