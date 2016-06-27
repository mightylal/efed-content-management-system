<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\ForumRepository;
use Auth;

class RedirectIfWrestlerDoesNotHaveForumPostingRights
{
    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * Start new RedirectIfWrestlerDoesNotHaveForumPostingRights.
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
        $forum = $this->forumRepo->get($category_id, ['posting']);
        if ($forum['posting'] == 'Staff' && !Auth::user()->admin) {
            return redirect()->route('forum');
        }
        return $next($request);
    }
}
