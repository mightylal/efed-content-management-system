<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\ForumTopicRepository as ForumTopicRepositoryInterface;
use Efed\Models\ForumTopic;

class ForumTopicRepository implements ForumTopicRepositoryInterface
{

    /**
     * @var ForumTopic
     */
    private $model;

    /**
     * Insert id.
     */
    private $insertId;
    
    /**
     * Start new ForumTopicRepository.
     * 
     * @param ForumTopic $model
     */
    public function __construct(ForumTopic $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all the topics given the category id.
     *
     * @param integer $category_id
     * @param array $columns (optional)
     * @return array
     */
    public function topics($category_id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('category_id', $category_id)->get()->toArray();
    }

    /**
     * Create new topic.
     *
     * @param array $attributes
     */
    public function create(array $attributes)
    {
        $topic = $this->model->create($attributes);
        $this->insertId = $topic->id;
    }

    /**
     * Retrieve the insert id of created topic.
     *
     * @return integer
     */
    public function insertId()
    {
        return $this->insertId;
    }

    /**
     * Retrieve the topic.
     *
     * @param integer $topic_id
     * @param array $columns (optional)
     * @return array
     */
    public function get($topic_id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('id', $topic_id)->first()->toArray();
    }

    /**
     * Update the topic.
     *
     * @param integer $topic_id
     * @param array $attributes
     */
    public function update($topic_id, $attributes)
    {
        $this->model->where('id', $topic_id)->update($attributes);
    }

    /**
     * Check to see if the topic exists.
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }


}