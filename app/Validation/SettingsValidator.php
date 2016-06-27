<?php

namespace Efed\Validation;

class SettingsValidator extends Validator
{

    /**
     * Validate the settings.
     * 
     * @param array $data
     * @return void
     */
    public function validateEditSettings($data)
    {
        self::$rules = [
            'roleplayLimit' => 'required|integer|min:1|max:10',
            'gradeRights' => 'required|in:Everyone,Staff'
        ];
        $this->validate($data);
    }

}