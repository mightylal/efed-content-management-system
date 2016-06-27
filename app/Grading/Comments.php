<?php

namespace Efed\Grading;

use Staff;
use Efed\Contracts\Repositories\RoleplayRepository;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Contracts\Repositories\RoleplayGradeRepository;

class Comments
{
    
    /**
     * @var RoleplayRepository
     */
    private $roleplayRepo;
    
    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;
    
    /**
     * @var RoleplayGradeRepository
     */
    private $roleplayGradeRepo;
    
    /**
     * Start new Comments.
     * 
     * @param RoleplayRepository $roleplayRepo
     * @param WrestlerRepository $wrestlerRepo
     * @param RoleplayGradeRepository $roleplayGradeRepo
     */
    public function __construct(RoleplayRepository $roleplayRepo, WrestlerRepository $wrestlerRepo, RoleplayGradeRepository $roleplayGradeRepo)
    {
        $this->roleplayRepo = $roleplayRepo;
        $this->wrestlerRepo = $wrestlerRepo;
        $this->roleplayGradeRepo = $roleplayGradeRepo;
    }
    
    /**
     * Check to see what comments (if any) can be retrieved.
     * 
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return array
     */
    public function view($roleplay_id, $wrestler_id)
    {
        if ($this->wrestlerRepo->isAdmin($wrestler_id) || Staff::is($wrestler_id)) {
            return $this->roleplayGradeRepo->getByRoleplayForAdmin($roleplay_id);
        } else if ($this->roleplayRepo->isOwner($roleplay_id, $wrestler_id)) {
            return $this->roleplayGradeRepo->getByRoleplayForOwner($roleplay_id);
        } else if ($this->roleplayGradeRepo->hasGraded($wrestler_id, $roleplay_id)) {
            return $this->roleplayGradeRepo->getByRoleplayAndWrestler($roleplay_id, $wrestler_id);
        } else {
            return [];
        }
    }
    
}