<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\SegmentRepository as SegmentRepositoryInterface;
use Efed\Models\Segment;

class SegmentRepository implements SegmentRepositoryInterface
{

    /**
     * @var Segment
     */
    private $model;

    /**
     * Insert id.
     */
    private $insertId = null;

    /**
     * Start new SegmentRepository.
     *
     * @param Segment $model
     * @return void
     */
    public function __construct(Segment $model)
    {
        $this->model = $model;
    }

    /**
     * Create new segment.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $segment = $this->model->create($attributes);
        $this->insertId = $segment->id;
    }

    /**
     * Retrieve segments given event id.
     *
     * @param integer $event_id
     * @param array $columns (optional)
     * @return array
     */
    public function getByEvent($event_id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('event_id', $event_id)->get()->toArray();
    }

    /**
     * Retrieve the insert id of created segment.
     *
     * @return mixed
     */
    public function insertId()
    {
        return $this->insertId;
    }

    /**
     * Retrieve the segment given segment id.
     *
     * @param integer $segment_id
     * @param array $columns (optional)
     * @return array
     */
    public function get($segment_id, $columns = ['*'])
    {
        return $this->model->select($columns)->where('id', $segment_id)->first()->toArray();
    }

    /**
     * Update the segment.
     *
     * @param integer $segment_id
     * @param array $attributes
     * @return void
     */
    public function update($segment_id, $attributes)
    {
        $this->model->where('id', $segment_id)->update($attributes);
    }

    /**
     * Delete a segment.
     *
     * @param integer $segment_id
     * @return void
     */
    public function delete($segment_id)
    {
        $this->model->where('id', $segment_id)->delete();
    }

    /**
     * Check to see if the segment exists.
     *
     * @param integer $event_id
     * @param integer $segment_id
     * @return boolean
     */
    public function exists($event_id, $segment_id)
    {
        return $this->model->where('id', $segment_id)->where('event_id', $event_id)->exists();
    }

    /**
     * Count the number of segments for event.
     *
     * @param integer $event_id
     * @return integer
     */
    public function count($event_id)
    {
        return $this->model->where('event_id', $event_id)->count();
    }

    /**
     * Check to make sure all the segments have been published.
     *
     * @param integer $event_id
     * @return boolean
     */
    public function published($event_id)
    {
        $published = $this->model->where('event_id', $event_id)->where('publish', 1)->count();
        return $published === $this->count($event_id);
    }


}