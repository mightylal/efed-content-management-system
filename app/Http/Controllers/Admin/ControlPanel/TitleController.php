<?php

namespace Efed\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\Admin\TitleService;
use Efed\Exceptions\ValidationException;
use Efed\Contracts\Repositories\TitleRepository;
use Efed\Contracts\Repositories\WrestlerRepository;

class TitleController extends Controller
{
    /**
     * @var TitleService
     */
    private $titleService;

    /**
     * @var TitleRepository
     */
    private $titleRepo;

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new TitleController.
     * 
     * @param TitleService $titleService
     * @param TitleRepository $titleRepo
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(TitleService $titleService, TitleRepository $titleRepo, WrestlerRepository $wrestlerRepo)
    {
        $this->titleService = $titleService;    
        $this->titleRepo = $titleRepo;
        $this->wrestlerRepo = $wrestlerRepo;
    }
    
    /**
     * Display the fed titles view.
     * 
     * @return view
     */
    public function index()
    {
        $titles = $this->titleRepo->all(['id', 'name', 'placement']);
        return view('admin.control-panel.titles', compact('titles'));
    }

    /**
     * Create a new title
     *
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        try {
            $this->titleService->create(array_map('trim', $request->except('_token')));
            return redirect()->route('admin.titles')->with('message', 'Title created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.titles')->withErrors($error->getErrors());
        }
    }
    
    /**
     * Display the fed title edit view.
     * 
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $title = $this->titleRepo->find($id, ['id', 'name', 'type']);
        $wrestlers = $this->wrestlerRepo->getAvailableWrestlers(['id', 'name']);
        return view('admin.control-panel.title', compact('title', 'wrestlers'));
    }
    
    /**
     * Update the fed title.
     *
     * @param Request $request
     * @param integer $id
     * @return response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->titleService->edit($id, $request);
            return redirect()->route('admin.titles.edit', ['id' => $id])->with('message', 'Title edited successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.titles.edit', ['id' => $id])->withErrors($error->getErrors());
        }
    }
    
    /**
     * Update the placement of titles.
     * 
     * @param Request $request
     * @return response
     */
    public function placement(Request $request)
    {
        try {
            $this->titleService->placement($request->only('id'));
            return redirect()->route('admin.titles')->with('message', 'Titles placement updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.titles')->withErrors($error->getErrors());
        }
    }
    
    /**
     * Delete the title.
     * 
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function destroy($id, Request $request)
    {
        try {
            $this->titleService->delete(array_map('trim', $request->only('id')));
            return redirect()->route('admin.titles')->with('message', 'Title deleted successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('admin.titles.edit', ['id' => $id])->withErrors($error->getErrors());
        }
    }
}
