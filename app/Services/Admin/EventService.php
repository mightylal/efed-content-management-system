<?php

namespace Efed\Services\Admin;


use Efed\Title\Change;
use Efed\Placement\Placement;
use Efed\Validation\EventValidator;
use Efed\Exceptions\ValidationException;
use Efed\Contracts\Repositories\EventRepository;
use Efed\Contracts\Repositories\SegmentRepository;
use Efed\Contracts\Repositories\SegmentWrestlerRepository;

class EventService
{
    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * @var SegmentRepository
     */
    private $segmentRepo;

    /**
     * @var SegmentWrestlerRepository
     */
    private $segmentWrestlerRepo;

    /**
     * @var Change
     */
    private $change;

    /**
     * Start new EventService.
     * 
     * @param EventRepository $eventRepo
     * @param SegmentRepository $segmentRepo;
     * @param SegmentWrestlerRepository $segmentWrestlerRepo
     * @param Change $change
     */
    public function __construct(EventRepository $eventRepo, SegmentRepository $segmentRepo, SegmentWrestlerRepository $segmentWrestlerRepo, Change $change)
    {
        $this->eventRepo = $eventRepo;
        $this->segmentRepo = $segmentRepo;
        $this->segmentWrestlerRepo = $segmentWrestlerRepo;
        $this->change = $change;
    }
    
    /**
     * Create an event.
     * 
     * @param array $input
     * @return void
     */
    public function create($input)
    {
        (new EventValidator)->validateEvent($input);
        $this->eventRepo->create($input);
    }

    /**
     * Get the events that have not run.
     *
     * @return array
     */
    public function events()
    {
        return $this->eventRepo->getNotRunEvents(['id', 'name', 'scheduled_at']);
    }
    
    /**
     * Update an event.
     * 
     * @param integer $event_id
     * @param array $attributes
     * @return void
     */
    public function update($event_id, $attributes)
    {
        $event = $this->eventRepo->find($event_id, ['scheduled_at']);
        $id = $attributes['id'];
        unset($attributes['id']);
        (new EventValidator)->validateEditEvent($attributes, $event['scheduled_at']);
        $this->eventRepo->update($event_id, $attributes);
        $attributes = array_map('trim', $attributes);
        $attributes['id'] = $id;
        if (!empty($attributes['id'])) {
            (new Placement)->handle(new EventValidator, $this->segmentRepo, $attributes, $event_id);
        }
    }
    
    /**
     * Run the event.
     * 
     * @param array $input
     * @throws ValidationException
     */
    public function run($input)
    {
        (new EventValidator)->validateRun($input);
        if (!$this->segmentRepo->published($input['event'])) {
            throw new ValidationException('All segments must be published before an event can be ran.');
        }
        $this->eventRepo->update($input['event'], ['run' => 1]);
        $this->change->handle($input['event']);
    }

    /**
     * Delete an event.
     *
     * @param array $input
     */
    public function delete($input)
    {
        $input['id'] = array_map('trim', $input['id']);
        (new EventValidator)->validateDelete($input);
        foreach ($input['id'] as $event_id) {
            $segments = $this->segmentRepo->getByEvent($event_id, ['id']);
            foreach ($segments as $segment) {
                $this->segmentWrestlerRepo->delete($segment['id']);
                $this->segmentRepo->delete($segment['id']);
            }
            $this->eventRepo->delete($event_id);
        }
    }
    
}