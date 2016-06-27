<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\SegmentRepository;

class RedirectIfSegmentDoesNotExist
{
    /**
     * @var SegmentRepository
     */
    private $segmentRepo;

    /**
     * Start new RedirectIfSegmentDoesNotExist.
     * 
     * @param SegmentRepository $segmentRepo
     */
    public function __construct(SegmentRepository $segmentRepo)
    {
        $this->segmentRepo = $segmentRepo;
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
        $segment_id = $request->route('segment_id');
        if (!$this->segmentRepo->exists($event_id, $segment_id)) {
            return redirect()->route('admin.events');
        }
        return $next($request);
    }
}
