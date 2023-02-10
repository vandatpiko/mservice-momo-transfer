<?php

namespace VandatPiko\Mservice;

use GuzzleHttp\Client;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use VandatPiko\Mservice\Contract\MserivceMomoContract;
use VandatPiko\Mservice\Models\MserviceMomo;

class MserviceMomoTransferServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/../config/mservice.php' => config_path('mservice.php'),
            ], 'mservice-config');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_mservice_momos_table.php' => $this->getMigrationFileName('create_mservice_momos_table.php'),
            ]);
        }

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__. '/../config/mservice.php', 'mservice');

        $this->app->singleton(MserivceMomoContract::class, function ($app) {
            $authFactory = app()->make(Factory::class);
            if (is_null(config('mservice.guard'))) {
                return new MserviceMomoTransfer(new Client([
                    'timeout'   => config('mservice.timeout'),
                ]), $authFactory);
            }
            return new MserviceMomoTransfer(new Client([
                'timeout'   => config('mservice.timeout'),
            ]), $authFactory->guard(config('mservice.guard')));
        });
    }

    /**
     * Returns existing migration file in found, else uses the current timestamp.
     * @return string
     */
    public function getMigrationFileName($migrationFileName)
    {
        $timestamp = date('Y_m_d_His', time());

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();

    }
}
