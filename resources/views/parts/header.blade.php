<nav class="navbar navbar-expand-md shadow-sm navbar-dark bg-dark w-100 @if(isset($fixed) && $fixed) fixed-top @endif">
    <div class="row w-100">
        <div class="col-sm-4">
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{asset('images/interface/logo/main_logo.svg')}}" height="30px"/></a>
        </div>
        <div class="col-sm-4">
            @hasrole('super-admin')
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item @if(Route::currentRouteName() == 'ideas.index') active @endif">
                        <a class="nav-link text-first-uppercase" href="{{route('ideas.index') . MainFilter::queryString()}}">{{__('idea.title')}}</a>
                    </li>
                    @auth
                        @can('view places')
                    <li class="nav-item @if(Route::currentRouteName() == 'places.index') active @endif">
                        <a class="nav-link text-first-uppercase" href="{{route('places.index') . MainFilter::queryString()}}">{{__('place.title')}}</a>
                    </li>
                        @endcan
                    @endauth
                </ul>
            </div>
            @endhasrole
        </div>
        <div class="col-sm-4">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav float-right">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{__('auth.login')}}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{__('auth.register')}}</a></li>
                @else
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                            <a href="{{ route('profile.edit', Auth()->User()) }}" class="dropdown-item profile text-first-uppercase" >{{__('profile.title')}}</a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="dropdown-item text-first-uppercase" >{{__('auth.logout')}}</a>
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