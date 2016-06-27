<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\RoleplayRepository;

class RedirectIfRoleplayDoesNotExist
{
    /**
     * @var RoleplayRepository
     */
    private $roleplayRepo;

    /**
     * Start new RedirectIfRoleplayDoesNotExist.
     * 
     * @param RoleplayRepository $roleplayRepo
     * @return void
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
        $id = $request->route('id');
        if (!$this->roleplayRepo->exists($id)) {
            return back();
        }
        return $next($request);
    }
}
