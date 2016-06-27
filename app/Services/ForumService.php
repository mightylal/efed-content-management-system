<?php

namespace Efed\Services;

use Efed\Contracts\Repositories\ForumTopicRepository;
use Efed\Contracts\Repositories\ForumPostRepository;
use Efed\Contracts\Repositories\ForumViewTopicRepository;
use Efed\Validation\ForumValidator;
use Carbon\Carbon;

class ForumService
{

    /**
     * @var ForumTopicRepository
     */
    private $forumTopicRepo;

    /**
     * @var ForumPostRepository
     */
    private $forumPostRepo;

    /**
     * @var ForumViewTopicRepository
     */
    private $forumViewTopicRepo;
    
    /**
     * Start new ForumService.
     * 
     * @param ForumTopicRepository $forumTopicRepo
     * @param ForumPostRepository $forumPostRepo
     * @param ForumViewTopicRepository $forumViewTopicRepo
     */
    public function __construct(ForumTopicRepository $forumTopicRepo, ForumPostRepository $forumPostRepo, ForumViewTopicRepository $forumViewTopicRepo)
    {
        $this->forumTopicRepo = $forumTopicRepo;
        $this->forumPostRepo = $forumPostRepo;
        $this->forumViewTopicRepo = $forumViewTopicRepo;
    }
    
    /**
     * Create new topic.
     * 
     * @param integer $wrestler_id
     * @param integer $category_id
     * @param array $input
     * @return integer
     */
    public function createTopic($wrestler_id, $category_id, $input)
    {
        (new ForumValidator)->validateCreateTopic($input);
        $this->forumTopicRepo->create(['category_id' => $category_id, 'wrestler_id' => $wrestler_id, 'name' => $input['name']]);
        $topic_id = $this->forumTopicRepo->insertId();
        $this->forumPostRepo->create(['topic_id' => $topic_id, 'wrestler_id' => $wrestler_id, 'post' => clean($input['post'], 'default')]);
        return $topic_id;
    }
    
    /**
     * Create new post.
     * 
     * @param integer $wrestler_id
     * @param integer $topic_id
     * @param array $input
     */
    public function createPost($wrestler_id, $topic_id, $input)
    {
        (new ForumValidator)->validateCreatePost($input);
        $this->forumPostRepo->create(['topic_id' => $topic_id, 'wrestler_id' => $wrestler_id, 'post' => clean($input['post'], 'default')]);
        $this->forumTopicRepo->update($topic_id, ['updated_at' => Carbon::now()->toDateTimeString()]);
        $this->forumViewTopicRepo->deleteAll($topic_id);
    }

    /**
     * Lock or unlock the post.
     *
     * @param integer $topic_id
     * @return string
     */
    public function lockToggle($topic_id)
    {
        $topic = $this->forumTopicRepo->get($topic_id, ['locked']);
        $this->forumTopicRepo->update($topic_id, ['locked' => !$topic['locked']]);
        if (!$topic['locked'] == true) {
            return 'locked';
        }
        return 'unlocked';
    }

    /**
     * Pin or unpin the post.
     *
     * @param integer $topic_id
     * @return string
     */
    public function pinToggle($topic_id)
    {
        $topic = $this->forumTopicRepo->get($topic_id, ['pinned']);
        $this->forumTopicRepo->update($topic_id, ['pinned' => !$topic['pinned']]);
        if (!$topic['pinned'] == true) {
            return 'pinned';
        }
        return 'unpinned';
    }

    /**
     * Update the post.
     *
     * @param integer $post_id
     * @param array $input
     */
    public function updatePost($post_id, $input)
    {
        (new ForumValidator)->validateEditPost($input);
        $input['post'] = clean($input['post'], 'default');
        $this->forumPostRepo->update($post_id, $input);
    }
    
    /**
     * User views topic.
     * 
     * @param integer $category_id
     * @param integer $topic_id
     * @param integer $wrestler_id
     */
    public function viewTopic($category_id, $topic_id, $wrestler_id)
    {
        if (!$this->forumViewTopicRepo->exists($category_id, $topic_id, $wrestler_id)) {
            $this->forumViewTopicRepo->create($category_id, $topic_id, $wrestler_id);
        }
    }

}