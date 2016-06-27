<?php

namespace Efed\Services\Admin;

use Efed\Contracts\Repositories\PageRepository;
use Efed\Validation\PageValidator;
use Efed\Placement\Placement;

class PageService
{
    
    /**
     * @var PageRepository
     */
    private $pageRepo;
    
    /**
     * Start new PageService.
     * 
     * @param PageRepository $pageRepo
     * @return void
     */
    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }
    
    /**
     * Create a new page.
     * 
     * @param array $input
     * @return void
     */
    public function create($input)
    {
        (new PageValidator)->validateCreatePage($input);
        $input['placement'] = $this->pageRepo->count() + 1;
        $this->pageRepo->create($input);
    }

    /**
     * Update page placement.
     *
     * @param array $input
     */
    public function placement($input)
    {
        (new Placement)->handle(new PageValidator, $this->pageRepo, $input);
    }
    
}