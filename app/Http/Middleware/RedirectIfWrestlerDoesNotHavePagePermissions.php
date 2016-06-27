<?php

namespace Efed\Http\Middleware;

use Auth;
use Staff;
use Closure;
use Efed\Contracts\Repositories\PageRepository;

class RedirectIfWrestlerDoesNotHavePagePermissions
{
    /**
     * @var PageRepository
     */
    private $pageRepo;

    /**
     * Start new RedirectIfWrestlerDoesNotHavePagePermissions.
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
        $page = $this->pageRepo->get($page_id, ['access']);
        if ($page['access'] == 'Staff' && (!Auth::check() || (!Auth::user()->admin && !Staff::is(Auth::id())))) {
            return redirect()->route('home');    
        }
        return $next($request);
    }
}
