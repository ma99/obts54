<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Controllers\Payment\PaymentSuccessController;
use App\Http\Controllers\Payment\PaymentFailedController;
use App\Http\Controllers\Payment\PaymentCancelledController;

use App\Repositories\Payment\PaymentSuccessRepository;
use App\Repositories\Payment\PaymentFailedRepository;
use App\Repositories\Payment\PaymentCancelledRepository;

use App\Repositories\Payment\PaymentRepositoryInterface;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(PaymentSuccessController::class)
          ->needs(PaymentRepositoryInterface::class)
          ->give(PaymentSuccessRepository::class);

        $this->app->when(PaymentFailedController::class)
          ->needs(PaymentRepositoryInterface::class)
          ->give(PaymentFailedRepository::class);

        $this->app->when(PaymentCancelledController::class)
          ->needs(PaymentRepositoryInterface::class)
          ->give(PaymentCancelledRepository::class);

    }
}
