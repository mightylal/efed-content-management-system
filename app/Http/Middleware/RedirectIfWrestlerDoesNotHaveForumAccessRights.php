<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\ForumRepository;
use Auth;

class RedirectIfWrestlerDoesNotHaveForumAccessRights
{
    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * Start new RedirectIfWrestlerDoesNotHaveForumAccessRights.
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
        $forum = $this->forumRepo->get($category_id, ['access']);
        if ($forum['access'] == 'Staff' && !Auth::user()->admin) {
            return redirect()->route('forum');
        }
        return $next($request);
    }
}
