<?php

namespace Efed\Providers;

use Illuminate\Support\ServiceProvider;
use Efed\Contracts\Repositories\EventRepository;
use Validator;
use Efed\Models\Settings;
use Efed\Contracts\Repositories\RoleplayRepository;

class RoleplayValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param EventRepository $eventRepo
     * @param RoleplayRepository $roleplayRepo
     * @return void
     */
    public function boot(EventRepository $eventRepo, RoleplayRepository $roleplayRepo)
    {
        Validator::extend('event_within_deadline', function ($attribute, $value, $parameters, $validator) use ($eventRepo) {
            return $eventRepo->isWithinDeadline($value);
        });
        Validator::extend('event_max', function ($attribute, $value, $parameters, $validator) use ($roleplayRepo) {
            $roleplays = $roleplayRepo->countForEvent($parameters[0], $value);
            $settings = (new Settings)->get();
            return $roleplays <= $settings->roleplayLimit;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
