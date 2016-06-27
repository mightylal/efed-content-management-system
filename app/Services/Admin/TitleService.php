<?php

namespace Efed\Services\Admin;

use Efed\Title\Title;
use Efed\Contracts\Repositories\TitleRepository;
use Efed\Contracts\Repositories\TitleReignRepository;
use Efed\Validation\TitleValidator;
use Illuminate\Http\Request;
use Efed\Models\TitleImage;
use Efed\Image\Upload;
use Carbon\Carbon;
use Efed\Placement\Placement;

class TitleService
{
    
    /**
     * @var TitleRepository
     */
    private $titleRepo;

    /**
     * @var TitleReignRepository
     */
    private $titleReignRepo;

    /**
     * @var Title
     */
    private $title;
    
    /**
     * Start new TitleService.
     * 
     * @param TitleRepository $titleRepo
     * @param TitleReignRepository $titleReignRepo
     * @param Title $title
     */
    public function __construct(TitleRepository $titleRepo, TitleReignRepository $titleReignRepo, Title $title)
    {
        $this->titleRepo = $titleRepo;
        $this->titleReignRepo = $titleReignRepo;
        $this->title = $title;
    }
    
    /**
     * Create a new title.
     * 
     * @param array $input
     */
    public function create($input)
    {
        (new TitleValidator)->validateTitle($input);
        $input['placement'] = $this->titleRepo->count() + 1;
        $this->titleRepo->create($input);
        $this->titleReignRepo->create(['title_id' => $this->titleRepo->insertId(), 'date_won' => Carbon::now()->toDateTimeString()]);
    }

    /**
     * Edit a title.
     *
     * @param integer $id
     * @param Request $request
     */
    public function edit($id, Request $request)
    {
        $input = array_map('trim', $request->only('name', 'doAssign'));
        $input['assign'] = array_map('trim', $request->assign);
        $input['id'] = $id;
        $input['image'] = $request->file('image');
        (new TitleValidator)->validateEditTitle($input);
        if ($request->hasFile('image')) {
            (new Upload)->handle(new TitleImage, $request->file('image'), $id);
        }
        $editTitleAttributes = ['name' => trim($input['name'])];
        $this->titleRepo->update($id, $editTitleAttributes);
        // if selected to assign titles
        if ($input['doAssign'] == 'yes') {
            $title = $this->titleRepo->find($id, ['type']);
            $this->title->assign($id, $title['type'], $input['assign']);
        }
    }
    
    /**
     * Update the title placement.
     * 
     * @param array $input
     */
    public function placement($input)
    {
        (new Placement)->handle(new Titlevalidator, $this->titleRepo, $input);
    }

    /**
     * Delete a title.
     *
     * @param array $input
     */
    public function delete($input)
    {
        (new TitleValidator)->validateDeleteTitle($input);
        $this->titleRepo->delete($input['id']);
        $this->titleReignRepo->deleteByTitle($input['id']);
    }
    
}