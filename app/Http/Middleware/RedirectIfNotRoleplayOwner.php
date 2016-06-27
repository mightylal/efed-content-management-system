<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\RoleplayRepository;
use Auth;

class RedirectIfNotRoleplayOwner
{
    /**
     * @var RoleplayRepository
     */
    private $roleplayRepo;

    /**
     * Start new RedirectIfNotRoleplayOwner.
     * 
     * @param RoleplayRepository $roleplayRepo
     */
    public function __construct(RoleplayRepository $roleplayRepo)
    {
        $this->roleplayRepo = $roleplayRepo;
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
        $roleplay_id = $request->route('id');
        $roleplay = $this->roleplayRepo->get($roleplay_id, ['wrestler_id']);
        if (Auth::id() !== $roleplay['wrestler_id']) {
            return redirect()->route('roleplays');
        }
        return $next($request);
    }
}
