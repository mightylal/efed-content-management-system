<?php

namespace Efed\Segment;

class SegmentWrestlerInsert
{

    /**
     * Format the wrestler team for creating in segment wrestler repo.
     *
     * @param integer $segment_id
     * @param string $type
     * @param array $wrestlers
     * @return array
     */
    public function format($segment_id, $type, $wrestlers)
    {
        if (strpos($type, 'v') === false) {
            $teams = array_fill(0, $type, 1);
        } else {
            $teams = explode('v', $type);
        }
        $wrestlerKey = 0;
        $segmentWrestlers = [];
        foreach ($teams as $teamKey => $team) {
            $i = 1;
            for ($i = 1; $i <= $team; $i++) {
                $segmentWrestlers[] = ['segment_id' => $segment_id, 'wrestler_id' => $wrestlers[$wrestlerKey], 'team_id' => ($teamKey + 1)];
                $wrestlerKey++;
            }
        }
        return $segmentWrestlers;
    }

}