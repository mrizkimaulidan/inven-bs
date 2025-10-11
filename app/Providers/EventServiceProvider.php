<?php

namespace App\Providers;

use App\Commodity;
use App\CommodityAcquisition;
use App\CommodityLocation;
use App\Observers\DepartmentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        Commodity::class            => [DepartmentObserver::class],
        CommodityLocation::class    => [DepartmentObserver::class],
        CommodityAcquisition::class => [DepartmentObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
