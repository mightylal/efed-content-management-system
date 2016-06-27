<?php

namespace Efed\Http\Controllers\Admin\Roster;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\ApplicationService;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Exceptions\ValidationException;

class ApplicationController extends Controller
{
    /**
     * @var ApplicationService
     */
    private $applicationService;
    
    /**
     * @var $wrestlerRepo
     */
    private $wrestlerRepo;

    /**
     * Start new ApplicationController.
     *
     * @param ApplicationService $applicationService
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(ApplicationService $applicationService, WrestlerRepository $wrestlerRepo)
    {
        $this->applicationService = $applicationService;
        $this->wrestlerRepo = $wrestlerRepo;
    }

    /**
     * Display the admin applications view.
     * 
     * @return view
     */
    public function index()
    {
        $applications = $this->wrestlerRepo->getNonAvailableWrestlers(['id', 'name']);
        return view('admin.roster.applications', compact('applications'));
    }
    
    /**
     * Accept or decline applicants.
     * 
     * @param Request $request
     * @return response
     */
    public function update(Request $request)
    {
        try {
            $message = $this->applicationService->task($request->except('_token', '_method'));
            return redirect()->route('admin.roster.applications')->with('message', $message);
        } catch (ValidationException $error) {
            return redirect()->route('admin.roster.applications')->withErrors($error->getErrors());
        }
    }
}
