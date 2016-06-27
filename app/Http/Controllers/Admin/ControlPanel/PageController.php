<?php

namespace Efed\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\PageService;
use Efed\Contracts\Repositories\PageRepository;
use Efed\Exceptions\ValidationException;

class PageController extends Controller
{
    /**
     * @var PageService
     */
    private $pageService;

    /**
     * @var PageRepository
     */
    private $pageRepo;

    /**
     * Start new PageService.
     *
     * @param PageService $pageService
     * @param PageRepository $pageRepo
     */
    public function __construct(PageService $pageService, PageRepository $pageRepo)
    {
        $this->pageService = $pageService;
        $this->pageRepo = $pageRepo;
    }

    /**
     * Display the admin pages view.
     * 
     * @return view
     */
    public function index()
    {
        $pages = $this->pageRepo->all(['id', 'name', 'access', 'placement']);
        return view('admin.control-panel.pages', compact('pages'));
    }

    /**
     * Create a new page.
     *
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        try {
            $this->pageService->create(array_map('trim', $request->except('_token')));
            return redirect()->route('admin.pages')->with('message', 'Page created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.pages')->withErrors($error->getErrors());
        }
    }
    
    /**
     * Update page placement.
     * 
     * @param Request $request
     * @return response
     */
    public function placement(Request $request)
    {
        try {
            $this->pageService->placement($request->only('id'));
            return redirect()->route('admin.pages')->with('message', 'Page placement updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.pages')->withErrors($error->getErrors());
        }
    }
}
