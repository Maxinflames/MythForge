<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class="bg-dark">
        <nav class="navbar navbar-default navbar-static-top bg-dark">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <b>MythForge</b>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Session::has('active_user'))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false">
                                    {{ Session()->get('first_name') . ' ' . Session()->get('last_name') }} <span
                                        class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('account') }}">
                                            Your Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <ul class="nav nav-pill sidebar fixed bg-dark">
            <li><a href="/open-campaigns" class="btn">View Open Campaigns</a></li>
            <li><a href="/items" class="btn">View Item List</a></li>
            @if (Session::has('active_user'))
                <hr class="width-75" />
                <li><a href="/my-campaigns" class="btn">View Your Campaigns</a></li>
                <li><a href="/subscribed-items" class="btn">View Subscribed Items</a></li>
                <li><a href="/my-items" class="btn">View Your Items</a></li>
                <li><a href="/items/create" class="btn">Create Items</a></li>
                <li><a href="/applications" class="btn">View Applications</a></li>
                <li><a href="/loot-groups" class="btn">View Your Loot Groups</a></li>
                <li><a href="/loot-tables" class="btn">View Your Loot Tables</a></li>
            @endif
        </ul>

        <ul class="nav nav-pill right-sidebar fixed bg-dark">
            @if (Session::has('active_user'))
                @if (Session::has('active_campaign'))
                    <li><a href="/campaign/{{ Session::get('active_campaign') }}" class="btn">Campaign Menu</a></li>
                    <li><a href="/campaign/{{ Session::get('active_campaign') }}/posts" class="btn">Lore Posts</a>
                    </li>
                    <li><a href="/campaign/{{ Session::get('active_campaign') }}/chats"
                            class="btn">Campaign Chats</a></li>
                    <li><a href="/campaign/{{ Session::get('active_campaign') }}/players" class="btn">View
                            Party List</a></li>
                    @if (Session::get('user_id') == Session::get('active_campaign_user'))
                        <li><a href="/campaign/{{ Session::get('active_campaign') }}/applications"
                                class="btn">Campaign Applications</a></li>
                    @endif
                    <hr class="width-75" />
                    <li><a href="/campaign/{{ Session::get('active_campaign') }}/party-inventory/{{ Session::get('active_campaign') }}" class="btn">Party
                            Inventory</a></li>
                    @if (Session::has('player_id'))
                        <li><a href="/campaign/{{ Session::get('active_campaign') }}/player-inventory/{{ Session()->get('player_id') }}"
                                class="btn">Personal Inventory</a></li>
                        <li><a href="/campaign/{{ Session::get('active_campaign') }}/players/{{ Session()->get('player_id') }}"
                                class="btn">Character Details</a></li>
                    @endif
                @endif
            @endif
        </ul>

        <table class="width-100">
            <tr>
                <td class="width-175px">

                </td>
                <td class="width-fill">
                    <div class="content-space bg-light">
                        <div class="center-block content-sizing">
                            @yield('content')
                        </div>
                    </div>
                </td>
                <td class="width-175px">
                </td>
            </tr>
        </table>


    </div>

    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
