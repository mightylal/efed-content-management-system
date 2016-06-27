<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\ForumPostRepository;

class RedirectIfForumPostDoesNotExist
{
    /**
     * @var ForumPostRepository
     */
    private $forumPostRepo;

    /**
     * Start new RedirectIfForumPostDoesNotExist.
     * 
     * @param ForumPostRepository $forumPostRepo
     */
    public function __construct(ForumPostRepository $forumPostRepo)
    {
        $this->forumPostRepo = $forumPostRepo;
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
        $post_id = $request->route('post');
        if (!$this->forumPostRepo->exists($post_id)) {
            return redirect()->route('forum');
        }
        return $next($request);
    }
}
