<title>MythForge - Items</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            <div class="width-60 margin-center">
                <div><b>Number of Dice</b> - The number of 'dice' that are rolled.
                </div>
                <div><b>Dice Value</b> - The number of sides on a dice for the 'dice roll'. Minimum of 1. Between 1 and the
                    chosen number
                    of items will be added.
                </div>
                <div><b>Quantity</b> - Adds this many items to the group, multiplied by the value rolled by Dice Value.
                </div>
                <div><b>Drop Chance (Weight)</b> - The chance of the item being chosen from the table. Chosen by adding the
                    weight values
                    together, then rolling to determine.</div>
                <br>
            </div>
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center width-10">Item ID</th>
                        <th class="text-center width-10">Creator</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Item Title</th>
                        <td class="width-270px"></td>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center">{{ $item->item_id }}</td>
                            <td class="text-center">{{ $item->user_name }}</td>
                            <td class="text-center">{{ $item->game_type_title }}</td>
                            <td class="text-center">{{ $item->item_title }}</td>
                            <td class="text-center center">
                                <form method="POST" action="/loot-tables/{{ $loot_table->loot_table_id }}/items/store">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="item_id" value="{{ $item->item_id }}" />
                                    <input type="hidden" name="loot_table_id" value="{{ $loot_table->loot_table_id }}" />

                                    <div class="inline-float width-135px">
                                        <label for="loot_table_item_dice_count">Number of Dice</label>
                                        <input id="loot_table_item_dice_count" type="number" min="1"
                                            class="form-control" name="loot_table_item_dice_count" value="1" required>
                                    </div>

                                    <div class="inline-float width-135px">
                                        <label for="loot_table_item_roll">Dice Value</label>
                                        <input id="loot_table_item_roll" type="number" min="1" class="form-control"
                                            name="loot_table_item_roll" value="1" required>
                                    </div>

                                    <div class="inline-float width-135px">
                                        <label for="loot_table_item_weight">Drop Chance</label>
                                        <input id="loot_table_item_weight" type="number" min="1"
                                            class="form-control" name="loot_table_item_weight" value="1" required>
                                    </div>

                                    <div class="inline-float width-135px">
                                        <label for="loot_table_item_count">Quantity</label>
                                        <input id="loot_table_item_count" type="number" min="1" class="form-control"
                                            name="loot_table_item_count" value="1" required>
                                    </div>

                                    <div class="inline-float width-270px center">
                                        <div class="margin-top-20px">
                                            <button type="submit" class="btn btn-primary">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @if (count($items) == 0)
                    <p class="text-center">Currently there are no items!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
