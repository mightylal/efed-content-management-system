<?php

namespace Efed\Contracts\Repositories;

interface WrestlerRepository
{

    /**
     * Create a wrestler.
     *
     * @param array $attributes
     * @return void
     */
    public function create($attributes);

    /**
     * Update a wrestler.
     *
     * @param integer $wrestler_id
     * @param array $attributes
     * @return void
     */
    public function update($wrestler_id, $attributes);

    /**
     * Find all the wrestlers given wrestler.
     *
     * @param integer $wrestler_id
     * @param array $columns (optional)
     * @return array
     */
    public function find($wrestler_id, $columns = ['*']);
    
    /**
     * Retrieve all the available wrestlers.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function getAvailableWrestlers($columns = ['*']);
    
    /**
     * Retrieve all the non-available wrestlers.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function getNonAvailableWrestlers($columns = ['*']);
    
    /**
     * Check to see if the wrestler is activated.
     * 
     * @param integer $wrestler_id
     * @return boolean
     */
    public function isActivated($wrestler_id);
    
    /**
     * Check to see if the wrestler is an admin.
     * 
     * @param integer $wrestler_id
     * @return boolean
     */
    public function isAdmin($wrestler_id);
    
    /**
     * Retrieve wrestler by slug.
     * 
     * @param string $slug
     * @param array $columns (optional)
     * @return array
     */
    public function getBySlug($slug, $columns = ['*']);
    
    /**
     * Check to see if wrestler exists by slug.
     * 
     * @param string $slug
     * @return boolean
     */
    public function existsBySlug($slug);
    
    /**
     * Delete the wrestler.
     * 
     * @param integer $wrestler_id
     */
    public function delete($wrestler_id);
    
    /**
     * Remove a wrestler. Soft delete.
     * 
     * @param integer $wrestler_id
     */
    public function remove($wrestler_id);
    
    /**
     * Retrieve wrestler by name.
     * 
     * @param string $name
     * @param array $columns (optional)
     * @return array
     */
    public function getByName($name, $columns = ['*']);
    
    /**
     * Non activated wrestler count.
     * 
     * @return integer
     */
    public function notActivatedCount();
    
    /**
     * Check to see if wrestler exists.
     * 
     * @param integer $wrestler_id
     * @return boolean
     */
    public function exists($wrestler_id);

}