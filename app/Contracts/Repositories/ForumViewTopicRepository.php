<?php

namespace Efed\Contracts\Repositories;

interface ForumViewTopicRepository
{

    /**
     * Check to see if there are unread topics given category for wrestler.
     *
     * @param array $topics
     * @param integer $category_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function unreadCategory($topics, $category_id, $wrestler_id);

    /**
     * Check to see if the topic is unread given topic for wrestler.
     *
     * @param integer $topic_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function unreadTopic($topic_id, $wrestler_id);

    /**
     * Create new view topic entry.
     *
     * @param integer $category_id
     * @param integer $topic_id
     * @param integer $wrestler_id
     */
    public function create($category_id, $topic_id, $wrestler_id);
    
    /**
     * Delete all the views for topic.
     * 
     * @param integer $topic_id
     */
    public function deleteAll($topic_id);
    
    /**
     * Check to see if wrestler view entry already exists.
     * 
     * @param integer $category_id
     * @param integer $topic_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function exists($category_id, $topic_id, $wrestler_id);

}