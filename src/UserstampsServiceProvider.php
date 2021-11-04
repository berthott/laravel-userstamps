<?php

namespace berthott\Userstamps;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class UserstampsServiceProvider extends ServiceProvider
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
                $this->unsignedBigInteger('created_by')->nullable();
                $this->unsignedBigInteger('updated_by')->nullable();
            }
        );
        Blueprint::macro(
            'softDeletesUserstamp',
            function () {
                $this->unsignedBigInteger('deleted_by')->nullable();
            }
        );
        Blueprint::macro(
            'addForeignUserstamps',
            function () {
                $this->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                $this->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            }
        );
        Blueprint::macro(
            'addForeignSoftDeletesUserstamp',
            function () {
                $this->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            }
        );
        Blueprint::macro(
            'dropUserstamps',
            function () {
                $this->dropColumn(['created_by', 'updated_by']);
            }
        );
        Blueprint::macro(
            'dropSoftDeletesUserstamp',
            function () {
                $this->dropColumn(['deleted_by']);
            }
        );
        Blueprint::macro(
            'dropForeignUserstamps',
            function () {
                $this->dropForeign(['created_by', 'updated_by']);
            }
        );
        Blueprint::macro(
            'dropForeignSoftDeletesUserstamp',
            function () {
                $this->dropForeign(['deleted_by']);
            }
        );

        // add config
        // $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'userstamps');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // publish config
        /* $this->publishes([
            __DIR__.'/../config/config.php' => config_path('userstamps.php'),
        ], 'config'); */
    }
}
