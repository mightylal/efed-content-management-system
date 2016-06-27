<?php

namespace Efed\Contracts\Repositories;

interface PageRepository
{
    
    /**
     * Create a page.
     * 
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);
    
    /**
     * Retrieve all the pages.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*']);
    
    /**
     * Retrieve a page.
     * 
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*']);
    
    /**
     * Update a page.
     * 
     * @param integer $id
     * @param array $attributes
     */
    public function update($id, $attributes);
    
    /**
     * Delete a page.
     * 
     * @param integer $id
     */
    public function delete($id);

    /**
     * Check to see if the page exists.
     *
     * @param integer $page_id
     * @return boolean
     */
    public function exists($page_id);

    /**
     * Count the number of pages.
     *
     * @return integer
     */
    public function count();
    
}