<?php

namespace Efed\Services\Admin;

use Efed\Contracts\Repositories\SegmentWrestlerRepository;
use Efed\Segment\SegmentWrestlerInsert;
use Efed\Segment\WrestlersInSegment;

class SegmentWrestlerService
{
    
    /**
     * @var SegmentWrestlerRepository
     */
    private $segmentWrestlerRepo;

    /**
     * @var WrestlersInSegment
     */
    private $wrestlersInSegment;
    
    /**
     * Start new SegmentWrestlerService.
     * 
     * @param SegmentWrestlerRepository $segmentWrestlerRepo
     * @param WrestlersInSegment $wrestlersInSegment
     */
    public function __construct(SegmentWrestlerRepository $segmentWrestlerRepo, WrestlersInSegment $wrestlersInSegment)
    {
        $this->segmentWrestlerRepo = $segmentWrestlerRepo;
        $this->wrestlersInSegment = $wrestlersInSegment;
    }

    /**
     * Create the segment wrestlers for segment.
     *
     * @param integer $segment_id
     * @param integer $type
     * @param array $wrestlers
     */
    public function create($segment_id, $type, $wrestlers)
    {
        $segmentWrestlers = (new SegmentWrestlerInsert)->format($segment_id, $type, $wrestlers);
        if (count($segmentWrestlers) > 0) {
            foreach ($segmentWrestlers as $segmentWrestler) {
                $this->segmentWrestlerRepo->create($segmentWrestler);
            }
        }
    }

    /**
     * Validate wrestlers in the segment.
     * 
     * @param integer $segment_id
     * @param integer $winner
     * @param integer $loser
     */
    public function validateWrestlersInSegment($segment_id, $winner, $loser)
    {
        $this->wrestlersInSegment->check($segment_id, $winner, $loser);
    }

    /**
     * Edit the segment winner and loser.
     *
     * @param integer $segment_id
     * @param integer $winner
     * @param integer $loser
     */
    public function update($segment_id, $winner, $loser)
    {
        $this->segmentWrestlerRepo->clearWinnerLoser($segment_id);
        $this->segmentWrestlerRepo->updateWinner($segment_id, $winner);
        $this->segmentWrestlerRepo->updateLoser($segment_id, $loser);
    }
    
    /**
     * Delete segment wrestlers.
     * 
     * @param integer $segment_id
     */
    public function delete($segment_id)
    {
        $this->segmentWrestlerRepo->delete($segment_id);
    }
    
}