<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;
use Efed\Http\Requests;
use Efed\Contracts\Repositories\PageRepository;
use Efed\Pages\Edit;
use Efed\Exceptions\ValidationException;

class PageController extends Controller
{
    /**
     * @var PageRepository
     */
    private $pageRepo;

    /**
     * @var Edit
     */
    private $edit;

    /**
     * Start new PageController.
     * 
     * @param PageRepository $pageRepo
     * @param Edit $edit
     */
    public function __construct(PageRepository $pageRepo, Edit $edit)
    {
        $this->pageRepo = $pageRepo;
        $this->edit = $edit;
    }
    
    /**
     * Display the page.
     *
     * @param string $id
     * @return view
     */
    public function show($id)
    {
        // middleware to make sure page exists and page access
        $page = $this->pageRepo->get($id, ['content']);
        return view('page', compact('page'));
    }
    
    /**
     * Edit the page.
     * 
     * @param string $id
     * @return view
     */
    public function edit($id)
    {
        // middleware to make sure page exists and access rights
        $page = $this->pageRepo->get($id);
        return view('edit_page', compact('page'));
    }

    /**
     * Update the page.
     *
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function update($id, Request $request)
    {
        // middleware to make sure page exists and access rights
        try {
            $this->edit->handle(trim($id), array_map('trim', $request->only('name', 'access', 'content')));
            return redirect()->route('page', ['page' => $id])->with('message', 'Page updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('page.edit', ['page' => $id])->withErrors($error->getErrors());
        }
    }
    
    /**
     * Destroy a page.
     * 
     * @param string $id
     * @return response
     */
    public function destroy($id)
    {
        // middleware to make sure page exists
        $this->pageRepo->delete($id);
        return redirect()->route('home')->with('message', 'Page deleted successfully.');
    }
}
