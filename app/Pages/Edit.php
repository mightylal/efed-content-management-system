<?php

namespace Efed\Pages;

use Efed\Contracts\Repositories\PageRepository;
use Efed\Validation\PageValidator;

class Edit
{
    
    /**
     * @var PageRepository
     */
    private $pageRepo;
    
    /**
     * Start new Edit.
     * 
     * @param PageRepository $pageRepo
     */
    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }
    
    /**
     * Update the page.
     * 
     * @param integer $page_id
     * @param array $input
     */
    public function handle($page_id, $input)
    {
        (new PageValidator)->validateEditPage($input);
        $input['content'] = clean($input['content'], 'fedpage');
        $this->pageRepo->update($page_id, $input);
    }
    
}