<?php

namespace Efed\Services;

use Illuminate\Contracts\Auth\Guard;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Exceptions\ValidationException;
use Efed\Validation\WrestlerAuthenticationValidator;

class WrestlerAuthenticationService
{

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new WrestlerAuthenticationService.
     *
     * @param Guard $auth
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(Guard $auth, WrestlerRepository $wrestlerRepo)
    {
        $this->auth = $auth;
        $this->wrestlerRepo = $wrestlerRepo;
    }

    /**
     * User tries to register a new account.
     *
     * @param array $input
     * @throws ValidationException if registration fails
     */
    public function register($input)
    {
        (new WrestlerAuthenticationValidator)->validateSignUpForm($input);
        $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        $input['slug'] = strtolower(str_replace(' ', '-', $input['name']));
        $this->wrestlerRepo->create($input);
    }

    /**
     * Try to log in the user given the input.
     *
     * @param array $input
     * @throws ValidationException if login attempt fails
     */
    public function login($input)
    {
        (new WrestlerAuthenticationValidator)->validateLoginForm($input);
        if ($this->auth->attempt(['username' => $input['username'], 'password' => $input['password']])) {
            $this->checkIfPasswordNeedsRehash($input['password']);
            return;
        }
        throw new ValidationException('Login attempt failed.');
    }

    /**
     * Check to see if the user password needs to be rehashed.
     *
     * @param string $password
     * @return void
     */
    private function checkIfPasswordNeedsRehash($password)
    {
        if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->wrestlerRepo->update($this->auth->id(), ['password' => $hash]);
        }
    }

    /**
     * User logs out.
     *
     * @return void
     */
    public function logout()
    {
        $this->auth->logout();
    }

}