<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\EventRepository;

class RedirectIfEventAlreadyRan
{
    /**
     * @var EventRepository
     */
    private $eventRepo;

    /**
     * Start new RedirectIfEventAlreadyRan.
     * 
     * @param EventRepository $eventRepo
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
        $event_id = $request->route('id');
        $event = $this->eventRepo->find($event_id, ['run']);
        if ($event['run']) {
            return redirect()->route('admin.events');
        }
        return $next($request);
    }
}
