<?php

namespace Efed\Services\Admin;

use Efed\Contracts\Repositories\ForumRepository;
use Efed\Validation\ForumValidator;
use Efed\Placement\Placement;

class ForumService
{

    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * Start new ForumService.
     *
     * @param ForumRepository $forumRepo
     */
    public function __construct(ForumRepository $forumRepo)
    {
        $this->forumRepo = $forumRepo;
    }

    /**
     * Create a new forum.
     *
     * @param array $input
     */
    public function create($input)
    {
        (new ForumValidator)->validateCreateForum($input);
        $input['placement'] = $this->forumRepo->count() + 1;
        $this->forumRepo->create($input);
    }

    /**
     * Update the forum.
     * 
     * @param integer $forum_id
     * @param array $input
     */
    public function update($forum_id, $input)
    {
        (new ForumValidator)->validateUpdateForum($input);
        $this->forumRepo->update($forum_id, $input);
    }

    /**
     * Delete the forum.
     * 
     * @param array $input
     */
    public function delete($input)
    {
        (new ForumValidator)->validateDeleteForum($input);
        $this->forumRepo->delete($input['id']);;
    }
    
    /**
     * Update forum placement.
     * 
     * @param array $input
     */
    public function placement($input)
    {
        (new Placement)->handle(new ForumValidator, $this->forumRepo, $input);
    }

}