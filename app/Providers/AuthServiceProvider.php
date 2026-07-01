<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Policies\ContactPolicy;
use App\Policies\ContactGroupPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Contact::class => ContactPolicy::class,
        ContactGroup::class => ContactGroupPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
