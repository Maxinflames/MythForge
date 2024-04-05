<title>Campaign Manager - Main Menu</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            @if (count($chats) == 0)
                <br />
                <p class="text-center">Currently there are no chats!</p>
            @endif
            @if (Session::get('user_id') == $campaign->user_id)
                <div class="form-group text-center">
                    <a class="btn btn-primary" href="/campaign/{{ $campaign->campaign_id }}/chats/create">Create New Chat</a>
                </div>
            @endif
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- loop through database data and display for each entry -->
                    @foreach ($chats as $chat)
                        <tr>
                            <td class="width-5"></td>
                            <th class="text-center">
                                <h4><a class="width-90"
                                        href="/campaign/{{ $campaign->campaign_id }}/chats/{{ $chat->campaign_chat_id }}">{{ $chat->campaign_chat_title }}
                                    </a>
                                </h4>
                            </th>
                            <td class="width-5"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
