<?php

namespace Efed\Validation;

use Efed\Placement\PlacementValidator;
use Efed\Placement\PlacementForm;

class EventValidator extends Validator implements PlacementValidator
{
    
    /**
     * Validate creating an event.
     * 
     * @param array $data
     * @return void
     */
    public function validateEvent($data)
    {
        self::$rules = [
            'name' => 'required',
            'scheduled_at' => 'required|date_format:Y-m-d|after:deadline_at',
            'deadline_at' => 'required|date_format:Y-m-d|after:+1day'
        ];
        $this->validate($data);
    }

    /**
     * Validate editing an event.
     *
     * @param array $data
     * @param string $after
     * @return void
     */
    public function validateEditEvent($data, $after)
    {
        $date = (new \DateTime($after))->modify('-1 day')->format('Y-m-d');
        self::$rules = [
            'name' => 'required|max:100',
            'scheduled_at' => 'required|date_format:Y-m-d|after:' . $date,
            'preview' => 'required',
        ];
        $this->validate($data);
    }

    /**
     * Validate updating placement.
     *
     * @param array $data
     * @param integer $entity_id (optional)
     */
    public function validatePlacement($data, $entity_id = null)
    {
        self::$rules = PlacementForm::$rules;
        self::$rules[] = ['id.*' => 'exists:eventSegment,id,event_id,' . $entity_id];
        $this->validate($data);
    }

    /**
     * Validate running event.
     * 
     * @param array $data
     */
    public function validateRun($data)
    {
        self::$rules = [
            'event' => 'required|exists:fedEvent,id,run,0'
        ];
        $this->validate($data);
    }
    
    /**
     * Validate deleting an event.
     * 
     * @param array $data
     */
    public function validateDelete($data)
    {
        self::$rules = [
            'id' => 'required|array',
            'id.*' => 'exists:fedEvent,id,run,0',
        ];
        $this->validate($data);
    }

}