<?php

namespace Efed\Services;

use Efed\Contracts\Repositories\RoleplayRepository;
use Efed\Validation\RoleplayValidator;
use Efed\Grading\CanGrade;
use Efed\Grading\Comments;

class RoleplayService
{

    /**
     * @var RoleplayRepository
     */
    private $roleplayRepo;

    /**
     * @var CanGrade
     */
    private $canGrade;

    /**
     * @var Comments
     */
    private $comments;

    /**
     * Start new RoleplayService.
     *
     * @param RoleplayRepository $roleplayRepo
     * @param CanGrade $canGrade
     * @param Comments $comments
     */
    public function __construct(RoleplayRepository $roleplayRepo, CanGrade $canGrade, Comments $comments)
    {
        $this->roleplayRepo = $roleplayRepo;
        $this->canGrade = $canGrade;
        $this->comments = $comments;
    }
    
    /**
     * Create a roleplay.
     *
     * @param integer $wrestler_id
     * @param array $input
     */
    public function create($wrestler_id, $input)
    {
        (new RoleplayValidator)->validateCreateRoleplay($input, $wrestler_id);
        $input['wrestler_id'] = $wrestler_id;
        $input['rp'] = clean($input['rp'], 'roleplay');
        $this->roleplayRepo->create($input);
    }
    
    /**
     * Get the grades and comments for the roleplay.
     * 
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return array
     */
    public function comments($roleplay_id, $wrestler_id)
    {
        return $this->comments->view($roleplay_id, $wrestler_id);        
    }

    /**
     * Check to see if the user can edit the roleplay.
     *
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function canEdit($roleplay_id, $wrestler_id)
    {
        return $this->roleplayRepo->canEdit($roleplay_id, $wrestler_id);
    }
    
    /**
     * Update the roleplay.
     * 
     * @param integer $id
     * @param array $input
     */
    public function update($id, $input)
    {
        (new RoleplayValidator)->validateEditRoleplay($input);
        $input['rp'] = clean($input['rp'], 'roleplay');
        $this->roleplayRepo->update($id, $input);
    }

}