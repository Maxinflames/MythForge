<title>MythForge - Items</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center">Item ID</th>
                        <th class="text-center">Creator</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Item Title</th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center width-10">{{ $item->item_id }}</td>
                            <td class="text-center width-10">{{ $item->user_name }}</td>
                            <td class="text-center width-25">{{ $item->game_type_title }}</td>
                            <td class="text-center">{{ $item->item_title }}</td>
                            <td class="text-center width-220px">
                                <form method="POST" action="/loot-groups/{{ $loot_group->loot_group_id }}/items/store">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="item_id" value="{{ $item->item_id }}" />
                                    <input type="hidden" name="loot_group_id" value="{{ $loot_group->loot_group_id }}" />
                                    <div class="inline-float width-135px">
                                        <input id="loot_group_item_quantity" type="number" min="1"
                                            class="form-control" name="loot_group_item_quantity"value="1" required>
                                    </div>
                                    <div class="inline-float">
                                        <button type="submit" class="btn btn-primary">
                                            Add
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @if (count($items) == 0)
                    <p class="text-center">Currently there are no items!</p>
                    <br />
                @endif
            </div>
        </div>
    </div>
@endsection
