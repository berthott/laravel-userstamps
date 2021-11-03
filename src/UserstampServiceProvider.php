<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class UserstampServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // add blueprint macros
        Blueprint::macro(
            'userstamps',
            function () {
                $this->unsignedBigInteger('created_by')->nullable()->index();
                $this->unsignedBigInteger('updated_by')->nullable()->index();
                $this->unsignedBigInteger('deleted_by')->nullable()->index();
            }
        );
        Blueprint::macro(
            'addForeignUserstamps',
            function () {
                $this->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                $this->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
                $this->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            }
        );
        Blueprint::macro(
            'dropUserstamps',
            function () {
                $this->dropColumn(['created_by', 'updated_by', 'deleted_by']);
            }
        );
        Blueprint::macro(
            'dropForeignUserstamps',
            function () {
                $this->dropForeign(['created_by', 'updated_by', 'deleted_by']);
            }
        );

        // add config
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'userstamps');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // publish config
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('userstamps.php'),
        ], 'config');
    }
}