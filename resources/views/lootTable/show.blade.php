<title>MythForge - Loot Table {{ $loot_table->loot_table_id }}</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <td></td>
                        <th class="text-center">Loot Table ID</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Short Description</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center width-5"></td>
                        <td class="text-center width-10">{{ $loot_table->loot_table_id }}</td>
                        <td class="text-center width-25">{{ $loot_table->game_type_title }}</td>
                        <td class="text-center width-40">{{ $loot_table->loot_table_description }}</td>
                        <td class="text-center width-5"><a class="btn btn-secondary"
                                href="/loot-tables/{{ $loot_table->loot_table_id }}/edit">Edit</a></td>
                    </tr>
                </table>
                <div class="form-group text-center">
                    <a class="btn btn-primary" href="/loot-tables/{{ $loot_table->loot_table_id }}/items/add">Add New
                        Item</a>
                </div>
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <td class="width-5"></td>
                        <th class="text-center width-25">Item Title</th>
                        <th class="text-center width-10">Number of Dice</th>
                        <th class="text-center width-10">Drop Count</th>
                        <th class="text-center width-10">Quantity</th>
                        <th class="text-center width-10">Drop Chance</th>
                        <th class="width-5"></th>
                        <th class="width-5"></th>
                        <th class="width-5"></th>
                    </tr>
                    @foreach ($loot_table_items as $loot_table_item)
                        <tr>
                            <td></td>
                            <td class="text-center"><a
                                    href="/items/{{ $loot_table_item->item_id }}">{{ $loot_table_item->item_title }}</a>
                            </td>
                            <td class="text-center">{{ $loot_table_item->loot_table_item_dice_count }}</td>
                            <td class="text-center">{{ $loot_table_item->loot_table_item_roll }}</td>
                            <td class="text-center">{{ $loot_table_item->loot_table_item_count }}</td>
                            <td class="text-center">{{ $loot_table_item->loot_table_item_weight }}</td>
                            <td class="text-center"><a class="btn btn-primary"
                                    href="/loot-tables/{{ $loot_table->loot_table_id }}/items/{{ $loot_table_item->loot_table_item_id }}/edit">Edit</a>
                            </td>
                            <td class="text-center">
                                <form
                                    action="/loot-tables/{{ $loot_table->loot_table_id }}/items/{{ $loot_table_item->loot_table_item_id }}/remove"
                                    method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="loot_table_item_id"
                                        value="{{ $loot_table_item->loot_table_item_id }}" />

                                    <button type="submit" class="btn btn-danger">
                                        Remove
                                    </button>
                                </form>
                            </td>
                            <td class="text-center"></td>
                        </tr>
                    @endforeach
                </table>
                @if (count($loot_table_items) == 0)
                    <br />
                    <p class="text-center">Currently there are no items in this group!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
