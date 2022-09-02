<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Contracts\FeeCalculatorInterface;
use App\Http\Services\FeeCalculatorService;

use App\Http\Contracts\FileParsingInterface;
use App\Http\Services\FileParsingService;

//repositories
use App\Repositories\Contracts\PaymentRuleRepositoryInterface;
use App\Repositories\Classes\PaymentRuleRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(
          FeeCalculatorInterface::class,
          FeeCalculatorService::class
      );
      $this->app->bind(
          FileParsingInterface::class,
          FileParsingService::class
      );

      //repositories
      $this->app->bind(
          PaymentRuleRepositoryInterface::class,
          PaymentRuleRepository::class
      );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
