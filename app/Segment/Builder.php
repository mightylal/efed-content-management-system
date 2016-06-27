<?php

namespace Efed\Segment;

use Efed\Models\Segment;

class Builder
{

    /**
     * @var $segment
     */
    private $segment;

    /**
     * @var $winner
     */
    private $winner = null;

    /**
     * @var $loser
     */
    private $loser = null;

    /**
     * @var $wrestlers
     */
    private $wrestlers;

    /**
     * @var $result
     */
    private $result;

    /**
     * Start new Builder.
     *
     * @param Segment $segment
     */
    public function __construct(Segment $segment)
    {
        $this->segment = $segment;
    }
    
    /**
     * Prepare the segment.
     *
     * @return string
     */
    public function build()
    {
        if ($this->segment->type == 0) {
            return ['name' => $this->segment->name, 'result' => $this->segment->result];
        }
        $slots = explode('v', $this->segment->type);
        $teams = $this->teams($slots);
        $this->format($teams);
        return ['name' => $this->segment->name, 'wrestlers' => $this->wrestlers, 'result' => $this->result];
    }

    /**
     * Group the wrestlers by team.
     *
     * @param array $slots
     * @return array
     */
    private function teams($slots)
    {
        $team = 1;
        $teams = [];
        $this->segment->load('wrestlers');
        foreach ($slots as $slot) {
            foreach ($this->segment->wrestlers as $wrestler) {
                $wrestler->load(['wrestler' => function ($query) {
                    $query->select('id', 'name');
                }]);
                $wrestler->wrestler->load(['image' => function ($query) {
                    $query->select('wrestler_id', 'url');
                }]);
                if ($wrestler->winner) {
                    $this->winner = e($wrestler->wrestler->name);
                }
                if ($wrestler->loser) {
                    $this->loser = e($wrestler->wrestler->name);
                }
                $url = null;
                if ($wrestler->wrestler->image) {
                    $url = e($wrestler->wrestler->image->url);
                }
                if ($wrestler->team_id === $team) {
                    $teams[$team][] = ['id' => e($wrestler->wrestler->id), 'name' => e($wrestler->wrestler->name), 'url' => $url];
                }
            }
            $team++;
        }
        return $teams;
    }
    
    /**
     * Format how the segment looks.
     * 
     * @param array $teams
     * @return string
     */
    private function format($teams)
    {
        $segment = "";
        $i = 1;
        foreach ($teams as $team) {
            $segment .= "<div style='display: inline-block;'>";
            foreach ($team as $wrestler) {
                $segment .= "<div style='display: inline-block; margin-top: 25px; margin-left: 2px; margin-right: 2px;'><img src='" . wrestlerImage($wrestler['url']) . "' height='100' width='100' alt='" . $wrestler['name'] . "'><div>" . $wrestler['name'] ."</div></div>";
            }
            $segment .= "</div>";
            if ($i < count($teams)) {
                $segment .= "<div style='display: inline-block; padding-left: 10px; padding-right: 10px; position: relative; bottom: 60px;'>VS.</div>";
                $i++;
            }
        }
        $this->result();
        $this->wrestlers = $segment;
    }
    
    /**
     * Format the segment result.
     */
    private function result()
    {
        $result = $this->segment->result;
        if ($this->segment->type != 0) {
            if ($this->winner === null && $this->loser === null) {
                $result .= "<div class='text-center'><strong>DRAW</strong></div>";
            } else {
                $result .= "<div class='text-center'><strong>" . $this->winner . " defeated " . $this->loser . "</strong></div>";
            }
        }
        $this->result = $result;
    }
    
}