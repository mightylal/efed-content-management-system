<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    /**
     * Home route
     */
    Route::get('/', ['as' => 'home', 'uses' => 'FedController@index']);
    /**
     * Auth routes
     */
    Route::group(['middleware' => ['auth']], function () {
        /**
         * Messages routes
         */
        Route::get('messages', ['as' => 'messages', 'uses' => 'MessageController@index']);
        Route::get('messages/create', ['as' => 'messages.create', 'uses' => 'MessageController@create']);
        Route::post('messages/create', 'MessageController@storeMessage');
        Route::delete('messages', 'MessageController@destroy');
        Route::group(['middleware' => ['apartOfMessage']], function () {
            Route::get('messages/{message}', ['as' => 'message', 'uses' => 'MessageController@show']);
            Route::post('messages/{message}', 'MessageController@storeReply');
        });
        /**
         * Roleplay routes
         */
        Route::group(['middleware' => ['activated']], function () {
            Route::get('roleplays/create', ['as' => 'createRoleplay', 'uses' => 'RoleplayController@create']);
            Route::post('roleplays/create', 'RoleplayController@store');
            Route::post('roleplays/{id}', ['middleware' => ['rpExists', 'canGrade'], 'as' => 'canGrade', 'uses' => 'RoleplayController@grade']);
            Route::group(['middleware' => ['rpExists', 'roleplayOwner']], function () {
                Route::get('roleplays/{id}/edit', ['as' => 'roleplay.edit', 'uses' => 'RoleplayController@edit']);
                Route::put('roleplays/{id}/edit', 'RoleplayController@update');
            });
        });
        /**
         * Roster routes
         */
        Route::group(['middleware' => ['wrestlerExists', 'wrestlerOwner']], function () {
            Route::get('roster/{wrestler}/edit', ['as' => 'roster.wrestler.edit', 'uses' => 'RosterController@edit']);
            Route::put('roster/{wrestler}/edit', 'RosterController@update');
        });
        /**
         * Forum routes
         */
        Route::group(['middleware' => ['activated', 'forumAccessRights', 'forumPostingRights']], function () {
            Route::post('forum/{category}', ['middleware' => 'forumCategoryExists', 'uses' => 'ForumController@storeTopic']);
            Route::post('forum/{category}/topic/{topic}', ['middleware' => 'forumTopicExists', 'uses' => 'ForumController@storePost']);
        });
        Route::group(['middleware' => ['activated', 'forumPostExists', 'wrestlerOwnsPost']], function () {
            Route::get('forum/{category}/topic/{topic}/post/{post}/edit', ['as' => 'forum.edit', 'uses' => 'ForumController@edit']);
            Route::put('forum/{category}/topic/{topic}/post/{post}/edit', 'ForumController@update');
        });
    });
    /**
     * Event routes
     */
    Route::get('events', ['as' => 'events', 'uses' => 'EventController@index']);
    Route::get('events/{id}', ['middleware' => 'eventExists', 'as' => 'event', 'uses' => 'EventController@show']);
    /**
     * Roleplay routes
     */
    Route::get('roleplays', ['as' => 'roleplays', 'uses' => 'RoleplayController@index']);
    Route::get('roleplays/{id}', ['middleware' => 'rpExists', 'as' => 'roleplay', 'uses' => 'RoleplayController@show']);
    /**
     * Roster routes
     */
    Route::get('roster', ['as' => 'roster', 'uses' => 'RosterController@index']);
    Route::get('roster/{wrestler}', ['middleware' => 'wrestlerExists', 'as' => 'roster.wrestler', 'uses' => 'RosterController@show']);
    /**
     * Forum routes
     */
    Route::get('forum', ['as' => 'forum', 'uses' => 'ForumController@index']);
    Route::group(['middleware' => ['forumCategoryExists', 'forumAccessRights']], function () {
        Route::get('forum/{category}', ['as' => 'forum.category', 'uses' => 'ForumController@category']);
    });
    Route::group(['middleware' => ['forumTopicExists', 'forumAccessRights']], function () {
        Route::get('forum/{category}/topic/{topic}', ['as' => 'forum.topic', 'uses' => 'ForumController@topic']);
    });
    /**
     * Sign in and register routes
     */
    Route::get('sign-in', ['as' => 'signin', 'uses' => 'WrestlerAuthenticationController@getLogin']);
    Route::post('sign-in', 'WrestlerAuthenticationController@login');
    Route::get('register', ['as' => 'register', 'uses' => 'WrestlerAuthenticationController@getRegister']);
    Route::post('register', 'WrestlerAuthenticationController@register');
    Route::get('sign-out', ['as' => 'signout', 'uses' => 'WrestlerAuthenticationController@logout']);
    /**
     * Page routes
     */
    Route::get('pages/{page}', ['middleware' => ['pageExists', 'pagePermissions'], 'as' => 'page', 'uses' => 'PageController@show']);
    /**
     * Admin routes
     */
    Route::group(['middleware' => ['auth', 'adminOrStaff']], function () {
        /**
         * Home routes
         */
        Route::get('edit', ['as' => 'home.edit', 'uses' => 'FedController@edit']);
        Route::put('edit', 'FedController@update');
        /**
         * Page routes
         */
        Route::group(['middleware' => ['pageExists']], function () {
            Route::get('pages/{page}/edit', ['as' => 'page.edit', 'uses' => 'PageController@edit']);
            Route::put('pages/{page}/edit', 'PageController@update');
            Route::delete('pages/{page}', 'PageController@destroy');    
        });
        /**
         * Settings routes
         */
        Route::get('admin/settings', ['as' => 'admin.settings', 'uses' => 'Admin\ControlPanel\SettingsController@index']);
        Route::put('admin/settings', 'Admin\ControlPanel\SettingsController@update');
        /**
         * Titles routes
         */
        Route::get('admin/titles', ['as' => 'admin.titles', 'uses' => 'Admin\ControlPanel\TitleController@index']);
        Route::post('admin/titles', 'Admin\ControlPanel\TitleController@store');
        Route::put('admin/titles', 'Admin\ControlPanel\TitleController@placement');
        Route::group(['middleware' => ['titleExists']], function () {
            Route::get('admin/titles/{id}/edit', ['as' => 'admin.titles.edit', 'uses' => 'Admin\ControlPanel\TitleController@edit']);
            Route::put('admin/titles/{id}/edit', 'Admin\ControlPanel\TitleController@update');
            Route::delete('admin/titles/{id}/edit', 'Admin\ControlPanel\TitleController@destroy');    
        });
        /**
         * Design routes
         */
        Route::get('admin/design', ['as' => 'admin.design', 'uses' => 'Admin\ControlPanel\DesignController@index']);
        Route::put('admin/design', 'Admin\ControlPanel\DesignController@update');
        /**
         * Pages routes
         */
        Route::get('admin/pages', ['as' => 'admin.pages', 'uses' => 'Admin\ControlPanel\PageController@index']);
        Route::post('admin/pages', 'Admin\ControlPanel\PageController@store');
        Route::put('admin/pages', 'Admin\ControlPanel\PageController@placement');
        /**
         * Forum routes
         */
        Route::get('admin/forum', ['as' => 'admin.forum', 'uses' => 'Admin\ControlPanel\ForumController@index']);
        Route::post('admin/forum', 'Admin\ControlPanel\ForumController@store');
        Route::put('admin/forum', 'Admin\ControlPanel\ForumController@placement');
        Route::group(['middleware' => ['forumCategoryExists']], function () {
            Route::get('admin/forum/{category}/edit', ['as' => 'admin.forum.edit', 'uses' => 'Admin\ControlPanel\ForumController@edit']);
            Route::put('admin/forum/{category}/edit', 'Admin\ControlPanel\ForumController@update');
            Route::delete('admin/forum/{category}/edit', 'Admin\ControlPanel\ForumController@destroy');    
        });
        Route::group(['middleware' => ['forumTopicExists']], function () {
            Route::get('forum/{category}/topic/{topic}/lock', ['as' => 'forum.lock', 'uses' => 'ForumController@lock']);
            Route::get('forum/{category}/topic/{topic}/pin', ['as' => 'forum.pin', 'uses' => 'ForumController@pin']);
        });
        /**
         * Staff routes
         */
        Route::group(['middleware' => ['admin']], function () {
            Route::get('admin/staff', ['as' => 'admin.staff', 'uses' => 'Admin\ControlPanel\StaffController@index']);
            Route::post('admin/staff', 'Admin\ControlPanel\StaffController@store');
            Route::delete('admin/staff', 'Admin\ControlPanel\StaffController@destroy');
        });
        /**
         * Roster routes
         */
        Route::get('admin/roster', ['as' => 'admin.roster', 'uses' => 'Admin\Roster\RosterController@index']);
        Route::delete('admin/roster', 'Admin\Roster\RosterController@destroy');
        Route::get('admin/roster/applications', ['as' => 'admin.roster.applications', 'uses' => 'Admin\Roster\ApplicationController@index']);
        Route::put('admin/roster/applications', 'Admin\Roster\ApplicationController@update');
        /**
         * Event routes
         */
        Route::get('admin/events', ['as' => 'admin.events', 'uses' => 'Admin\Events\EventController@index']);
        Route::post('admin/events', 'Admin\Events\EventController@store');
        Route::delete('admin/events', 'Admin\Events\EventController@destroy');
        Route::group(['middleware' => ['eventExists']], function () {
            Route::get('admin/events/{id}/edit', ['as' => 'admin.events.edit', 'uses' => 'Admin\Events\EventController@edit']);
            Route::put('admin/events/{id}/edit', 'Admin\Events\EventController@update');
            Route::post('admin/events/{id}/run', ['middleware' => 'eventRan', 'as' => 'admin.events.run', 'uses' => 'Admin\Events\EventController@run']);
            Route::group(['middleware' => ['segmentExists']], function () {
                Route::get('admin/events/{id}/segment/{segment_id}/edit', ['as' => 'admin.events.segment.edit', 'uses' => 'Admin\Events\SegmentController@edit']);
                Route::delete('admin/events/{id}/segment/{segment_id}/edit', 'Admin\Events\SegmentController@destroy');
                Route::put('admin/events/{id}/segment/{segment_id}/edit', 'Admin\Events\SegmentController@update');
            });
        });
        Route::get('admin/events/segment/create', ['as' => 'admin.events.segment.create', 'uses' => 'Admin\Events\SegmentController@create']);
        Route::post('admin/events/segment/create', 'Admin\Events\SegmentController@store');
    });
});
