<?php

namespace Efed\Contracts\Repositories;


interface RoleplayGradeRepository
{
    
    /**
     * Check to see if the wrestler has graded roleplay.
     * 
     * @param integer $wrestler_id
     * @param integer $roleplay_id
     * @return boolean
     */
    public function hasGraded($wrestler_id, $roleplay_id);
    
    /**
     * Retrieve the grades and comments for the roleplay given the wrestler.
     * 
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return array
     */
    public function getByRoleplayAndWrestler($roleplay_id, $wrestler_id);
    
    /**
     * Retrieve all the grades and comments for the roleplay.
     * 
     * @param integer $roleplay_id
     * @return array
     */
    public function getByRoleplayForAdmin($roleplay_id);
    
    /**
     * Retrieve all the comments for the roleplay.
     * 
     * @param integer $roleplay_id
     * @return array
     */
    public function getByRoleplayForOwner($roleplay_id);
    
    /**
     * Create new grade.
     * 
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);
    
    /**
     * Retrieve the average grade for the roleplay.
     * 
     * @param integer $roleplay_id
     * @return number
     */
    public function average($roleplay_id);

}