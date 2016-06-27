<?php

namespace Efed\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\EventService;
use Efed\Services\Admin\SegmentService;
use Efed\Contracts\Repositories\EventRepository;
use Efed\Exceptions\ValidationException;

class EventController extends Controller
{
    /**
     * @var EventService
     */
    private $eventService;

    /**
     * @var SegmentService
     */
    private $segmentService;

    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * Start new EventService.
     * 
     * @param EventService $eventService
     * @param SegmentService $segmentService
     * @param EventRepository $eventRepo
     */
    public function __construct(EventService $eventService, SegmentService $segmentService, EventRepository $eventRepo)
    {
        $this->eventService = $eventService;
        $this->segmentService = $segmentService;
        $this->eventRepo = $eventRepo;
    }
    
    /**
     * Display the admin events view.
     * 
     * @return view
     */
    public function index()
    {
        $events = $this->eventService->events();
        return view('admin.events.events', compact('events'));
    }
    
    /**
     * User books an event.
     * 
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        try {
            $this->eventService->create(array_map('trim', $request->except('_token')));
            return redirect()->route('admin.events')->with('message', 'Event created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.events')->withErrors($error->getErrors());
        }
    }
    
    /**
     * Display the admin event edit view.
     * 
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $event = $this->eventRepo->find($id);
        $segments = $this->segmentService->segments($id);
        return view('admin.events.manage_event', compact('event', 'segments'));
    }

    /**
     * Update an event.
     *
     * @param integer $id
     * @param Request $request
     * @return response
     */
    public function update($id, Request $request)
    {
        try {
            $this->eventService->update(trim($id), $request->only('name', 'scheduled_at', 'preview', 'id'));
            return redirect()->route('admin.events.edit', ['id' => $id])->with('message', 'Event updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.events.edit', ['id' => $id])->withErrors($error->getErrors());
        }
    }
    
    /**
     * Run the event.
     * 
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function run($id, Request $request)
    {
        try {
            $this->eventService->run(array_map('trim', $request->only('event')));
            return redirect()->route('event', ['id' => $id])->with('message', 'Event is now live.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.events.edit', ['id' => $id])->withErrors($error->getErrors());
        }
    }
    
    /**
     * Delete an event.
     * 
     * @param Request $request
     * @return response
     */
    public function destroy(Request $request)
    {
        try {
            $this->eventService->delete($request->only('id'));
            return redirect()->route('admin.events')->with('message', 'Event(s) deleted successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.events')->withErrors($error->getErrors());
        }
    }
}
