<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Grading\CanGrade;
use Auth;

class RedirectIfNotAllowedToGradeRoleplay
{
    /**
     * @var CanGrade
     */
    private $canGrade;

    /**
     * Start new RedirectIfNotAllowedToGradeRoleplay.
     * 
     * @param CanGrade $canGrade
     * @return void
     */
    public function __construct(CanGrade $canGrade)
    {
        $this->canGrade = $canGrade;    
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
        $wrestler_id = Auth::id();
        if (!$this->canGrade->check($roleplay_id, $wrestler_id)) {
            return back();
        }
        return $next($request);
    }
}
