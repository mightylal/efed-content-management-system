<?php

namespace Efed\Http\Controllers\Admin\Roster;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\RosterService;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Exceptions\ValidationException;

class RosterController extends Controller
{
    /**
     * @var RosterService
     */
    private $rosterService;

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new RosterController.
     *
     * @param RosterService $rosterService
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(RosterService $rosterService, WrestlerRepository $wrestlerRepo)
    {
        $this->rosterService = $rosterService;
        $this->wrestlerRepo = $wrestlerRepo;
    }
    
    /**
     * Display the admin roster view.
     *
     * @return view
     */
    public function index()
    {
        $wrestlers = $this->wrestlerRepo->getAvailableWrestlers(['id', 'name', 'admin']);
        return view('admin.roster.roster', compact('wrestlers'));
    }
    
    /**
     * Remove wrestler from fed.
     * 
     * @param Request $request
     * @return response
     */
    public function destroy(Request $request)
    {
        try {
            $this->rosterService->remove($request->only('id'));
            return redirect()->route('admin.roster')->with('message', 'Wrestler(s) removed successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.roster')->withErrors($error->getErrors());
        }
    }
}
