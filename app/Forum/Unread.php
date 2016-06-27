<?php

namespace Efed\Forum;

use Efed\Contracts\Repositories\ForumTopicRepository;
use Efed\Contracts\Repositories\ForumViewTopicRepository;

class Unread
{
    /**
     * @var ForumTopicRepository
     */
    private $forumTopicRepo;

    /**
     * @var ForumViewTopicRepository
     */
    private $forumViewTopicRepo;

    /**
     * Start new Unread.
     * 
     * @param ForumTopicRepository $forumTopicRepo
     * @param ForumViewTopicRepository $forumViewTopicRepo
     */
    public function __construct(ForumTopicRepository $forumTopicRepo, ForumViewTopicRepository $forumViewTopicRepo)
    {
        $this->forumTopicRepo = $forumTopicRepo;
        $this->forumViewTopicRepo = $forumViewTopicRepo;
    }
    
    /**
     * Check to see if the wrestler has unread category topics.
     * 
     * @param integer $category_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function category($category_id, $wrestler_id)
    {
        $topics = $this->forumTopicRepo->topics($category_id, ['id']);
        return $this->forumViewTopicRepo->unreadCategory($topics, $category_id, $wrestler_id);
    }
    
    /**
     * Check to see if the topic is unread.
     * 
     * @param integer $topic_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function topic($topic_id, $wrestler_id)
    {
        return $this->forumViewTopicRepo->unreadTopic($topic_id, $wrestler_id);
    }
    
}