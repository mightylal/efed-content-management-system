<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Contracts\Repositories\MessageWrestlerRepository;
use Auth;

class RedirectIfWrestlerNotApartOfMessage
{
    /**
     * @var MessageWrestlerRepository
     */
    private $messageWrestlerRepo;

    /**
     * Start new RedirectIfWrestlerNotApartOfMessage.
     * 
     * @param MessageWrestlerRepository $messageWrestlerRepo
     */
    public function __construct(MessageWrestlerRepository $messageWrestlerRepo)
    {
        $this->messageWrestlerRepo = $messageWrestlerRepo;
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
        $message_id = $request->route('message');
        if (!$this->messageWrestlerRepo->exists(Auth::id(), $message_id)) {
            return redirect()->route('messages');
        }
        return $next($request);
    }
}
