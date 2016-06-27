<?php

namespace Efed\Segment;

use Efed\Title\Available;
use Efed\Contracts\Repositories\SegmentWrestlerRepository;

class Edit
{

    /**
     * @var SegmentWrestlerRepository
     */
    private $segmentWrestlerRepo;

    /**
     * @var Available
     */
    private $available;

    /**
     * Winner of the match.
     */
    private $winner = 0;

    /**
     * Loser of the match.
     */
    private $loser = 0;

    /**
     * Single title matches.
     */
    private $single = ['1v1', '1v1v1', '1v1v1v1', '1v1v1v1v1', '1v1v1v1v1v1', '10', '20', '30'];

    /**
     * Tag team title matches.
     */
    private $tagTeam = ['2v2', '2v2v2', '2v2v2v2'];

    /**
     * Start new Edit.
     *
     * @param SegmentWrestlerRepository $segmentWrestlerRepo
     * @param Available $available
     */
    public function __construct(SegmentWrestlerRepository $segmentWrestlerRepo, Available $available)
    {
        $this->segmentWrestlerRepo = $segmentWrestlerRepo;
        $this->available = $available;
    }
    
    /**
     * Retrieve the titles.
     *
     * @param integer $segment_id
     * @param string $type
     * @return array
     */
    public function titles($segment_id, $type)
    {
        $wrestlers = $this->segmentWrestlerRepo->get($segment_id, ['wrestler_id']);
        foreach ($wrestlers as $key => $wrestler) {
            unset($wrestlers[$key]['wrestler']);
        }
        $title = '';
        if (in_array($type, $this->single)) {
            $title = 'Single';
        }
        if (in_array($type, $this->tagTeam)) {
            $title = 'Tag Team';
        }
        if (!$title) {
            return [0 => 'Non-Title'];
        }
        return $this->available->get($title, array_flatten($wrestlers));
    }
    
    /**
     * Get the wrestlers.
     * 
     * @param integer $segment_id
     * @return array
     */
    public function wrestlers($segment_id)
    {
        $wrestlers = $this->segmentWrestlerRepo->get($segment_id, ['id', 'wrestler_id', 'winner', 'loser']);
        $options = [];
        if (count($wrestlers) > 0) {
            foreach ($wrestlers as $wrestler) {
                $this->checkOutcome($wrestler);
                $options[$wrestler['wrestler']['id']] = $wrestler['wrestler']['name'];
            }
        }
        return $options;
    }

    /**
     * Check to see if winner or loser.
     *
     * @param array $wrestler
     * @return void
     */
    private function checkOutcome($wrestler)
    {
        if ($wrestler['winner']) {
            $this->winner = $wrestler['wrestler_id'];
        }
        if ($wrestler['loser']) {
            $this->loser = $wrestler['wrestler_id'];
        }
    }

    /**
     * Get the winner.
     *
     * @return integer
     */
    public function winner()
    {
        return $this->winner;
    }

    /**
     * Get the loser.
     *
     * @return integer
     */
    public function loser()
    {
        return $this->loser;
    }

}