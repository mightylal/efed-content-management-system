<?php

namespace Efed\Title;

use Carbon\Carbon;
use Efed\Title\Title;
use Efed\Segment\TitleMatches;
use Efed\Contracts\Repositories\TitleReignRepository;
use Efed\Contracts\Repositories\SegmentWrestlerRepository;

class Change
{
    
    /**
     * @var TitleMatches
     */
    private $titleMatches;
    
    /**
     * @var TitleReignRepository
     */
    private $titleReignRepo;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var SegmentWrestlerRepository
     */
    private $segmentWrestlerRepo;

    /**
     * Start new Change.
     * 
     * @param TitleMatches $titleMatches
     * @param TitleReignRepository $titleReignRepo
     * @param Title $title
     * @param SegmentWrestlerRepository $segmentWrestlerRepo
     */
    public function __construct(TitleMatches $titleMatches, TitleReignRepository $titleReignRepo, Title $title, SegmentWrestlerRepository $segmentWrestlerRepo)
    {
        $this->titleMatches = $titleMatches;
        $this->titleReignRepo = $titleReignRepo;
        $this->title = $title;
        $this->segmentWrestlerRepo = $segmentWrestlerRepo;
    }
    
    /**
     * Handle any title changes.
     * 
     * @param integer $event_id
     */
    public function handle($event_id)
    {
        $matches = $this->titleMatches->get($event_id);
        foreach ($matches as $match) {
            $holder = $this->titleReignRepo->isHolder($match->title_id, $match->wrestler_id);
            if ($holder) {
                // title defense
                $this->titleReignRepo->update($holder['id'], ['defenses' => ($holder['defenses'] + 1), 'last_defense' => Carbon::now()->toDateTimeString()]);
            } else {
                // title change
                $wrestlers = $this->segmentWrestlerRepo->getByTeam($match->segment_wrestler_id, $match->team_id, ['wrestler_id']);
                $type = 'Single';
                if (count($wrestlers) === 2) {
                    $type = 'Tag Team';
                }
                $this->title->assign($match->title_id, $type, array_flatten($wrestlers));
            }
        }
    }


}