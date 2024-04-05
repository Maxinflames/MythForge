<title>MythForge - Players</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            @if (count($players) == 0)
                <br />
                <p class="text-center">Currently there are no players!</p>
            @endif
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center">Character Picture</th>
                        <th class="text-center">User Name</th>
                        <th class="text-center">Character Name</th>
                        @if (Session::get('user_id') == $campaign->user_id)
                            <th class="text-center">Inventory Link</th>
                        @endif
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($players as $player)
                        <tr>
                            <td class="text-center width-25">
                                <img class="avatar img-rounded" id="user_profile"
                                    src="{{ Storage::url('/images/player/' . $player->player_profile_picture) }}"
                                    alt="Avatar">
                            </td>
                            <td class="text-center">{{ $player->user_name }}</td>
                            <td class="text-center">{{ $player->player_character_name }}</td>
                            @if (Session::get('user_id') == $campaign->user_id)
                                <td class="text-center width-5"><a class="btn btn-secondary"
                                        href="/campaign/{{ $campaign->campaign_id }}/player-inventory/{{ $player->player_inventory_id }}">View Inventory</a>
                                </td>
                            @endif
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/campaign/{{ $campaign->campaign_id }}/players/{{ $player->player_id }}">View Profile</a>
                            </td>
                            <td class="text-center width-5"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
