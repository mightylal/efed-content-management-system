<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\RoleplayService;
use Efed\Services\GradeService;
use Efed\Contracts\Repositories\RoleplayRepository;
use Efed\Exceptions\ValidationException;
use Efed\Contracts\Repositories\EventRepository;

class RoleplayController extends Controller
{
    /**
     * @var RoleplayService
     */
    private $roleplayService;

    /**
     * @var GradeService
     */
    private $gradeService;

    /**
     * @var RoleplayRepository
     */
    private $roleplayRepo;

    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * Start new RoleplayController.
     *
     * @param RoleplayService $roleplayService
     * @param GradeService $gradeService
     * @param RoleplayRepository $roleplayRepo
     * @param EventRepository $eventRepo
     */
    public function __construct(RoleplayService $roleplayService, GradeService $gradeService, RoleplayRepository $roleplayRepo, EventRepository $eventRepo)
    {
        $this->roleplayService = $roleplayService;
        $this->gradeService = $gradeService;
        $this->roleplayRepo = $roleplayRepo;
        $this->eventRepo = $eventRepo;
    }

    /**
     * Display the roleplays.
     *
     * @return view
     */
    public function index()
    {
        $roleplays = $this->roleplayRepo->allOrderByCreatedDateDesc(['id', 'wrestler_id', 'event_id', 'fed_score', 'name']);
        return view('roleplays', compact('roleplays'));
    }

    /**
     * Display the roleplay.
     *
     * @param integer $id
     * @return view
     */
    public function show($id)
    {
        $roleplay = $this->roleplayRepo->get($id, ['id', 'wrestler_id', 'event_id', 'fed_score', 'name', 'rp', 'created_at']);
        $canGrade = $this->gradeService->canGrade($id, $this->wrestlerId());
        $comments = $this->roleplayService->comments($id, $this->wrestlerId());
        $canEdit = $this->roleplayService->canEdit($id, $this->wrestlerId());
        return view('roleplay', compact('roleplay', 'canGrade', 'comments', 'canEdit'));
    }

    /**
     * Display the create roleplay view.
     *
     * @return view
     */
    public function create()
    {
        $events = $this->eventRepo->getUpcomingEvents(['id', 'name', 'scheduled_at']);
        return view('createRoleplay', compact('events'));
    }

    /**
     * Create a roleplay.
     *
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        try {
            $this->roleplayService->create($this->wrestlerId(), array_map('trim', $request->except('_token')));
            return redirect()->route('createRoleplay')->with('message', 'Roleplay created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('createRoleplay')->withErrors($error->getErrors());
        }
    }

    /**
     * Grade a roleplay.
     *
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function grade($id, Request $request)
    {
        try {
            $this->gradeService->create(trim($id), $this->wrestlerId(), array_map('trim', $request->except('_token')));
            return redirect()->route('roleplay', ['id' => $id])->with('message', 'Roleplay graded successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('roleplay', ['id' => $id])->withErrors($error->getErrors());
        }
    }

    /**
     * Edit a roleplay.
     *
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $roleplay = $this->roleplayRepo->get($id, ['id', 'wrestler_id', 'event_id', 'fed_score', 'name', 'rp', 'created_at']);
        return view('edit_roleplay', compact('roleplay'));
    }

    /**
     * Update a roleplay.
     *
     * @param integer $id
     * @param Request $request
     * @return response
     */
    public function update($id, Request $request)
    {
        try {
            $this->roleplayService->update(trim($id), array_map('trim', $request->except(['_token', '_method'])));
            return redirect()->route('roleplay', ['id' => $id])->with('message', 'Roleplay updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('roleplay.edit', ['id' => $id])->withErrors($error->getErrors());
        }
    }
}
