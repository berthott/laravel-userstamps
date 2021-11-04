<?php

namespace berthott\Userstamps\Tests\Feature\AltColumns;

use berthott\Userstamps\UserstampServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public User $user1;
    public User $user2;

    public function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::create();
        $this->user2 = User::create();
    }

    protected function getPackageProviders($app)
    {
        return [
            UserstampServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setUpUserTable();
        $this->setUpentityTable();
        Config::set('auth.providers.users.model', User::class);
    }

    private function setUpUserTable(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    private function setUpentityTable(): void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('alt_created_by')->nullable();
            $table->unsignedBigInteger('alt_updated_by')->nullable();
            $table->unsignedBigInteger('alt_deleted_by')->nullable();
        });
    }
}
