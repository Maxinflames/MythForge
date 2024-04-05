<title>Campaign Manager - Main Menu</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            @if (session()->has('active_user'))
                <div class="form-group text-center">
                    <a class="btn btn-primary" href="/campaign/create">Create New Campaign</a>
                </div>
            @endif
            <div class="text-end center">
                <form method="POST" action="/my-campaigns">
                    {{ csrf_field() }}
                    @if (Session::has('search_error'))
                        <label for="id">{{ Session::pull('search_error') }}</label>
                    @endif
                    <input id="search_text" name="search_text" class="width-25" placeholder="Search Here..." type="text" />
                    <button class="btn btn-secondary">Search</button>
                </form>
            </div>
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center">Campaign ID</th>
                        <th class="text-center">Owner</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Campaign Title</th>
                        <th class="text-center">Player Limit</th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($myCampaigns as $campaign)
                        <tr>
                            <td class="text-center width-10">{{ $campaign->campaign_id }}</td>
                            <td class="text-center width-10">{{ $campaign->user_name }}</td>
                            <td class="text-center width-25">{{ $campaign->game_type_title }}</td>
                            <td class="text-center width-40">{{ $campaign->campaign_title }}</td>
                            <td class="text-center width-10">
                                {{ $campaign->player_count }}/{{ $campaign->campaign_player_limit }}</td>
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/campaign/{{ $campaign->campaign_id }}">View</a></td>
                            <td class="text-center width-5"></td>
                        </tr>
                    @endforeach
                </table>
                <!-- Checks if there are any posts to display, if not, notifies the user -->
                @if (count($myCampaigns) == 0)
                    <br />
                    <p class="text-center">Currently there are no open games!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
