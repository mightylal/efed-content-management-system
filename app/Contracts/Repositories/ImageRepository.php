<?php

namespace Efed\Contracts\Repositories;

interface ImageRepository
{
    
    /**
     * Create new image.
     * 
     * @param array $attributes
     */
    public function create(array $attributes);
    
    /**
     * Update or create image.
     * 
     * @param integer $image_id
     * @param array $attributes
     */
    public function updateOrCreate($image_id, array $attributes);
    
    /**
     * Check to see if the image already exists.
     * 
     * @param integer $image_id
     * @return boolean
     */
    public function exists($image_id);
    
}