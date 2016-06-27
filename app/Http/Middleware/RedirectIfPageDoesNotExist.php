<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\PageRepository;

class RedirectIfPageDoesNotExist
{
    /**
     * @var PageRepository
     */
    private $pageRepo;

    /**
     * Start new RedirectIfPageDoesNotExist.
     * 
     * @param PageRepository $pageRepo
     */
    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $page_id = $request->route('page');
        if (!$this->pageRepo->exists($page_id)) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
