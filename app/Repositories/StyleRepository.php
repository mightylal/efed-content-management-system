<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\StyleRepository as StyleRepositoryInterface;
use Efed\Models\Style;

class StyleRepository implements StyleRepositoryInterface
{

    /**
     * @var Style
     */
    private $model;

    /**
     * Start new StyleRepository.
     *
     * @param Style $model
     * @return void
     */
    public function __construct(Style $model)
    {
        $this->model = $model;
    }

    /**
     * Create a style.
     *
     * @param array $attributes
     * @return void
     */
    public function create($attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Retrieve the style sheet.
     *
     * @return object
     */
    public function find()
    {
        return $this->model->find(1)->toArray();
    }

    /**
     * Update a style.
     *
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes)
    {
        $this->model->where('id', 1)->update($attributes);
    }


}