<?php

namespace Efed\Http\ViewComposers;

use Illuminate\View\View;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Contracts\Repositories\EventRepository;
use Illuminate\Contracts\Auth\Guard;

class CreateRoleplayComposer
{

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * Start new CreateRoleplayComposer.
     *
     * @param WrestlerRepository $wrestlerRepo
     * @param EventRepository $eventRepo
     * @param Guard $auth
     * @return void
     */
    public function __construct(WrestlerRepository $wrestlerRepo, EventRepository $eventRepo, Guard $auth)
    {
        $this->wrestlerRepo = $wrestlerRepo;
        $this->eventRepo = $eventRepo;
        $this->auth = $auth;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $wrestler_id = $this->auth->id();
        $wrestlers = $this->wrestlerRepo->find($wrestler_id, ['id', 'name']);
        $events = $this->eventRepo->getUpcomingEvents();
        $view->with(compact('wrestlers', 'events'));
    }

}