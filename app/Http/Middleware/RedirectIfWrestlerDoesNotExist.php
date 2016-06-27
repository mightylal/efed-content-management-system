<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\WrestlerRepository;

class RedirectIfWrestlerDoesNotExist
{
    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new RedirectIfWrestlerDoesNotExist.
     * 
     * @param WrestlerRepository $wrestlerRepo
     * @return void
     */
    public function __construct(WrestlerRepository $wrestlerRepo)
    {
        $this->wrestlerRepo = $wrestlerRepo;    
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
        $slug = $request->route('wrestler');
        if (!$this->wrestlerRepo->existsBySlug($slug)) {
            return back();
        }
        return $next($request);
    }
}
