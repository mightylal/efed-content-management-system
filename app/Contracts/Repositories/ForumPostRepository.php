<?php

namespace Efed\Contracts\Repositories;

interface ForumPostRepository
{

    /**
     * Create new post.
     *
     * @param array $attributes
     */
    public function create(array $attributes);
    
    /**
     * Retrieve the post.
     * 
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*']);
    
    /**
     * Update the post.
     * 
     * @param integer $id
     * @param array $attributes
     */
    public function update($id, $attributes);
    
    /**
     * Check to see if the forum post exists.
     * 
     * @param integer $id
     * @return boolean
     */
    public function exists($id);

    /**
     * Retrieve posts given topic.
     *
     * @param integer $topic_id
     * @param array $columns (optional)
     * @return array
     */
    public function getByTopic($topic_id, $columns = ['*']);

}