<?php

namespace Efed\Validation;

class WrestlerAuthenticationValidator extends Validator
{

    /**
     * Validate the login form.
     *
     * @param array $data
     */
    public function validateLoginForm($data)
    {
        self::$rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $this->validate($data);
    }

    /**
     * Validate the sign up form.
     *
     * @param array $data
     */
    public function validateSignUpForm($data)
    {
        self::$rules = [
            'username' => 'required|alpha_num|unique:wrestler',
            'password' => 'required|confirmed',
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required|in:Male,Female,Unknown',
            'height' => 'required',
            'weight' => 'required|integer',
            'human' => 'required|in:Brock Lesnar',
        ];
        $this->validate($data);
    }
}