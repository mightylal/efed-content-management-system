<?php

namespace Efed\Grading;

use Staff;
use Efed\Models\Settings;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Contracts\Repositories\RoleplayRepository;
use Efed\Contracts\Repositories\RoleplayGradeRepository;

class CanGrade
{

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;
    
    /**
     * @var RoleplayRepository
     */
    private $roleplayRepo;
    
    /**
     * @var RoleplayGradeRepository
     */
    private $roleplayGradeRepo;
    
    /**
     * Start new CanGrade.
     * 
     * @param WrestlerRepository $wrestlerRepo
     * @param RoleplayRepository $roleplayRepo
     * @param RoleplayGradeRepository $roleplayGradeRepo
     */
    public function __construct(WrestlerRepository $wrestlerRepo, RoleplayRepository $roleplayRepo, RoleplayGradeRepository $roleplayGradeRepo)
    {
        $this->wrestlerRepo = $wrestlerRepo;
        $this->roleplayRepo = $roleplayRepo;
        $this->roleplayGradeRepo = $roleplayGradeRepo;
    }
    
    /**
     * Check to see if the wrestler can grade the roleplay.
     * 
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function check($roleplay_id, $wrestler_id)
    {
        $isOwner = $this->roleplayRepo->isOwner($roleplay_id, $wrestler_id);
        $onlyAdminCanGrade = $this->everyoneCanGrade($wrestler_id);
        $isActivated = $this->wrestlerRepo->isActivated($wrestler_id);
        $hasGraded = $this->roleplayGradeRepo->hasGraded($wrestler_id, $roleplay_id);
        return !$isOwner && $onlyAdminCanGrade && $isActivated && !$hasGraded;
    }

    /**
     * Check to see if is admin when only admin can grade is true.
     * 
     * @param integer $wrestler_id
     * @return boolean
     */
    private function everyoneCanGrade($wrestler_id)
    {
        if ($this->onlyAdminCanGrade()) {
            return $this->wrestlerRepo->isAdmin($wrestler_id) || Staff::is($wrestler_id);
        }
        return true;
    }

    /**
     * Check to see if only admin can grade roleplay.
     *
     * @return boolean
     */
    private function onlyAdminCanGrade()
    {
        $settings = (new Settings)->get();
        return $settings['gradeRights'] === 'Staff';
    }

}