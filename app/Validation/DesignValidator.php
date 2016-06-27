<?php

namespace Efed\Validation;

class DesignValidator extends Validator
{
    
    /**
     * Validate editing a style.
     * 
     * @param array $data
     */
    public function validateEditStyle($data)
    {
        self::$rules = [
            'primary1' => 'required|alpha_num|size:6',
            'primary2' => 'required|alpha_num|size:6',
            'secondary1' => 'required|alpha_num|size:6',
            'secondary2' => 'required|alpha_num|size:6',
            'secondary3' => 'required|alpha_num|size:6',
            'secondary4' => 'required|alpha_num|size:6',
        ];
        $this->validate($data);
    }
    
}