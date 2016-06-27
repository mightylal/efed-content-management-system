<?php

namespace Efed\Validation;

class ApplicationsValidator extends Validator
{

    /**
     * Validate accepting or declining an applicant.
     *
     * @param array $data
     */
    public function validateApplicant($data)
    {
        self::$rules = [
            'id' => 'required|array',
            'id.*' => 'exists:wrestler,id,activated,0',
            'decide' => 'required|in:accept,decline'
        ];
        $this->validate($data);
    }

}