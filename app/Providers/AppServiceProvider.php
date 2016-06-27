<?php

namespace Efed\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Efed\Contracts\Repositories\WrestlerRepository', 'Efed\Repositories\WrestlerRepository');
        $this->app->bind('Efed\Contracts\Repositories\EventRepository', 'Efed\Repositories\EventRepository');
        $this->app->bind('Efed\Contracts\Repositories\TitleRepository', 'Efed\Repositories\TitleRepository');
        $this->app->bind('Efed\Contracts\Repositories\PageRepository', 'Efed\Repositories\PageRepository');
        $this->app->bind('Efed\Contracts\Repositories\ForumRepository', 'Efed\Repositories\ForumRepository');
        $this->app->bind('Efed\Contracts\Repositories\RoleplayRepository', 'Efed\Repositories\RoleplayRepository');
        $this->app->bind('Efed\Contracts\Repositories\RoleplayGradeRepository', 'Efed\Repositories\RoleplayGradeRepository');
        $this->app->bind('Efed\Contracts\Repositories\SegmentRepository', 'Efed\Repositories\SegmentRepository');
        $this->app->bind('Efed\Contracts\Repositories\SegmentWrestlerRepository', 'Efed\Repositories\SegmentWrestlerRepository');
        $this->app->bind('Efed\Contracts\Repositories\ForumTopicRepository', 'Efed\Repositories\ForumTopicRepository');
        $this->app->bind('Efed\Contracts\Repositories\ForumViewTopicRepository', 'Efed\Repositories\ForumViewTopicRepository');
        $this->app->bind('Efed\Contracts\Repositories\ForumPostRepository', 'Efed\Repositories\ForumPostRepository');
        $this->app->bind('Efed\Contracts\Repositories\MessageWrestlerRepository', 'Efed\Repositories\MessageWrestlerRepository');
        $this->app->bind('Efed\Contracts\Repositories\TitleReignRepository', 'Efed\Repositories\TitleReignRepository');

        $this->app->bind('Staff', function () {
            return new \Efed\Models\Staff;
        });
    }
}
