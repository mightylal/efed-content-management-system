<?php

namespace Efed\Contracts\Repositories;

interface TitleRepository
{
    /**
     * Create a new title.
     * 
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);
    
    /**
     * Retrieve all the titles.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*']);
    
    /**
     * Check to see if title exists.
     * 
     * @param integer $id
     * @return boolean
     */
    public function exists($id);
    
    /**
     * Find the title.
     * 
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function find($id, $columns = ['*']);

    /**
     * Update the title.
     *
     * @param integer $id
     * @param array $attributes
     * @return void
     */
    public function update($id, array $attributes);
    
    /**
     * Retrieve titles by type.
     * 
     * @param string $type
     * @param array $columns (optional)
     * @return array
     */
    public function getByType($type, $columns = ['*']);
    
    /**
     * Insert id.
     * 
     * @return integer
     */
    public function insertId();
    
    /**
     * Count the number of titles.
     * 
     * @return integer
     */
    public function count();
    
    /**
     * Delete a title.
     * 
     * @param integer $title_id
     */
    public function delete($title_id);
}