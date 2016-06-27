<?php

namespace Efed\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\ForumService;
use Efed\Exceptions\ValidationException;
use Efed\Contracts\Repositories\ForumRepository;

class ForumController extends Controller
{
    /**
     * @var ForumService
     */
    private $forumService;

    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * Start new ForumController.
     *
     * @param ForumService $forumService
     * @param ForumRepository $forumRepo
     */
    public function __construct(ForumService $forumService, ForumRepository $forumRepo)
    {
        $this->forumService = $forumService;
        $this->forumRepo = $forumRepo;
    }

    /**
     * Display the admin forum view.
     * 
     * @return view
     */
    public function index()
    {
        $forums = $this->forumRepo->all(['id', 'name', 'description', 'access', 'posting', 'placement']);
        return view('admin.control-panel.forum', compact('forums'));
    }

    /**
     * Display the admin edit forum view.
     * 
     * @param string $id
     * @return view
     */
    public function edit($id)
    {
        $forum = $this->forumRepo->get($id, ['id', 'name', 'description', 'access', 'posting']);
        return view('admin.control-panel.category', compact('forum'));
    }

    /**
     * Create a forum.
     *
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        try {
            $this->forumService->create(array_map('trim', $request->only('name', 'description', 'access', 'posting')));
            return redirect()->route('admin.forum')->with('message', 'Forum created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.forum')->withErrors($error->getErrors());
        }
    }

    /**
     * Update a forum.
     * 
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function update($id, Request $request)
    {
        try {
            $this->forumService->update(trim($id), array_map('trim', $request->only('name', 'description', 'access', 'posting')));
            return redirect()->route('admin.forum.edit', ['category' => $id])->with('message', 'Forum updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.forum.edit', ['category' => $id])->withErrors($error->getErrors());
        }
    }

    /**
     * Delete a forum.
     * 
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function destroy($id, Request $request)
    {
        try {
            $this->forumService->delete(array_map('trim', $request->only('id')));
            return redirect()->route('admin.forum')->with('message', 'Forum deleted successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.forum.edit', ['category' => $id])->withErrors($error->getErrors());
        }
    }

    /**
     * Update the placement.
     *
     * @param Request $request
     * @return response
     */
    public function placement(Request $request)
    {
        try {
            $this->forumService->placement($request->only('id'));
            return redirect()->route('admin.forum')->with('message', 'Forum placement updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.forum')->withErrors($error->getErrors());
        }
    }
}
