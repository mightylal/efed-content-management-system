<?php

namespace Efed\Services\Admin;

use DB;
use Efed\Segment\Edit;
use Efed\Validation\SegmentValidator;
use Efed\Exceptions\ValidationException;
use Efed\Services\Admin\SegmentWrestlerService;
use Efed\Contracts\Repositories\SegmentRepository;

class SegmentService
{
    
    /**
     * @var SegmentWrestlerService
     */
    private $segmentWrestlerService;

    /**
     * @var SegmentRepository
     */
    private $segmentRepo;

    /**
     * @var Edit
     */
    private $edit;

    /**
     * Start new SegmentService.
     *
     * @param SegmentWrestlerService $segmentWrestlerService
     * @param SegmentRepository $segmentRepo
     * @param Edit $edit
     */
    public function __construct(SegmentWrestlerService $segmentWrestlerService, SegmentRepository $segmentRepo, Edit $edit, SegmentValidator $validator)
    {
        $this->segmentWrestlerService = $segmentWrestlerService;
        $this->segmentRepo = $segmentRepo;
        $this->edit = $edit;
    }

    /**
     * Create a new segment.
     *
     * @param array $input
     * @return void
     */
    public function create($input)
    {
        if ($input['type'] != 0) {
            $wrestlers = array_map('trim', $input['wrestler']);
            unset($input['wrestler']);
            $input = array_map('trim', $input);
            $input['wrestler'] = $wrestlers;
        } else {
            $input = array_map('trim', $input);
        }
        (new SegmentValidator)->validateCreateSegment($input);
        DB::beginTransaction();
        $input['placement'] = $this->segmentRepo->count($input['event_id']) + 1;
        $this->segmentRepo->create($input);
        if ($input['type'] != 0) {
            $segment_id = $this->segmentRepo->insertId();
            $this->segmentWrestlerService->create($segment_id, $input['type'], $wrestlers);
        }
        DB::commit();
    }
    
    /**
     * Get the segments for the event.
     * 
     * @param integer $event_id
     * @return array
     */
    public function segments($event_id)
    {
        return $this->segmentRepo->getByEvent($event_id, ['id', 'name', 'publish', 'placement']);
    }
    
    /**
     * Get the segment.
     * 
     * @param integer $segment_id
     * @return array
     */
    public function segment($segment_id)
    {
        return $this->segmentRepo->get($segment_id);
    }

    /**
     * Get the titles when editing segment.
     *
     * @param integer $segment_id
     * @return array
     */
    public function titles($segment_id)
    {
        $segment = $this->segmentRepo->get($segment_id, ['type']);
        return $this->edit->titles($segment_id, $segment['type']);
    }

    /**
     * Get the wrestlers when editing segment.
     *
     * @param integer $segment_id
     * @return array
     */
    public function wrestlers($segment_id)
    {
        return $this->edit->wrestlers($segment_id);
    }
    
    /**
     * Get the winner when editing segment.
     * 
     * @return integer
     */
    public function winner()
    {
        return $this->edit->winner();
    }
    
    /**
     * Get the loser when editing segment.
     * 
     * @return integer
     */
    public function loser()
    {
        return $this->edit->loser();
    }

    /**
     * Update a segment.
     *
     * @param integer $segment_id
     * @param array $attributes
     * @throws ValidationException
     */
    public function update($segment_id, $attributes)
    {
        $titles = $this->titles($segment_id);
        if ($attributes['title_id'] != 0 && !array_key_exists($attributes['title_id'], $titles)) {
            throw new ValidationException('The title selected cannot be used in this match.');
        }
        $segment = $this->segmentRepo->get($segment_id, ['type']);
        if ($segment['type'] == 0) {
            $this->updateAngle($segment_id, $attributes);
            return;
        }
        (new SegmentValidator)->validateEditSegment($attributes);
        $winner = $attributes['winner'];
        $loser = $attributes['loser'];
        $this->segmentWrestlerService->validateWrestlersInSegment($segment_id, $winner, $loser);
        unset($attributes['winner'], $attributes['loser']);
        $attributes['publish'] = 1;
        $attributes['result'] = clean($attributes['result'], 'default');
        $this->segmentRepo->update($segment_id, $attributes);
        $this->segmentWrestlerService->update($segment_id, $winner, $loser);
    }

    /**
     * Update an angle.
     *
     * @param integer $segment_id
     * @param array $input
     */
    public function updateAngle($segment_id, $input)
    {
        (new SegmentValidator)->validateEditAngle($input);
        $input['publish'] = 1;
        $this->segmentRepo->update($segment_id, $input);
    }
    
    /**
     * Delete a segment.
     * 
     * @param integer $segment_id
     * @return void
     */
    public function delete($segment_id)
    {
        (new SegmentValidator)->validateDeleteSegment($segment_id);
        $this->segmentWrestlerService->delete($segment_id);
        $this->segmentRepo->delete($segment_id);
    }
    
}