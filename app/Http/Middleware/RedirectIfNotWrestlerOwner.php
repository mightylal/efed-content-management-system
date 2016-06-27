<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\WrestlerRepository;
use Auth;

class RedirectIfNotWrestlerOwner
{
    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new RedirectIfNotWrestlerOwner.
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
        $wrestler = $this->wrestlerRepo->getBySlug($slug, ['id']);
        if (Auth::id() !== $wrestler['id'] || !$this->wrestlerRepo->isActivated($wrestler['id'])) {
            return back();
        }
        return $next($request);
    }
}
