<?php

namespace App\Providers;

use App\Models\Alarm;
use App\Policies\AlarmPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Alarm::class => AlarmPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
} 