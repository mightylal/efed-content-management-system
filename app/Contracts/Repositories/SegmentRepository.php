<?php

namespace Efed\Contracts\Repositories;

interface SegmentRepository
{

    /**
     * Create new segment.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);
    
    /**
     * Retrieve segments given event id.
     * 
     * @param integer $event_id
     * @param array $columns (optional)
     * @return array
     */
    public function getByEvent($event_id, $columns = ['*']);
    
    /**
     * Retrieve the insert id of created segment.
     * 
     * @return mixed
     */
    public function insertId();
    
    /**
     * Retrieve the segment given segment id.
     * 
     * @param integer $segment_id
     * @param array $columns (optional)
     * @return array
     */
    public function get($segment_id, $columns = ['*']);
    
    /**
     * Update the segment.
     * 
     * @param integer $segment_id
     * @param array $attributes
     * @return void
     */
    public function update($segment_id, $attributes);
    
    /**
     * Delete a segment.
     * 
     * @param integer $segment_id
     * @return void
     */
    public function delete($segment_id);
    
    /**
     * Check to see if the segment exists.
     * 
     * @param integer $event_id
     * @param integer $segment_id
     * @return boolean
     */
    public function exists($event_id, $segment_id);
    
    /**
     * Count the number of segments for event.
     * 
     * @param integer $event_id
     * @return integer
     */
    public function count($event_id);

    /**
     * Check to make sure all the segments have been published.
     * 
     * @param integer $event_id
     * @return boolean
     */
    public function published($event_id);

}