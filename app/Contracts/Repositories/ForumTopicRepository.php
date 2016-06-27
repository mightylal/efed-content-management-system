<?php

namespace Efed\Contracts\Repositories;

interface ForumTopicRepository
{
    
    /**
     * Retrieve all the topics given the category id.
     * 
     * @param integer $category_id
     * @param array $columns (optional)
     * @return array
     */
    public function topics($category_id, $columns = ['*']);
    
    /**
     * Create new topic.
     * 
     * @param array $attributes
     */
    public function create(array $attributes);
    
    /**
     * Retrieve the insert id of created topic.
     * 
     * @return integer
     */
    public function insertId();
    
    /**
     * Retrieve the topic.
     * 
     * @param integer $topic_id
     * @param array $columns (optional)
     * @return array
     */
    public function get($topic_id, $columns = ['*']);
    
    /**
     * Update the topic.
     * 
     * @param integer $topic_id
     * @param array $attributes
     */
    public function update($topic_id, $attributes);
    
    /**
     * Check to see if the topic exists.
     * 
     * @param integer $id
     * @return boolean
     */
    public function exists($id);
    
}