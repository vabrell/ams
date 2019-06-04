<div class="collapse navbar-collapse" id="navbarSupportedContent">
    @auth
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

            @if (auth()->user()->isServicedesk())
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('Hantera konton') }}</a>
                </li>
            @endif

            @if (auth()->user()->isHR())
                <li class="nav-item">
                <a class="nav-link" href="{{ route('neptune.index') }}">{{ __('Neptune') }}</a>
                </li>
            @endif

            @if (auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('Inställningar') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('Loggar') }}</a>
                </li>
            @endif
        </ul>
    @endauth

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logga ut') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
