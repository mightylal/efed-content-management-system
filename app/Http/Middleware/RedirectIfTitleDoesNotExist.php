<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\TitleRepository;

class RedirectIfTitleDoesNotExist
{

    /**
     * @var TitleRepository
     */
    private $titleRepo;

    /**
     * Start new RedirectIfTitleDoesNotExist.
     *
     * @param Route $route
     * @param TitleRepository $titleRepo
     * @return void
     */
    public function __construct(TitleRepository $titleRepo)
    {
        $this->titleRepo = $titleRepo;
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
        if (!$this->titleRepo->exists($id)) {
            return back();
        }
        return $next($request);
    }
}
