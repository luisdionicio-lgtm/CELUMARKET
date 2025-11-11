<?php

namespace App\Providers;

use App\Listeners\MergeSessionCart;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            MergeSessionCart::class,
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
