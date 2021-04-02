<!-- Detect language selected -->
<?php
    $url = $_SERVER['REQUEST_URI'];
    $urlParts = explode ('/', $url);
    $language = $urlParts[2] ;
?>

<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="row">
            {{-- <ul class="nav nav-pills pull-right">
                <li @if ($language == "gr") class="active"  @endif><a href="{{ url('/setlang/gr') }}">Ελληνικά</a></li>
                <li @if ($language == "en") class="active"  @endif><a href="{{ url('/setlang/en') }}">English</a></li>
            </ul> --}}

            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        @if ($language == "gr") Ελληνικά  @endif
                        @if ($language == "en") English @endif
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="{{ url('/setlang/gr') }}">Ελληνικά</a></li>
                        <li><a href="{{ url('/setlang/en') }}">English</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
