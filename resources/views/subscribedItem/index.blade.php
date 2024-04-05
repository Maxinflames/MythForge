<title>MythForge - Subscribed Items</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="text-end center">
                <form method="POST" action="/subscribed-items">
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
                        <th class="text-center width-10">Item ID</th>
                        <th class="text-center width-10">Creator</th>
                        <th class="text-center width-25">Game Type</th>
                        <th class="text-center width-40">Item Title</th>
                        <th class="text-center width-10">Subscriptions</th>
                        <th class="text-center width-5"></th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($subscribed_items as $item)
                        <tr>
                            <td class="text-center">{{ $item->item_id }}</td>
                            <td class="text-center">{{ $item->user_name }}</td>
                            <td class="text-center">{{ $item->game_type_title }}</td>
                            <td class="text-center">{{ $item->item_title }}</td>
                            <td class="text-center">{{ $item->subscriptions }}</td>
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/items/{{ $item->item_id }}">View</a></td>
                        </tr>
                    @endforeach
                </table>
                <!-- Checks if there are any posts to display, if not, notifies the user -->
                @if (count($subscribed_items) == 0)
                    <br />
                    <p class="text-center">Currently there are no subscribed items!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
