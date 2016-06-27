<?php

namespace Efed\Validation;

class WrestlerValidator extends Validator
{

    /**
     * Validate updating a wrestler.
     *
     * @param array $data
     * @return void
     */
    public function validateUpdateWrestler($data)
    {
        self::$rules = [
            'name' => 'required|max:100',
            'age' => 'required|integer|min:16|max:99',
            'gender' => 'required|in:Male,Female,Unknown',
            'height' => 'required',
            'weight' => 'required|integer|min:90|max:900',
            'image' => 'mimes:jpeg,png,gif|max:100'
        ];
        $this->validate($data);
    }

}