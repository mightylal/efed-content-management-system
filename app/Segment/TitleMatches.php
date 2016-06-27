<?php

namespace Efed\Segment;

use Illuminate\Database\DatabaseManager;

class TitleMatches
{

   /**
    * @var DatabaseManager
    */
    private $db;

    /**
     * Start new TitleMatches.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the title matches.
     *
     * @param integer $event_id
     * @return array
     */
    public function get($event_id)
    {
        return $this->db->connection('mysql')->table('eventSegment')
            ->selectRaw("eventSegment.id, eventSegment.title_id, eventSegmentWrestler.id AS segment_wrestler_id, eventSegmentWrestler.wrestler_id, eventSegmentWrestler.team_id")
            ->join('eventSegmentWrestler', 'eventSegment.id', '=', 'eventSegmentWrestler.segment_id')
            ->where('eventSegment.event_id', $event_id)
            ->where('eventSegment.title_id', '<>', 0)
            ->where('eventSegmentWrestler.winner', 1)
            ->get();
    }
    
}