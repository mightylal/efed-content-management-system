<?php

namespace Efed\Contracts\Repositories;

interface EventRepository
{

    /**
     * Create an event.
     * 
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);

    /**
     * Insert id of the newly created event.
     * 
     * @return integer
     */
    public function insertId();

    /**
     * Retrieve the upcoming events.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function getUpcomingEvents($columns = ['*']);
    
    /**
     * Check to see if the event exists.
     * 
     * @param integer $id
     * @return boolean
     */
    public function exists($id);
    
    /**
     * Find the event given the id.
     * 
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function find($id, $columns = ['*']);
    
    /**
     * Check to see if event is before roleplay deadline.
     * 
     * @param integer $id
     * @return boolean
     */
    public function isWithinDeadline($id);
    
    /**
     * Retrieve all the events order by scheduled at.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function allListing($columns = ['*']);
    
    /**
     * Retrieve the events that have not ran.
     * 
     * @param array $columns (optional)
     * @return array
     */
    public function getNotRunEvents($columns = ['*']);
    
    /**
     * Update an event.
     * 
     * @param integer $event_id
     * @param array $attributes
     * @return void
     */
    public function update($event_id, $attributes);

    /**
     * Retrieve event with segments.
     *
     * @param integer $event_id
     * @return collection
     */
    public function getWithSegments($event_id);
    
    /**
     * Delete an event.
     * 
     * @param integer $event_id
     */
    public function delete($event_id);

}