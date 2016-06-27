<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\ForumViewTopicRepository as ForumViewTopicRepositoryInterface;
use Efed\Models\ForumViewTopic;

class ForumViewTopicRepository implements ForumViewTopicRepositoryInterface
{

    /**
     * @var ForumViewTopic
     */
    private $model;

    /**
     * Start new ForumViewTopicRepository.
     *
     * @param ForumViewTopic $model
     */
    public function __construct(ForumViewTopic $model)
    {
        $this->model = $model;
    }

    /**
     * Check to see if there are unread topics given category for wrestler.
     *
     * @param array $topics
     * @param integer $category_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function unreadCategory($topics, $category_id, $wrestler_id)
    {
        return (bool) $this->model->where('category_id', $category_id)->where('wrestler_id', $wrestler_id)->whereNotIn('topic_id', $topics)->count();
    }

    /**
     * Check to see if the topic is unread given topic for wrestler.
     *
     * @param integer $topic_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function unreadTopic($topic_id, $wrestler_id)
    {
        return (bool) $this->model->where('topic_id', $topic_id)->where('wrestler_id', $wrestler_id)->count();
    }

    /**
     * Create new view topic entry.
     *
     * @param integer $category_id
     * @param integer $topic_id
     * @param integer $wrestler_id
     */
    public function create($category_id, $topic_id, $wrestler_id)
    {
        $this->model->create(['category_id' => $category_id, 'topic_id' => $topic_id, 'wrestler_id' => $wrestler_id]);
    }

    /**
     * Delete all the views for topic.
     *
     * @param integer $topic_id
     */
    public function deleteAll($topic_id)
    {
        $this->model->where('topic_id', $topic_id)->delete();
    }

    /**
     * Check to see if wrestler view entry already exists.
     *
     * @param integer $category_id
     * @param integer $topic_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function exists($category_id, $topic_id, $wrestler_id)
    {
        return $this->model->where('category_id', $category_id)->where('topic_id', $topic_id)->where('wrestler_id', $wrestler_id)->exists();
    }


}