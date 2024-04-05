<title>Campaign Manager - Campaign Chat - {{ $chat->campaign_chat_title }}</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="panel panel-default width-100">
            <div>
                <h4 class="text-center panel-heading">{{ $chat->campaign_chat_title }}</h4>
            </div>
            <div class="content message-space">

                @if (count($campaign_messages) == 0)
                    <br />
                    <p class="text-center">Currently there are no messages, be the first to say "hi"!</p>
                @endif

                <table class="table ">
                    <!-- loop through database data and display for each entry -->
                    @foreach ($campaign_messages as $message)
                        <tr>
                            @if ($message->player_id != null)
                                <td class="text-center message-row-height width-5" rowspan="2">
                                    <img class="avatar-sm img-rounded" id="player_profile_picture"
                                        src="{{ Storage::url('/images/player/' . $message->player_profile_picture) }}"
                                        alt="Avatar">
                                </td>
                                <td class="text-center message-row-height message-alignment">
                                    <p class="message-space message-sender-style">{{ $message->player_character_name }}</p>
                                    <p class="message-date-style">{{ $message->updated_at }}</p>
                                </td>
                            @else
                                <td class="text-center message-row-height width-5" rowspan="2">
                                    <img class="avatar-sm img-rounded" id="player_profile_picture"
                                        src="{{ Storage::url('/images/player/' . $campaign_owner->user_profile_picture) }}"
                                        alt="Avatar">
                                </td>
                                <td class="text-center message-row-height message-alignment">
                                    <p class="message-space message-sender-style">{{ $campaign_owner->user_name }}
                                        (Gamemaster)
                                    </p>
                                    <p class="message-date-style">{{ $message->updated_at }}</p>
                                </td>
                            @endif
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>{{ $message->campaign_message_content }}</p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        @if ($errors->has('player_id'))
            <span class="help-block">
                <strong>{{ $errors->first('player_id') }}</strong>
            </span>
        @endif

        @if ($errors->has('campaign_message_content'))
            <span class="help-block">
                <strong>{{ $errors->first('campaign_message_content') }}</strong>
            </span>
        @endif

        <div class="message-box">
            <form method="POST" action="/campaign/{{ $campaign->campaign_id }}/chats/{{ $chat->campaign_chat_id }}/send">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="player_id" value="{{ Session::get('player_id') }}" />

                <table class="width-95 message-margins">
                    <tr>
                        <td class="center message-space">
                            <input id="campaign_message_content" autocomplete="off" type="text" class="form-control"
                                name="campaign_message_content" placeholder="Type your message here..." />
                        </td>
                        <td class="width-5 center">
                            <button type="submit" class="btn btn-primary">
                                Send
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    </div>

    <script type="text/javascript">
        setTimeout(() => {
            window.scrollTo(0, document.body.scrollHeight);
        }, 100);
    </script>
@endsection
