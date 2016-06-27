<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;
use Efed\Http\Requests;
use Efed\Exceptions\ValidationException;
use Efed\Services\WrestlerAuthenticationService;

class WrestlerAuthenticationController extends Controller
{
    /**
     * @var WrestlerAuthenticationService
     */
    private $wrestlerAuthenticationService;

    /**
     * Start new WrestlerAuthenticationController.
     *
     * @param WrestlerAuthenticationService $wrestlerAuthenticationService
     * @return void
     */
    public function __construct(WrestlerAuthenticationService $wrestlerAuthenticationService)
    {
        $this->wrestlerAuthenticationService = $wrestlerAuthenticationService;
    }

    /**
     * Show the login screen.
     *
     * @return view
     */
    public function getLogin()
    {
        return view('signin');
    }

    /**
     * Display the register view.
     *
     * @return view
     */
    public function getRegister()
    {
        return view('register');
    }

    /**
     * User attempts to register.
     *
     * @param Request $request
     * @return response
     */
    public function register(Request $request)
    {
        try {
            $this->wrestlerAuthenticationService->register(array_map('trim', $request->except('_token')));
            return redirect()->route('home')->with('message', 'Account created successfully. You will get a message once your account has been approved by an admin.');
        } catch (ValidationException $error) {
            return redirect()->route('register')->withErrors($error->getErrors());
        }
    }

    /**
     * User attempts to login.
     *
     * @param Request $request
     * @return response
     */
    public function login(Request $request)
    {
        try {
            $this->wrestlerAuthenticationService->login(array_map('trim', $request->all()));
            return redirect()->route('home');
        } catch (ValidationException $error) {
            return redirect()->route('signin')->withErrors($error->getErrors());
        }
    }

    /**
     * User signs out.
     *
     * @return reponse
     */
    public function logout()
    {
        $this->wrestlerAuthenticationService->logout();
        return redirect()->route('signin');
    }
}
