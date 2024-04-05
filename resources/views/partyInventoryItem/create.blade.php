<title>MythForge - Add Item to Inventory</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            @if (count($items) == 0)
                <br />
                <p class="text-center">Currently there are no items!</p>
            @endif
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center">Item ID</th>
                        <th class="text-center">Creator</th>
                        <th class="text-center">Item Title</th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center width-10">{{ $item->item_id }}</td>
                            <td class="text-center width-10">{{ $item->user_name }}</td>
                            <td class="text-center width-40">{{ $item->item_title }}</td>

                            <td class="text-center width-15">
                                <form method="POST"
                                    action="/campaign/{{ $campaign->campaign_id }}/party-inventory/{{ $party_inventory->party_inventory_id }}/store">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="item_id" value="{{ $item->item_id }}" />
                                    <input type="hidden" name="party_inventory_id"
                                        value="{{ $party_inventory->party_inventory_id }}" />
                                    <div class="inline-float width-50">
                                        <input id="party_inventory_item_quantity" type="number" min="1"
                                            class="form-control" name="party_inventory_item_quantity"value="1" required>
                                    </div>
                                    <div class="inline-float">
                                        <button type="submit" class="btn btn-primary">
                                            Add
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/items/{{ $item->item_id }}">View</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
