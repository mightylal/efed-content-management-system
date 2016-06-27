<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\ForumRepository as ForumRepositoryInterface;
use Efed\Models\Forum;

class ForumRepository implements ForumRepositoryInterface
{
    
    /**
     * @var Forum
     */
    private $model;
    
    /**
     * Start new ForumRepository.
     * 
     * @param Forum $model
     * @return void
     */
    public function __construct(Forum $model)
    {
        $this->model = $model;
    }

    /**
     * Create new forum.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Retrieve all the forums.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*'])
    {
        return $this->model->select($columns)->orderBy('placement')->get()->toArray();
    }

    /**
     * Retrieve the forum given the category id.
     *
     * @param integer $category_id
     * @param array $columns (optional)
     * @return array
     */
    public function topics($category_id, $columns = ['*'])
    {
        $forum = $this->model->select($columns)->where('id', $category_id)->first();
        $forum->load('topics');
        $forum->topics->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $forum->toArray();
    }
    
    /**
     * Retrieve the forum and posts given the category and topic.
     * 
     * @param integer $category_id
     * @param integer $topic_id
     * @param array $columns (optional)
     * @return array
     */
    public function posts($category_id, $topic_id, $columns = ['*'])
    {
        $forum = $this->model->select($columns)->where('id', $category_id)->first();
        $forum->load(['topics' => function ($query) use ($topic_id) {
            $query->where('id', $topic_id);
        }]);
        $forum->topics->load('posts');
        return $forum->toArray();
    }

    /**
     * Check to see if the forum category exists.
     *
     * @param integer $category_id
     * @return boolean
     */
    public function exists($category_id)
    {
        return $this->model->where('id', $category_id)->exists();
    }

    /**
     * Get the forum.
     *
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('id', $id)->first()->toArray();
    }

    /**
     * Count the number of forum categories.
     *
     * @return integer
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Update the forum.
     *
     * @param integer $id
     * @param array $attributes
     */
    public function update($id, $attributes)
    {
        $this->model->where('id', $id)->update($attributes);
    }

    /**
     * Delete the forum.
     *
     * @param integer $id
     */
    public function delete($id)
    {
        $this->model->where('id', $id)->delete();
    }


}