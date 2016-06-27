<?php

namespace Efed\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Efed\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Efed\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Efed\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Efed\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'titleExists' => \Efed\Http\Middleware\RedirectIfTitleDoesNotExist::class,
        'eventExists' => \Efed\Http\Middleware\RedirectIfEventDoesNotExist::class,
        'rpExists' => \Efed\Http\Middleware\RedirectIfRoleplayDoesNotExist::class,
        'canGrade' => \Efed\Http\Middleware\RedirectIfNotAllowedToGradeRoleplay::class,
        'wrestlerExists' => \Efed\Http\Middleware\RedirectIfWrestlerDoesNotExist::class,
        'wrestlerOwner' => \Efed\Http\Middleware\RedirectIfNotWrestlerOwner::class,
        'forumCategoryExists' => \Efed\Http\Middleware\RedirectIfForumCategoryDoesNotExist::class,
        'forumPostExists' => \Efed\Http\Middleware\RedirectIfForumPostDoesNotExist::class,
        'forumTopicExists' => \Efed\Http\Middleware\RedirectIfForumTopicDoesNotExist::class,
        'forumAccessRights' => \Efed\Http\Middleware\RedirectIfWrestlerDoesNotHaveForumAccessRights::class,
        'forumPostingRights' => \Efed\Http\Middleware\RedirectIfWrestlerDoesNotHaveForumPostingRights::class,
        'wrestlerOwnsPost' => \Efed\Http\Middleware\RedirectIfWrestlerDoesNotOwnPost::class,
        'admin' => \Efed\Http\Middleware\RedirectIfNotAdmin::class,
        'apartOfMessage' => \Efed\Http\Middleware\RedirectIfWrestlerNotApartOfMessage::class,
        'activated' => \Efed\Http\Middleware\RedirectIfNotActivated::class,
        'roleplayOwner' => \Efed\Http\Middleware\RedirectIfNotRoleplayOwner::class,
        'adminOrStaff' => \Efed\Http\Middleware\RedirectIfNotAdminOrStaff::class,
        'pageExists' => \Efed\Http\Middleware\RedirectIfPageDoesNotExist::class,
        'pagePermissions' => \Efed\Http\Middleware\RedirectIfWrestlerDoesNotHavePagePermissions::class,
        'segmentExists' => \Efed\Http\Middleware\RedirectIfSegmentDoesNotExist::class,
        'eventRan' => \Efed\Http\Middleware\RedirectIfEventAlreadyRan::class,
    ];
}
