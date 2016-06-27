<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\ForumRepository;

class RedirectIfForumCategoryDoesNotExist
{
    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * Start new RedirectIfForumCategoryDoesNotExist.
     * 
     * @param ForumRepository $forumRepo
     */
    public function __construct(ForumRepository $forumRepo)
    {
        $this->forumRepo = $forumRepo;        
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
        $category_id = $request->route('category');
        if (!$this->forumRepo->exists($category_id)) {
            return redirect()->route('forum');
        }
        return $next($request);
    }
}
