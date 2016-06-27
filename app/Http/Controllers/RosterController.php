<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\RosterService;
use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Roster\Champions;
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
     * @var Champions
     */
    private $champions;

    /**
     * Start new RosterController.
     *
     * @param RosterService $rosterService
     * @param WrestlerRepository $wrestlerRepo
     * @param Champions $champions
     */
    public function __construct(RosterService $rosterService, WrestlerRepository $wrestlerRepo, Champions $champions)
    {
        $this->rosterService = $rosterService;
        $this->wrestlerRepo = $wrestlerRepo;
        $this->champions = $champions;
    }
    
    /**
     * Display the roster.
     *
     * @return view
     */
    public function index()
    {
        $wrestlers = $this->wrestlerRepo->getAvailableWrestlers(['id', 'name', 'slug']);
        $champions = $this->champions->get();
        return view('roster', compact('wrestlers', 'champions'));
    }
    
    /**
     * Display a wrestler.
     * 
     * @param string $slug
     * @return view
     */
    public function show($slug)
    {
        $wrestler = $this->wrestlerRepo->getBySlug($slug);
        return view('wrestler', compact('wrestler'));
    }

    /**
     * Edit a wrestler.
     *
     * @param string $slug
     * @return view
     */
    public function edit($slug)
    {
        $wrestler = $this->wrestlerRepo->getBySlug($slug);
        return view('edit_wrestler', compact('wrestler'));
    }

    /**
     * Update a wrestler.
     *
     * @param string $slug
     * @param Request $request
     * @return response
     */
    public function update($slug, Request $request)
    {
        try {
            $updatedSlug = $this->rosterService->update($this->wrestlerId(), $request);
            return redirect()->route('roster.wrestler', ['wrestler' => $updatedSlug])->with('message', 'Wrestler updated successfully.');
        } catch (ValidationException $errors) {
            return redirect()->route('roster.wrestler.edit', ['wrestler' => $slug])->withErrors($errors->getErrors());
        }
    }
}
