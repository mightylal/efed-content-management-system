<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\PageRepository as PageRepositoryInterface;
use Efed\Models\Page;

class PageRepository implements PageRepositoryInterface
{

    /**
     * @var Page
     */
    private $model;

    /**
     * Start new PageRepository.
     *
     * @param Page $model
     * @return void
     */
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    /**
     * Create a page.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Retrieve all the pages.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function all($columns = ['*'])
    {
        return $this->model->select($columns)->orderBy('placement')->get()->toArray();
    }

    /**
     * Retrieve a page.
     *
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function get($id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('id', $id)->first()->toArray();
    }

    /**
     * Update a page.
     *
     * @param integer $id
     * @param array $attributes
     */
    public function update($id, $attributes)
    {
        $this->model->where('id', $id)->update($attributes);
    }

    /**
     * Delete a page.
     *
     * @param integer $id
     */
    public function delete($id)
    {
        $this->model->where('id', $id)->delete();
    }

    /**
     * Check to see if the page exists.
     *
     * @param integer $page_id
     * @return boolean
     */
    public function exists($page_id)
    {
        return $this->model->where('id', $page_id)->exists();
    }

    /**
     * Count the number of pages.
     *
     * @return integer
     */
    public function count()
    {
        return $this->model->count();
    }


}