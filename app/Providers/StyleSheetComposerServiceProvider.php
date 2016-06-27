<?php

namespace Efed\Providers;

use Illuminate\Support\ServiceProvider;

class StyleSheetComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'master', 'Efed\Http\ViewComposers\StyleSheetComposer'
        );
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
