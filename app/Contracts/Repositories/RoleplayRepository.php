<?php

namespace Efed\Contracts\Repositories;

interface RoleplayRepository
{
    
    /**
     * Create new roleplay.
     * 
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);
    
    /**
     * Retrieve all the roleplays.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*']);
    
    /**
     * Check to see if the roleplay exists given the id.
     * 
     * @param integer $id
     * @return boolean
     */
    public function exists($id);
    
    /**
     * Retrieve the roleplay given the id.
     * 
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*']);
    
    /**
     * Check to see if the wrestler is owner of roleplay.
     * 
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function isOwner($roleplay_id, $wrestler_id);
    
    /**
     * Retrieve the roleplays for the list and order by descending created date.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function allOrderByCreatedDateDesc($columns = ['*']);

    /**
     * Retrieve the roleplay with the event.
     * 
     * @param integer $roleplay_id
     * @param array $columns (optional)
     * @return array
     */
    public function getWithEvent($roleplay_id, $columns = ['*']);
    
    /**
     * Check to see if wrestler can edit roleplay.
     * 
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @param string $deadline_at
     * @return boolean
     */
    public function canEdit($roleplay_id, $wrestler_id);
    
    /**
     * Update a roleplay.
     * 
     * @param integer $id
     * @param array $attributes
     */
    public function update($id, $attributes);
    
    /**
     * Count the number of roleplays for the event.
     * 
     * @param integer $wrestler_id
     * @param integer $event_id
     * @return integer
     */
    public function countForEvent($wrestler_id, $event_id);
    
}