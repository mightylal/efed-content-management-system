<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\RoleplayGradeRepository as RoleplayGradeRepositoryInterface;
use Efed\Models\RoleplayGrade;

class RoleplayGradeRepository implements RoleplayGradeRepositoryInterface
{

    /**
     * @var RoleplayGrade
     */
    private $model;

    /**
     * Start new RoleplayGradeRepository.
     *
     * @param RoleplayGrade $model
     * @return void
     */
    public function __construct(RoleplayGrade $model)
    {
        $this->model = $model;
    }

    /**
     * Check to see if the wrestler has graded roleplay.
     *
     * @param integer $wrestler_id
     * @param integer $roleplay_id
     * @return boolean
     */
    public function hasGraded($wrestler_id, $roleplay_id)
    {
        return $this->model->where('wrestler_id', $wrestler_id)->where('rp_id', $roleplay_id)->exists();
    }

    /**
     * Retrieve the grades and comments for the roleplay given the wrestler.
     *
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return array
     */
    public function getByRoleplayAndWrestler($roleplay_id, $wrestler_id)
    {
        $grades = $this->model->where('rp_id', $roleplay_id)->where('wrestler_id', $wrestler_id)->get();
        $grades->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $grades->toArray();
    }

    /**
     * Retrieve all the grades and comments for the roleplay.
     *
     * @param integer $roleplay_id
     * @return array
     */
    public function getByRoleplayForAdmin($roleplay_id)
    {
        $grades = $this->model->where('rp_id', $roleplay_id)->get();
        $grades->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $grades->toArray();
    }

    /**
     * Retrieve all the comments for the roleplay.
     *
     * @param integer $roleplay_id
     * @return array
     */
    public function getByRoleplayForOwner($roleplay_id)
    {
        $grades = $this->model->select('wrestler_id', 'comment')->where('rp_id', $roleplay_id)->get();
        $grades->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $grades->toArray();
    }

    /**
     * Create new grade.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Retrieve the average grade for the roleplay.
     *
     * @param integer $roleplay_id
     * @return number
     */
    public function average($roleplay_id)
    {
        return $this->model->where('rp_id', $roleplay_id)->avg('fed_grade');
    }


}