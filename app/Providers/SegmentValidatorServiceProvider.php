<?php

namespace Efed\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Efed\Contracts\Repositories\SegmentWrestlerRepository;

class SegmentValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param SegmentWrestlerRepository $segmentWrestlerRepo
     * @return void
     */
    public function boot(SegmentWrestlerRepository $segmentWrestlerRepo)
    {
        Validator::extend('wrestlers_match', function ($attribute, $value, $parameters, $validator) {
            $values = array_count_values($value);
            return count($values) === array_sum($values);
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
