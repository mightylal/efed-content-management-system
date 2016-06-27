<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\ForumTopicRepository;

class RedirectIfForumTopicDoesNotExist
{
    /**
     * @var ForumTopicRepository
     */
    private $forumTopicRepo;

    /**
     * Start new RedirectIfForumTopicDoesNotExist.
     *
     * @param ForumTopicRepository $forumTopicRepo
     */
    public function __construct(ForumTopicRepository $forumTopicRepo)
    {
        $this->forumTopicRepo = $forumTopicRepo;
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
        $topic_id = $request->route('topic');
        if (!$this->forumTopicRepo->exists($topic_id)) {
            return redirect()->route('forum');
        }
        return $next($request);
    }
}
