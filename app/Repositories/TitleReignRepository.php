<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\TitleReignRepository as TitleReignRepositoryInterface;
use Efed\Models\TitleReign;

class TitleReignRepository implements TitleReignRepositoryInterface
{

    /**
     * @var TitleReign
     */
    private $model;

    /**
     * Insert id.
     */
    private $insertId;
    
    /**
     * Start new TitleReignRepository.
     * 
     * @param TitleReign $model
     */
    public function __construct(TitleReign $model)
    {
        $this->model = $model;
    }

    /**
     * Create new title reign.
     *
     * @param array $attributes
     */
    public function create(array $attributes)
    {
        $reign = $this->model->create($attributes);
        $this->insertId = $reign->id;
    }

    /**
     * Insert id.
     *
     * @return integer
     */
    public function insertId()
    {
        return $this->insertId;
    }

    /**
     * Get the active reign for the title.
     *
     * @param integer $title_id
     * @param array $columns (optional)
     * @return array
     */
    public function getActive($title_id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('title_id', $title_id)->whereNull('date_lost')->first()->toArray();
    }

    /**
     * Update a title reign.
     * 
     * @param integer $reign_id
     * @param array $attributes
     */
    public function update($reign_id, $attributes)
    {
        $this->model->where('id', $reign_id)->update($attributes);
    }

    /**
     * Delete reigns by title.
     *
     * @param integer $title_id
     */
    public function deleteByTitle($title_id)
    {
        $this->model->where('title_id', $title_id)->delete();
    }

    /**
     * Check to see if the wrestler is the current holders.
     *
     * @param integer $title_id
     * @param integer $wrestler
     * @return mixed
     */
    public function isHolder($title_id, $wrestler)
    {
        $holder = $this->model->select('id', 'defenses')->where('title_id', $title_id)->whereNull('date_lost')->whereRaw("(wrestler_id_one IN (?) OR wrestler_id_two IN (?))", [$wrestler, $wrestler])->first();
        if ($holder) {
            return $holder->toArray();
        }
        return false;
    }


}