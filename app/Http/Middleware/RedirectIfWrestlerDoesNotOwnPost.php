<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\ForumPostRepository;
use Auth;

class RedirectIfWrestlerDoesNotOwnPost
{
    /**
     * @var ForumPostRepository
     */
    private $forumPostRepo;

    /**
     * Start new RedirectIfWrestlerDoesNotOwnPost.
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
        $post = $this->forumPostRepo->get($post_id, ['wrestler_id']);
        if ($post['wrestler_id'] != Auth::id()) {
            return redirect()->route('forum');
        }
        return $next($request);
    }
}
