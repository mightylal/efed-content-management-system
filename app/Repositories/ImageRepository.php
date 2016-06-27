<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\ImageRepository as ImageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ImageRepository implements ImageRepositoryInterface
{
    
    /**
     * @var Model
     */
    private $model;
    
    /**
     * Start new ImageRepository.
     * 
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create new image.
     *
     * @param array $attributes
     */
    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Update or create image.
     *
     * @param integer $image_id
     * @param array $attributes
     */
    public function updateOrCreate($image_id, array $attributes)
    {
        if (!$this->exists($image_id)) {
            $this->create($attributes);
        }
        $this->model->where($this->model->idColumnName, $image_id)->update($attributes);
    }

    /**
     * Check to see if the image already exists.
     *
     * @param integer $image_id
     * @return boolean
     */
    public function exists($image_id)
    {
        return $this->model->where($this->model->idColumnName, $image_id)->exists();
    }


}