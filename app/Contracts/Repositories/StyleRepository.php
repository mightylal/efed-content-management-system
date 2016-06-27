<?php

namespace Efed\Contracts\Repositories;

interface StyleRepository
{

    /**
     * Create a style.
     *
     * @param array $attributes
     * @return void
     */
    public function create($attributes);

    /**
     * Retrieve the style sheet.
     *
     * @return object
     */
    public function find();
    
    /**
     * Update a style.
     * 
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes);

}