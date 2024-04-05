<title>MythForge - Player Inventory</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="form-group text-center">
                <h2>{{$player->player_character_name}}'s Inventory</h2>
            </div>

            @if (Session::get('user_id') == $campaign->user_id)
                <div class="center ">
                    <a class="btn btn-primary"
                        href="/campaign/{{ $campaign->campaign_id }}/player-inventory/{{ $player_inventory->player_inventory_id }}/add">Add
                        Items</a>
                    <a class="btn btn-primary"
                        href="/campaign/{{ $campaign->campaign_id }}/player-inventory/{{ $player_inventory->player_inventory_id }}/loot-group">Add
                        Loot Group</a>
                    <br />
                </div>
            @endif

            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <td class="text-center width-5"></td>
                        <th class="text-center">Item ID</th>
                        <th class="text-center">Item Title</th>
                        <th class="text-center">Quantity</th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center width-5"></td>
                            <td class="text-center width-10">{{ $item->item_id }}</td>
                            <td class="text-center width-40">{{ $item->item_title }}</td>
                            <td class="text-center">{{ $item->player_inventory_item_quantity }}</td>
                            <td>
                                <form method="POST"
                                    action="/campaign/{{ $campaign->campaign_id }}/player-inventory/{{ $player_inventory->player_inventory_id }}/send">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="item_id" value="{{ $item->item_id }}" />
                                    <input type="hidden" name="player_inventory_id"
                                        value="{{ $player_inventory->player_inventory_id }}" />
                                    <div class="inline-float width-135px">
                                        <input id="player_inventory_item_quantity" type="number" min="1"
                                            class="form-control" name="player_inventory_item_quantity"value="1" required>
                                    </div>
                                    <div class="inline-float width-135px">
                                        <select name="inventory_id" id="inventory_id" class="form-control">
                                            <option value="party,{{ $party_inventory_id->party_inventory_id }}">
                                                Party</option>
                                            @foreach ($players as $player)
                                                @if ($player->player_inventory_id != $player_inventory->player_inventory_id)
                                                    <option value="player,{{ $player->player_inventory_id }}">
                                                        {{ $player->player_character_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="inline-float">
                                        <button type="submit" class="btn btn-primary">
                                            Send
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/items/{{ $item->item_id }}">View</a></td>
                        </tr>
                    @endforeach
                </table>
                <!-- Checks if there are any posts to display, if not, notifies the user -->
                @if (count($items) == 0)
                    <div>
                        <p class="text-center">Currently there are no items!</p>
                        <br />
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
