<?php

namespace Efed\Contracts\Repositories;

interface ForumRepository
{

    /**
     * Create new forum.
     * 
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);
    
    /**
     * Retrieve all the forums.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*']);

    /**
     * Retrieve the forum given the category id.
     *
     * @param integer $category_id
     * @param array $columns (optional)
     * @return array
     */
    public function topics($category_id, $columns = ['*']);

    /**
     * Retrieve the forum and posts given the category and topic.
     *
     * @param integer $category_id
     * @param integer $topic_id
     * @param array $columns (optional)
     * @return array
     */
    public function posts($category_id, $topic_id, $columns = ['*']);
    
    /**
     * Check to see if the forum category exists.
     * 
     * @param integer $category_id
     * @return boolean
     */
    public function exists($category_id);
    
    /**
     * Get the forum.
     * 
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*']);
    
    /**
     * Count the number of forum categories.
     * 
     * @return integer
     */
    public function count();
    
    /**
     * Update the forum.
     * 
     * @param integer $id
     * @param array $attributes
     */
    public function update($id, $attributes);
    
    /**
     * Delete the forum.
     * 
     * @param integer $id
     */
    public function delete($id);

}