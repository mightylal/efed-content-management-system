<?php

namespace Efed\Contracts\Repositories;

interface TitleReignRepository
{

    /**
     * Create new title reign.
     *
     * @param array $attributes
     */
    public function create(array $attributes);
    
    /**
     * Insert id.
     * 
     * @return integer
     */
    public function insertId();
    
    /**
     * Get the active reign for the title.
     * 
     * @param integer $title_id
     * @param array $columns (optional)
     * @return array
     */
    public function getActive($title_id, $columns = ['*']);

    /**
     * Update a title reign.
     *
     * @param integer $reign_id
     * @param array $attributes
     */
    public function update($reign_id, $attributes);
    
    /**
     * Delete reigns by title.
     * 
     * @param integer $title_id
     */
    public function deleteByTitle($title_id);
    
    /**
     * Check to see if the wrestler is the current holders.
     * 
     * @param integer $title_id
     * @param integer $wrestler
     * @return boolean
     */
    public function isHolder($title_id, $wrestler);

}