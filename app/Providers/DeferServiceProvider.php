<?php

namespace App\Providers;

use App\Services\ProductService;
use App\Services\ProductCategoryService;
use App\Services\ProductImageService;
use Illuminate\Support\ServiceProvider;

class DeferServiceProvider extends ServiceProvider
{
    /**
     * プロバイダのローディングを遅延させるフラグ
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService();
        });
        $this->app->singleton(ProductCategoryService::class, function ($app) {
            return new ProductCategoryService();
        });
        $this->app->singleton(ProductImageService::class, function ($app) {
            return new ProductImageService();
        });
    }

    /**
     * このプロバイダにより提供されるサービス
     *
     * @return array
     */
    public function provides()
    {
        return [
            ProductService::class,
            ProductCategoryService::class,
            ProductImageService::class,
        ];
    }
}
