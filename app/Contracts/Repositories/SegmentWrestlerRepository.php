<?php

namespace Efed\Contracts\Repositories;

interface SegmentWrestlerRepository
{
    
    /**
     * Create new segment wrestler.
     * 
     * @param array $attributes
     * @return void
     */
    public function create($attributes);
    
    /**
     * Retrieve the wrestlers in the segment.
     * 
     * @param integer $segment_id
     * @param array $columns (optional)
     * @return array
     */
    public function get($segment_id, $columns = ['*']);
    
    /**
     * Update the winner.
     * 
     * @param integer $segment_id
     * @param integer $wrestler_id
     * @return void
     */
    public function updateWinner($segment_id, $wrestler_id);
    
    /**
     * Update the loser.
     * 
     * @param integer $segment_id
     * @param integer $wrestler_id
     * @return void
     */
    public function updateLoser($segment_id, $wrestler_id);
    
    /**
     * Clear the winner and loser.
     * 
     * @param integer $segment_id
     * @return void
     */
    public function clearWinnerLoser($segment_id);
    
    /**
     * Check to see if wrestler exists in segment.
     * 
     * @param integer $segment_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function exists($segment_id, $wrestler_id);
    
    /**
     * Check to see if wrestlers are not on same team.
     * 
     * @param integer $segment_id
     * @param array $wrestlers
     * @return boolean
     */
    public function differentTeams($segment_id, $wrestlers);
    
    /**
     * Delete the segment wrestlers.
     * 
     * @param integer $segment_id
     * @return void
     */
    public function delete($segment_id);
    
    /**
     * Retrieve the wrestlers by team.
     * 
     * @param integer $id
     * @param integer $team_id
     * @param array $columns (optional)
     * @return array
     */
    public function getByTeam($id, $team_id, $columns = ['*']);
    
}