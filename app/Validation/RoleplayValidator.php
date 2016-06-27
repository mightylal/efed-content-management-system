<?php

namespace Efed\Validation;

class RoleplayValidator extends Validator
{
    
    /**
     * Validate creating a roleplay.
     * 
     * @param array $data
     * @param integer $wrestler_id
     */
    public function validateCreateRoleplay($data, $wrestler_id)
    {
        self::$rules = [
            'event_id' => 'required|exists:fedEvent,id|event_within_deadline|event_max:' . $wrestler_id,
            'name' => 'required|max:100',
            'rp' => 'required',
        ];
        $this->validate($data);
    }
    
    /**
     * Validate editing a roleplay.
     * 
     * @param array $data
     */
    public function validateEditRoleplay($data)
    {
        self::$rules = [
            'name' => 'required|max:100',
            'rp' => 'required',
        ];
        $this->validate($data);
    }
    
}