<?php

namespace Efed\Validation;

class SegmentValidator extends Validator
{

    /**
     * Validate creating a segment.
     *
     * @param array $data
     */
    public function validateCreateSegment($data)
    {
        self::$rules = [
            'name' => 'required',
            'event_id' => 'required|exists:fedEvent,id,run,0',
            'type' => 'required|in:1v1,1v1v1,1v1v1v1,1v1v1v1v1,1v1v1v1v1v1,2v2,2v2v2,2v2v2v2,3v3,4v4,5v5,2v1,3v2,10,20,30,0',
            'wrestler' => 'required_unless:type,0|array|wrestlers_match',
            'wrestler.*' => 'exists:wrestler,id,activated,1'
        ];
        $this->validate($data);
    }
    
    /**
     * Validate editing a segment.
     * 
     * @param array $data
     */
    public function validateEditSegment($data)
    {
        self::$rules = [
            'name' => 'required',
            'result' => 'required',
            'winner' => 'required|different:loser',
            'loser' => 'required',
        ];
        $this->validate($data);
    }

    /**
     * Validate editing a segment angle.
     * 
     * @param array $data
     */
    public function validateEditAngle($data)
    {
        self::$rules = [
            'name' => 'required',
            'result' => 'required',
        ];
        $this->validate($data);
    }

    /**
     * Validate deleting a segment.
     *
     * @param integer $segment_id
     */
    public function validateDeleteSegment($segment_id)
    {
        self::$rules = ['id' => 'required|exists:eventSegment'];
        $this->validate(['id' => $segment_id]);
    }

}