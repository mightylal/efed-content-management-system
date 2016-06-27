<?php

namespace Efed\Validation;

class GradeValidator extends Validator
{
    
    /**
     * Validate grading a roleplay.
     * 
     * @param array $data
     * @return void
     */
    public function validateGradeRoleplay($data)
    {
        self::$rules = [
            'fed_grade' => 'required|integer|between:1,10'
        ];
        $this->validate($data);
    }
    
}