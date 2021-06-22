
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'CyberSafety') }}
            </a>
        </div>

        @if(Auth::check())

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <!-- <a href="/home"><i class="fa fa-home " aria-hidden="true"></i></a> -->
                    <a href="/home">
                        <i class="fa fa-file-text" aria-hidden="true"></i> Reports
                    </a>
                </li>

                @if (GroupPermission::usercan('view','users'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                        <i class="fa fa-users" aria-hidden="true"></i> Users
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <ul class="dropdown-menu">
                                <li>ds</li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/users')}}">Users</a></li>
                
                        @if(GroupPermission::usercan('view','roles'))
                        <li><a href="{{ url('/roles')}}">Roles</a></li>
                        @endif

                    </ul>
                </li>
                @endif

                @if(GroupPermission::usercan('view','content'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                        <i class="fa fa-cogs" aria-hidden="true"></i> Inputs 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/resourceType">Resource type</a></li>
                        <li><a href="/contentType">Content type</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/referenceBy">Reference by</a></li>
                        <li><a href="/referenceTo">Reference to</a></li>
                        {{--  <li role="separator" class="divider"></li>
                        <li><a href="{{ route('actions.index')}}">Actions</a></li>  --}}
                    </ul>
                </li>
                @endif

                @if(GroupPermission::usercan('view','statistics'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i> Statistics and Graphs 
                        <span class="caret"></span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('statistics.index') }}">Helpline and Hotline</a></li>
                        <li><a href="{{ route('show.fakenews.stats') }}">Fakenews</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('gen.charts.view') }}">Generate Graphs and Charts</a></li>
                    </ul>
                </li>
                @endif

                @if(GroupPermission::usercan('view','logs'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                        <i class="fa fa-history" aria-hidden="true"></i> Logs 
                        <span class="caret"></span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('helplinesLogController.index') }}">Helpline and Hotline</a></li>
                        <li><a href="">Fakenews</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="">Users</a></li>
                    </ul>
                </li>
                @endif
                
                @if(GroupPermission::usercan('view','settings'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                        <i class="fa fa-cog" aria-hidden="true"></i> Settings 
                        <span class="caret"></span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('settingsController.index') }}">Automated Archive</a></li>
                    </ul>
                </li>
                @endif

            </ul>

            @endif

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{route('profile.edit')}}">
                                    <i class="fa fa-user" aria-hidden="true"></i> User profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div> <!-- end .navbar-collapse -->
        
    </div> <!-- end .container -->
</nav>
