<?php

namespace Efed\Http\ViewComposers;

use Auth;
use Illuminate\View\View;
use Efed\Messages\NewCount;
use Efed\Contracts\Repositories\PageRepository;
use Efed\Contracts\Repositories\WrestlerRepository;

class MenuComposer
{

    /**
     * @var NewCount
     */
    private $count;

    /**
     * @var PageRepository
     */
    private $pageRepo;

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new MenuComposer.
     *
     * @param NewCount $count
     * @param PageRepository $pageRepo
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(NewCount $count, PageRepository $pageRepo, WrestlerRepository $wrestlerRepo)
    {
        $this->count = $count;
        $this->pageRepo = $pageRepo;
        $this->wrestlerRepo = $wrestlerRepo;
    }

    /**
     * Bind data to view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $newCount = 0;
        if (Auth::check()) {
            $newCount = $this->count->get(Auth::id());
        }
        $pages = $this->pageRepo->all(['id', 'name', 'access']);
        $applications = $this->wrestlerRepo->notActivatedCount();
        $view->with(compact('newCount', 'pages', 'applications'));
    }

}