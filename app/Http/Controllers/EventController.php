<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Contracts\Repositories\EventRepository;
use Efed\Segment\Builder;

class EventController extends Controller
{

    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * Start new EventController.
     *
     * @param EventRepository $eventRepo
     */
    public function __construct(EventRepository $eventRepo)
    {
        $this->eventRepo = $eventRepo;
    }

    /**
     * Display the event list.
     *
     * @return view
     */
    public function index()
    {
        $events = $this->eventRepo->allListing(['id', 'name', 'scheduled_at', 'deadline_at']);
        return view('events', compact('events'));
    }

    /**
     * Display the individual event.
     *
     * @return view
     */
    public function show($id)
    {
        $segments = [];
        $event = $this->eventRepo->getWithSegments($id);
        if (count($event->segments) > 0) {
            foreach ($event->segments as $segment) {
                $segments[] = (new Builder($segment))->build();
            }
        }
        return view('event', compact('event', 'segments'));
    }
}
