<?php

namespace Efed\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Efed\Contracts\Repositories\WrestlerRepository;

class TitleValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param WrestlerRepository $wrestlerRepo
     * @return void
     */
    public function boot(WrestlerRepository $wrestlerRepo)
    {
        Validator::extend('wrestlers_match_title', function ($attribute, $value, $parameters, $validator) {
            $values = array_count_values($value);
            return count($values) === array_sum($values) || isset($values[0]);
        });
        Validator::extend('vacant_title', function ($attribute, $value, $parameters, $validator) {
            $values = array_count_values($value);
            if (isset($values[0])) {
                return count($values) === 1;
            }
            return true;
        });
        Validator::extend('exists_title', function ($attribute, $value, $parameters, $validator) use ($wrestlerRepo) {
            if ($value == 0) {
                return true;
            }
            return $wrestlerRepo->exists($value);
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
