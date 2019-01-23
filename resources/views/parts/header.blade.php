<nav class="navbar navbar-expand-md navbar-dark bg-dark w-100">
    <div class="row w-100">
        <div class="col-sm-4">
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ route('index') }}"><img src="{{asset('images/interface/logo/main_logo.svg')}}" height="25px"/></a>
        </div>
        <div class="col-sm-4">
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item @if(Route::currentRouteName() == 'ideas.index') active @endif">
                        <a class="nav-link" href="{{route('ideas.index')}}">{{__('menu.ideas')}}</a>
                    </li>
                    <li class="nav-item @if(Route::currentRouteName() == 'actions.index') active @endif">
                        <a class="nav-link" href="{{route('actions.index')}}">{{__('menu.actions')}}</a>
                    </li>
                    <li class="nav-item @if(Route::currentRouteName() == 'checkpoints.index') active @endif">
                        <a class="nav-link" href="#contact">{{__('menu.checkpoints')}}</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="col-sm-4">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav float-right">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="dropdown-item" href="#"
                            >Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

</nav>