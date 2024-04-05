<title>Campaign Manager - My Items</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            @if (session()->has('active_user'))
                <div class="form-group text-center">
                    <a class="btn btn-primary" href="/items/create">Create New Item</a>
                </div>
            @endif
            <div class="text-end center">
                <form method="POST" action="/my-items">
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
                        <th class="text-center">Item ID</th>
                        <th class="text-center">Creator</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Item Title</th>
                        <th class="text-center">Subscriptions</th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center width-10">{{ $item->item_id }}</td>
                            <td class="text-center width-10">{{ $item->user_name }}</td>
                            <td class="text-center width-25">{{ $item->game_type_title }}</td>
                            <td class="text-center width-40">{{ $item->item_title }}</td>
                            <td class="text-center width-10">{{ $item->subscriptions }}</td>
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/items/{{ $item->item_id }}">View</a></td>
                            <td class="text-center width-5"></td>
                        </tr>
                    @endforeach
                </table>
                <!-- Checks if there are any posts to display, if not, notifies the user -->
                @if (count($items) == 0)
                    <br />
                    <p class="text-center">Currently there are no items!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
