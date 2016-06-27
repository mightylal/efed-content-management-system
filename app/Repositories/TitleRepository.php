<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\TitleRepository as TitleRepositoryInterface;
use Efed\Models\Title;

class TitleRepository implements TitleRepositoryInterface
{
    
    /**
     * @var Title
     */
    private $model;

    /**
     * Insert id.
     */
    private $insertId;
    
    /**
     * Start new TitleRepository.
     * 
     * @param Title $model
     * @return void
     */
    public function __construct(Title $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new title.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $title = $this->model->create($attributes);
        $this->insertId = $title->id;
    }

    /**
     * Retrieve all the titles.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*'])
    {
        return $this->model->select($columns)->orderBy('placement')->get()->toArray();
    }

    /**
     * Check to see if title exists.
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Find the title.
     *
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns)->toArray();
    }

    /**
     * Update the title.
     *
     * @param integer $id
     * @param array $attributes
     * @return void
     */
    public function update($id, array $attributes)
    {
        $this->model->where('id', $id)->update($attributes);
    }

    /**
     * Retrieve titles by type.
     *
     * @param string $type
     * @param array $columns (optional)
     * @return array
     */
    public function getByType($type, $columns = ['*'])
    {
        return $this->model->select($columns)->where('type', $type)->get()->toArray();
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
     * Count the number of titles.
     *
     * @return integer
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Delete a title.
     *
     * @param integer $title_id
     */
    public function delete($title_id)
    {
        $this->model->destroy($title_id);
    }


}