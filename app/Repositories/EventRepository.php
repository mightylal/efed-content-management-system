<?php

namespace Efed\Repositories;

use Efed\Contracts\Repositories\collection;
use Efed\Contracts\Repositories\EventRepository as EventRepositoryInterface;
use Efed\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    /**
     * @var Event
     */
    private $model;

    /**
     * Insert id.
     */
    private $insertId;

    /**
     * Start new EventRepository.
     *
     * @param Event $model
     * @return void
     */
    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    /**
     * Create an event.
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $event = $this->model->create($attributes);
        $this->insertId = $event->id;
    }

    /**
     * Insert id of the newly created event.
     *
     * @return integer
     */
    public function insertId()
    {
        return $this->insertId;
    }


    /**
     * Retrieve the upcoming events.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function getUpcomingEvents($columns = ['*'])
    {
        return $this->model->select($columns)->where('run', 0)->get()->toArray();
    }

    /**
     * Check to see if the event exists.
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Find the event given the id.
     *
     * @param integer $id
     * @param array $columns (optional)
     * @return array
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns)->toArray();
    }

    /**
     * Check to see if event is before roleplay deadline.
     *
     * @param integer $id
     * @return boolean
     */
    public function isWithinDeadline($id)
    {
        return $this->model->where('id', $id)->whereRaw('deadline_at >= CURDATE()')->exists();
    }

    /**
     * Retrieve all the events order by scheduled at.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function allListing($columns = ['*'])
    {
        return $this->model->select($columns)->orderBy('scheduled_at', 'desc')->get()->toArray();
    }

    /**
     * Retrieve the events that have not ran.
     *
     * @param array $columns (optional)
     * @return array
     */
    public function getNotRunEvents($columns = ['*'])
    {
        return $this->model->select($columns)->where('run', 0)->get()->toArray();
    }

    /**
     * Update an event.
     *
     * @param integer $event_id
     * @param array $attributes
     * @return void
     */
    public function update($event_id, $attributes)
    {
        $this->model->where('id', $event_id)->update($attributes);
    }

    /**
     * Retrieve event with segments.
     *
     * @param integer $event_id
     * @return collection
     */
    public function getWithSegments($event_id)
    {
        $event = $this->model->where('id', $event_id)->first();
        $event->load('segments');
        return $event;
    }

    /**
     * Delete an event.
     *
     * @param integer $event_id
     */
    public function delete($event_id)
    {
        $this->model->where('id', $event_id)->delete();
    }


}