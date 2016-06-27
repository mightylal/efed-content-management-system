<?php

namespace Efed\Repositories;

use Efed\Models\ForumPost;
use Efed\Contracts\Repositories\ForumPostRepository as ForumPostRepositoryInterface;

class ForumPostRepository implements ForumPostRepositoryInterface
{
    /**
     * @var ForumPost
     */
    private $model;

    /**
     * Start new ForumPostRepository.
     * 
     * @param ForumPost $model
     */
    public function __construct(ForumPost $model)
    {
        $this->model = $model;
    }
    
    /**
     * Create new post.
     *
     * @param array $attributes
     */
    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Retrieve the post.
     *
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*'])
    {
        $post = $this->model->select($columns)->where('id', $id)->first();
        $post->load(['wrestler' => function ($query) {
            $query->select('id', 'name');    
        }]);
        return $post->toArray();
    }

    /**
     * Update the post.
     *
     * @param integer $id
     * @param array $attributes
     */
    public function update($id, $attributes)
    {
        $this->model->where('id', $id)->update($attributes);
    }

    /**
     * Check to see if the forum post exists.
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }
    
    /**
     * Retrieve posts given topic.
     * 
     * @param integer $topic_id
     * @param array $columns (optional)
     * @return array
     */
    public function getByTopic($topic_id, $columns = ['*'])
    {
        $posts = $this->model->select($columns)->where('topic_id', $topic_id)->paginate(15);
        $posts->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }]);
        if (count($posts) > 0) {
            foreach ($posts as $post) {
                $post->wrestler->load(['image' => function ($query) {
                    $query->select('wrestler_id', 'url');
                }]);
            }
        }
        return $posts;
    }


}