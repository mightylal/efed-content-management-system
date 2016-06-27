<?php

namespace Efed\Validation;

class RosterValidator extends Validator
{

    /**
     * Validate removing wrestlers from fed.
     *
     * @param array $data
     */
    public function validateRemovingWrestlers($data)
    {
        self::$rules = [
            'id' => 'required|array',
            'id.*' => 'exists:wrestler,id,admin,0,deleted_at,NULL',
        ];
        $this->validate($data);
    }

}