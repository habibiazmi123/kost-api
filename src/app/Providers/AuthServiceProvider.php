<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\RoomDiscussion;
use App\Policies\PropertyPolicy;
use App\Policies\RoomDiscussionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Property::class => PropertyPolicy::class,
        RoomDiscussion::class => RoomDiscussionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::before(function($user, $ability) {
            if ($user->hasPermission($ability)) {
                return true;
            }
        });
    }
}
