<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\SegmentWrestlerRepository as SegmentWrestlerRepositoryInterface;
use Efed\Models\SegmentWrestler;

class SegmentWrestlerRepository implements SegmentWrestlerRepositoryInterface
{

    /**
     * @var SegmentWrestler
     */
    private $model;

    /**
     * Start new SegmentWrestlerRepository.
     *
     * @param SegmentWrestler $model
     * @return void
     */
    public function __construct(SegmentWrestler $model)
    {
        $this->model = $model;
    }

    /**
     * Create new segment wrestler.
     *
     * @param array $attributes
     * @return void
     */
    public function create($attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Retrieve the wrestlers in the segment.
     *
     * @param integer $segment_id
     * @param array $columns (optional)
     * @return array
     */
    public function get($segment_id, $columns = ['*'])
    {
        $wrestlers = $this->model->select($columns)->where('segment_id', $segment_id)->get();
        $wrestlers->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $wrestlers->toArray();
    }

    /**
     * Update the winner.
     *
     * @param integer $segment_id
     * @param integer $wrestler_id
     * @return void
     */
    public function updateWinner($segment_id, $wrestler_id)
    {
        $this->model->where('segment_id', $segment_id)->where('wrestler_id', $wrestler_id)->update(['winner' => 1]);
    }

    /**
     * Update the loser.
     *
     * @param integer $segment_id
     * @param integer $wrestler_id
     * @return void
     */
    public function updateLoser($segment_id, $wrestler_id)
    {
        $this->model->where('segment_id', $segment_id)->where('wrestler_id', $wrestler_id)->update(['loser' => 1]);
    }

    /**
     * Clear the winner and loser.
     *
     * @param integer $segment_id
     * @return void
     */
    public function clearWinnerLoser($segment_id)
    {
        $this->model->where('segment_id', $segment_id)->update(['winner' => 0, 'loser' => 0]);
    }

    /**
     * Check to see if wrestler exists in segment.
     *
     * @param integer $segment_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function exists($segment_id, $wrestler_id)
    {
        return $this->model->where('segment_id', $segment_id)->where('wrestler_id', $wrestler_id)->exists();
    }

    /**
     * Check to see if wrestlers are not on same team.
     *
     * @param integer $segment_id
     * @param array $wrestlers
     * @return boolean
     */
    public function differentTeams($segment_id, $wrestlers)
    {
        $teams = $this->model->select('team_id')->where('segment_id', $segment_id)->whereIn('wrestler_id', $wrestlers)->groupBy('team_id')->get();
        return count($teams) === count($wrestlers);
    }

    /**
     * Delete the segment wrestlers.
     *
     * @param integer $segment_id
     * @return void
     */
    public function delete($segment_id)
    {
        $this->model->where('segment_id', $segment_id)->delete();
    }

    /**
     * Retrieve the wrestlers by team.
     *
     * @param integer $id
     * @param integer $team_id
     * @param array $columns (optional)
     * @return array
     */
    public function getByTeam($id, $team_id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('id', $id)->where('team_id', $team_id)->get()->toArray();
    }


}