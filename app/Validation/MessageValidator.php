<?php

namespace Efed\Validation;

class MessageValidator extends Validator
{

    /**
     * Validate creating a message.
     *
     * @param array $data
     */
    public function validateCreateMessage($data)
    {
        self::$rules = [
            'name' => 'required|exists:wrestler,name',
            'subject' => 'required',
            'message' => 'required',
        ];
        $this->validate($data);
    }
    
    /**
     * Validate creating a reply.
     * 
     * @param array $data
     */
    public function validateReply($data)
    {
        self::$rules = [
            'message' => 'required'    
        ];
        $this->validate($data);
    }
    
    /**
     * Validate deleting a message.
     * 
     * @param array $data
     * @param integer $wrestler_id
     */
    public function validateDeleteMessage($data, $wrestler_id)
    {
        self::$rules = [
            'id' => 'required|array',
            'id.*' => 'exists:messageWrestler,message_id,wrestler_id,' . $wrestler_id . ',deleted_at,NULL'
        ];
        $this->validate($data);
    }

}