<title>MythForge - Loot Group {{ $loot_group->loot_group_id }}</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            @if (count($loot_group_items) == 0)
                <br />
                <p class="text-center">Currently there are no items in this group!</p>
            @endif
            <div class="form-group text-center">
                <a class="btn btn-primary" href="/loot-groups/{{$loot_group->loot_group_id}}/items/add">Add New Item</a>
            </div>
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <td></td>
                        <th class="text-center">Loot Group ID</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Short Description</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center width-5"></td>
                        <td class="text-center width-10">{{ $loot_group->loot_group_id }}</td>
                        <td class="text-center width-25">{{ $loot_group->game_type_title }}</td>
                        <td class="text-center width-40">{{ $loot_group->loot_group_description }}</td>
                        <td class="text-center width-5"></td>
                    </tr>
                </table>
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <td></td>
                        <th class="text-center">Item Title</th>
                        <th class="text-center">Quantity</th>
                    </tr>
                    @foreach ($loot_group_items as $loot_group_item)
                        <tr>
                            <td class="text-center width-15"></td>
                            <td class="text-center width-30">{{ $loot_group_item->item_title }}</td>
                            <td class="text-center width-25">{{ $loot_group_item->loot_group_item_quantity }}</td>
                            <td class="text-center width-5"><a class="btn btn-primary"
                                    href="/loot-groups/{{ $loot_group->loot_group_id }}/items/{{ $loot_group_item->loot_group_item_id }}/edit">Edit</a>
                            </td>
                            <td class="text-center width-5">
                                <form action="/loot-group/{{$loot_group->loot_group_id}}/remove" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="loot_group_item_id" value="{{ $loot_group_item->loot_group_item_id }}" />

                                    <button type="submit" class="btn btn-danger">
                                        Remove
                                    </button>
                                </form>
                            </td>
                            <td class="text-center width-15"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
