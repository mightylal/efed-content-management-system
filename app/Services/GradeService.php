<?php

namespace Efed\Services;

use Efed\Grading\CanGrade;
use Efed\Validation\GradeValidator;
use Efed\Contracts\Repositories\RoleplayRepository;
use Efed\Contracts\Repositories\RoleplayGradeRepository;

class GradeService
{
    
    /**
     * @var RoleplayGradeRepository
     */
    private $roleplayGradeRepo;

    /**
     * @var RoleplayRepository
     */
    private $roleplayRepo;

    /**
     * @var CanGrade
     */
    private $canGrade;
    
    /**
     * Start new RoleplayGradeRepository.
     * 
     * @param RoleplayGradeRepository $roleplayGradeRepo
     * @param RoleplayRepository $roleplayRepo
     * @param CanGrade $canGrade
     */
    public function __construct(RoleplayGradeRepository $roleplayGradeRepo, RoleplayRepository $roleplayRepo, CanGrade $canGrade)
    {
        $this->roleplayGradeRepo = $roleplayGradeRepo;
        $this->roleplayRepo = $roleplayRepo;
        $this->canGrade = $canGrade;
    }
    
    /**
     * Create a new grade.
     * 
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @param array $input
     */
    public function create($roleplay_id, $wrestler_id, $input)
    {
        (new GradeValidator)->validateGradeRoleplay($input);
        $input['rp_id'] = $roleplay_id;
        $input['wrestler_id'] = $wrestler_id;
        $this->roleplayGradeRepo->create($input);
        $average = $this->roleplayGradeRepo->average($roleplay_id);
        $this->roleplayRepo->update($roleplay_id, ['fed_score' => $average]);
    }

    /**
     * Check to see if the wrestler can grade the roleplay.
     *
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function canGrade($roleplay_id, $wrestler_id)
    {
        return $this->canGrade->check($roleplay_id, $wrestler_id);
    }
    
}