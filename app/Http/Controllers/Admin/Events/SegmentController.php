<?php

namespace Efed\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\SegmentService;
use Efed\Exceptions\ValidationException;
use Efed\Contracts\Repositories\EventRepository;
use Efed\Contracts\Repositories\WrestlerRepository;

class SegmentController extends Controller
{
    /**
     * @var SegmentService
     */
    private $segmentService;
    
    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new SegmentController.
     * 
     * @param SegmentService $segmentService
     * @param EventRepository $eventRepo
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(SegmentService $segmentService, EventRepository $eventRepo, WrestlerRepository $wrestlerRepo)
    {
        $this->segmentService = $segmentService;
        $this->eventRepo = $eventRepo;
        $this->wrestlerRepo = $wrestlerRepo;
    }
    /**
     * Display the admin book segment view.
     * 
     * @return view
     */
    public function create()
    {
        $events = $this->eventRepo->getUpcomingEvents(['id', 'name']);
        $wrestlers = $this->wrestlerRepo->getAvailableWrestlers(['id', 'name']);
        return view('admin.events.book_segment', compact('events', 'wrestlers'));
    }
    
    /**
     * Create new segment.
     * 
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        try {
            $this->segmentService->create($request->except('_token'));
            return redirect()->route('admin.events.segment.create')->with('message', 'Segment created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.events.segment.create')->withErrors($error->getErrors());
        }
    }

    /**
     * Display the edit segment view.
     *
     * @param integer $event_id
     * @param integer $id
     * @return view
     */
    public function edit($event_id, $id)
    {
        $segment = $this->segmentService->segment($id);
        $titles = $this->segmentService->titles($id);
        $wrestlers = $this->segmentService->wrestlers($id);
        $winner = $this->segmentService->winner();
        $loser = $this->segmentService->loser();
        return view('admin.events.manage_segment', compact('segment', 'titles', 'wrestlers', 'winner', 'loser'));
    }

    /**
     * Update a segment.
     *
     * @param integer $event_id
     * @param integer $id
     * @param Request $request
     * @return response
     */
    public function update($event_id, $id, Request $request)
    {
        try {
            $this->segmentService->update(trim($id), array_map('trim', $request->except('_token', '_method')));
            return redirect()->route('admin.events.segment.edit', ['id' => $event_id, 'segment_id' => $id])->with('message', 'Segment updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.events.segment.edit', ['id' => $event_id, 'segment_id' => $id])->withErrors($error->getErrors());
        }
    }
    
    /**
     * Delete a segment.
     * 
     * @param integer $event_id
     * @param integer $id
     * @return response
     */
    public function destroy($event_id, $id)
    {
        try {
            $this->segmentService->delete(trim($id));
            return redirect()->route('admin.events')->with('message', 'Segment deleted successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.events.segment.edit', ['id' => $event_id, 'segment_id' => $id])->withErrors($error->getErrors());
        }
    }
}
