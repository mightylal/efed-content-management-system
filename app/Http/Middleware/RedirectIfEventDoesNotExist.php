<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\EventRepository;

class RedirectIfEventDoesNotExist
{
    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * Start new RedirectIfEventDoesNotExist.
     *
     * @param EventRepository $eventRepo
     * @return void
     */
    public function __construct(EventRepository $eventRepo)
    {
        $this->eventRepo = $eventRepo;
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
        $id = $request->route('id');
        if (!$this->eventRepo->exists($id)) {
            return back();
        }
        return $next($request);
    }
}
