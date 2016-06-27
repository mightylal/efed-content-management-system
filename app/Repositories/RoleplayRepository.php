<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\RoleplayRepository as RoleplayRepositoryInterface;
use Efed\Models\Roleplay;

class RoleplayRepository implements RoleplayRepositoryInterface
{
    
    /**
     * @var Roleplay
     */
    private $model;
    
    /**
     * Start new RoleplayRepository.
     * 
     * @param Roleplay $model
     * @return void
     */
    public function __construct(Roleplay $model)
    {
        $this->model = $model;
    }

    /**
     * Create new roleplay.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Retrieve all the roleplays.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*'])
    {
        $roleplays = $this->model->all($columns);
        $roleplays->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }, 'event' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $roleplays->toArray();
    }

    /**
     * Check to see if the roleplay exists given the id.
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Retrieve the roleplay given the id.
     *
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*'])
    {
        $roleplays = $this->model->select($columns)->where('id', $id)->first();
        $roleplays->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }, 'event' => function ($query) {
            $query->select('id', 'name');
        }]);
        $roleplays->wrestler->load(['image' => function ($query) {
            $query->select('wrestler_id', 'url');    
        }]);
        return $roleplays->toArray();
    }

    /**
     * Check to see if the wrestler is owner of roleplay.
     *
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function isOwner($roleplay_id, $wrestler_id)
    {
        return $this->model->where('id', $roleplay_id)->where('wrestler_id', $wrestler_id)->exists();
    }

    /**
     * Retrieve the roleplays for the list and order by descending created date.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function allOrderByCreatedDateDesc($columns = ['*'])
    {
        $roleplays = $this->model->select($columns)->orderBy('created_at', 'desc')->paginate(15);
        $roleplays->load(['wrestler' => function ($query) {
            $query->select('id', 'name');
        }, 'event' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $roleplays;
    }

    /**
     * Retrieve the roleplay with the event.
     *
     * @param integer $roleplay_id
     * @param array $columns (optional)
     * @return array
     */
    public function getWithEvent($roleplay_id, $columns = ['*'])
    {
        $roleplay = $this->model->select($columns)->where('id', $roleplay_id)->first();
        $roleplay->load(['event' => function ($query) {
            $query->select('id', 'name', 'deadline_at');
        }]);
        return $roleplay->toArray();
    }


    /**
     * Check to see if wrestler can edit roleplay.
     *
     * @param integer $roleplay_id
     * @param integer $wrestler_id
     * @return boolean
     */
    public function canEdit($roleplay_id, $wrestler_id)
    {
        $roleplay = $this->getWithEvent($roleplay_id);
        $deadline_at = $roleplay['event']['deadline_at'];
        return $this->model->where('id', $roleplay_id)->where('wrestler_id', $wrestler_id)->whereRaw("TIMESTAMPDIFF(MINUTE, created_at, NOW()) < 60 AND NOW() < ?", [$deadline_at])->exists();
    }

    /**
     * Update a roleplay.
     *
     * @param integer $id
     * @param array $attributes
     * @return void
     */
    public function update($id, $attributes)
    {
        $this->model->where('id', $id)->update($attributes);
    }

    /**
     * Count the number of roleplays for the event.
     *
     * @param integer $wrestler_id
     * @param integer $event_id
     * @return integer
     */
    public function countForEvent($wrestler_id, $event_id)
    {
        return $this->model->where('wrestler_id', $wrestler_id)->where('event_id', $event_id)->count();
    }


}