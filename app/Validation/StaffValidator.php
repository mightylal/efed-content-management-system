<?php

namespace Efed\Validation;

class StaffValidator extends Validator
{

    /**
     * Validate adding staff.
     *
     * @param array $data
     */
    public function validateAdd($data)
    {
        self::$rules = [
            'name' => 'required|exists:wrestler,name,admin,0,activated,1'
        ];
        $this->validate($data);
    }

    /**
     * Delete staff member.
     *
     * @param array $data
     */
    public function validateDelete($data)
    {
        self::$rules = [
            'id' => 'required|array',
            'id.*' => 'exists:fedStaff,id'
        ];
        $this->validate($data);
    }

}