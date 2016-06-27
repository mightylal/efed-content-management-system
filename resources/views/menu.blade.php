@inject('messageCount', 'Efed\Messages\NewCount')

<nav class="navbar navbar-default">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topMenu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="{{ asset('default_images/fed.png') }}" height="100" width="350" alt="logo">
                </div>
            </div>
            <div class="col-md-8">
                <div class="collapse navbar-collapse" id="topMenu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Home <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('home') }}">Fed Home</a></li>
                                @if ($pages)
                                    @foreach ($pages as $page)
                                        @if ($page['access'] == 'Staff' && Auth::check() && (Auth::user()->admin || Staff::is(Auth::id())))
                                            <li><a href="{{ route('page', ['page' => $page['id']]) }}">{{ $page['name'] }}</a></li>
                                        @elseif ($page['access'] == 'Everyone')
                                            <li><a href="{{ route('page', ['page' => $page['id']]) }}">{{ $page['name'] }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                                @if (Auth::check())
                                    <li><a href="{{ route('signout') }}">Sign Out</a></li>
                                @endif
                            </ul>

                        </li>
                        @if (Auth::check())
                            <li>
                                <a href="{{ route('messages') }}">
                                    Messages
                                    @if ($newCount)
                                        <span class="badge">{{ $newCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        <li><a href="{{ route('events') }}">Events</a></li>
                        <li><a href="{{ route('roleplays') }}">Roleplays</a></li>
                        <li><a href="{{ route('roster') }}">Roster</a></li>
                        <li><a href="{{ route('forum') }}">Forum</a></li>
                        @if (Auth::check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Wrestler <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('roster.wrestler', ['wrestler' => Auth::user()->slug]) }}">Profile</a></li>
                                    <li><a href="{{ route('createRoleplay') }}">Create Roleplay</a></li>
                                </ul>
                            </li>
                        @endif
                        @if (Auth::check() && (Auth::user()->admin === 1 || Staff::is(Auth::id())))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('admin.settings') }}">Control Panel</a></li>
                                    <li>
                                        <a href="{{ route('admin.roster') }}">
                                            Roster
                                            @if ($applications)
                                                <span class="badge">{{ $applications }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li><a href="{{ route('admin.events') }}">Events</a></li>
                                    @if (Route::is('page'))
                                        <li><a href="{{ route('page.edit', ['page' => Request::route('page')]) }}">Edit Page</a></li>
                                    @elseif (Route::is('home'))
                                        <li><a href="{{ route('home.edit') }}">Edit Page</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if (!Auth::check())
                            <li><a href="{{ route('signin') }}">Sign In</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>