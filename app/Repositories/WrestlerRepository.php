<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\WrestlerRepository as WrestlerRepositoryInterface;
use Efed\Models\Wrestler;

class WrestlerRepository implements WrestlerRepositoryInterface
{

    /**
     * @var Wrestler
     */
    private $model;

    /**
     * Start new WrestlerRepository.
     *
     * @param Wrestler $model
     * @return void
     */
    public function __construct(Wrestler $model)
    {
        $this->model = $model;
    }

    /**
     * Create a wrestler.
     *
     * @param array $attributes
     * @return void
     */
    public function create($attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Update a wrestler.
     *
     * @param integer $wrestler_id
     * @param array $attributes
     * @return void
     */
    public function update($wrestler_id, $attributes)
    {
        $this->model->where('id', $wrestler_id)->update($attributes);
    }

    /**
     * Find all the wrestlers given wrestler.
     *
     * @param integer $wrestler_id
     * @param array $columns (optional)
     * @return array
     */
    public function find($wrestler_id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('id', $wrestler_id)->get()->toArray();
    }

    /**
     * Retrieve all the available wrestlers.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function getAvailableWrestlers($columns = ['*'])
    {
        $wrestlers = $this->model->select($columns)->where('activated', 1)->whereNull('deleted_at')->get();
        $wrestlers->load('image');
        return $wrestlers->toArray();
    }

    /**
     * Retrieve all the non-available wrestlers.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function getNonAvailableWrestlers($columns = ['*'])
    {
        return $this->model->select($columns)->where('activated', 0)->get()->toArray();
    }

    /**
     * Check to see if the wrestler is activated.
     *
     * @param integer $wrestler_id
     * @return boolean
     */
    public function isActivated($wrestler_id)
    {
        return $this->model->where('id', $wrestler_id)->where('activated', 1)->exists();
    }

    /**
     * Check to see if the wrestler is an admin.
     *
     * @param integer $wrestler_id
     * @return boolean
     */
    public function isAdmin($wrestler_id)
    {
        return $this->model->where('id', $wrestler_id)->where('admin', 1)->exists();
    }

    /**
     * Retrieve wrestler by slug.
     *
     * @param string $slug
     * @param array $columns (optional)
     * @return array
     */
    public function getBySlug($slug, $columns = ['*'])
    {
        $wrestler = $this->model->select($columns)->where('slug', $slug)->first();
        $wrestler->load('image');
        return $wrestler->toArray();
    }

    /**
     * Check to see if wrestler exists by slug.
     *
     * @param string $slug
     * @return boolean
     */
    public function existsBySlug($slug)
    {
        return $this->model->where('slug', $slug)->where('activated', 1)->exists();
    }

    /**
     * Delete the wrestler.
     *
     * @param integer $wrestler_id
     */
    public function delete($wrestler_id)
    {
        $this->model->where('id', $wrestler_id)->forceDelete();
    }

    /**
     * Remove a wrestler. Soft delete.
     *
     * @param integer $wrestler_id
     */
    public function remove($wrestler_id)
    {
        $this->model->where('id', $wrestler_id)->delete();
    }

    /**
     * Retrieve wrestler by name.
     *
     * @param string $name
     * @param array $columns (optional)
     * @return array
     */
    public function getByName($name, $columns = ['*'])
    {
        return $this->model->select($columns)->where('name', $name)->first()->toArray();
    }

    /**
     * Non activated wrestler count.
     *
     * @return integer
     */
    public function notActivatedCount()
    {
        return $this->model->where('activated', 0)->count();
    }

    /**
     * Check to see if wrestler exists.
     *
     * @param integer $wrestler_id
     * @return boolean
     */
    public function exists($wrestler_id)
    {
        return $this->model->where('id', $wrestler_id)->where('activated', 1)->whereNull('deleted_at')->exists();
    }


}