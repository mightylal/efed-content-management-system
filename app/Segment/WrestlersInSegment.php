<?php

namespace Efed\Segment;

use Efed\Contracts\Repositories\SegmentWrestlerRepository;
use Efed\Exceptions\ValidationException;

class WrestlersInSegment
{

    /**
     * @var SegmentWrestlerRepository
     */
    private $segmentWrestlerRepo;

    /**
     * Start new WrestlersInSegment.
     *
     * @param SegmentWrestlerRepository $segmentWrestlerRepo
     */
    public function __construct(SegmentWrestlerRepository $segmentWrestlerRepo)
    {
        $this->segmentWrestlerRepo = $segmentWrestlerRepo;
    }

    /**
     * Check to see if winner and loser are in segment and 
     * that winner and loser are not on same team.
     * 
     * @param integer $segment_id
     * @param integer $winner
     * @param integer $loser
     * @throws ValidationException
     */
    public function check($segment_id, $winner, $loser)
    {
        $winnerExists = $this->segmentWrestlerRepo->exists($segment_id, $winner);
        $loserExists = $this->segmentWrestlerRepo->exists($segment_id, $loser);
        $differentTeams = $this->segmentWrestlerRepo->differentTeams($segment_id, [$winner, $loser]);
        if (!$winnerExists) {
            throw new ValidationException('The selected winner is not in the match.');
        }
        if (!$loserExists) {
            throw new ValidationException('The selected loser is not in the match.');
        }
        if (!$differentTeams) {
            throw new ValidationException('The winner and loser must not be on the same team.');
        }
    }

}