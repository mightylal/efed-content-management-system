<?php

namespace Efed\Contracts\Repositories;

interface MessageWrestlerRepository
{

    /**
     * Retrieve all the messages for the wrestler.
     * 
     * @param integer $wrestler_id
     * @param array $columns (optional)
     * @return array
     */
    public function all($wrestler_id, $columns = ['*']);
    
    /**
     * Create new message for wrestler.
     * 
     * @param array $attributes
     */
    public function create(array $attributes);
    
    /**
     * Update the message wrestler.
     * 
     * @param integer $message_id
     * @param integer $wrestler_id
     * @param array $attributes
     */
    public function update($message_id, $wrestler_id, $attributes);
    
    /**
     * Check to see if wrestler is involved in message.
     * 
     * @param integer $wrestler_id
     * @param integer $message_id
     * @return boolean
     */
    public function exists($wrestler_id, $message_id);

}