<title>Campaign Manager - Show Item - {{ $item->item_title }}</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">

        <div class="content width-100">
            <div>
                <div class="title m-b-md">
                    <div>
                        <p>{{ $item->item_title }}</p>
                    </div>
                </div>

                <div class="center width-60">
                    <div class="width-100">
                        <h3>Genre Title</h3>
                        <input class="width-100 center" id="item_game_type" type="text" readonly="true" name="item_game_type"
                            value="{{ $item_game_type->game_type_title }}" />
                    </div>
                </div>

                @if (session('user_id') == $item->user_id)
                    <div class="center width-60">
                        <div class="width-100">
                            <h3>Item Status</h3>
                            @if ($item->item_status == 1)
                                <input class="width-100 center" id="item_status" type="text" readonly="true"
                                    name="item_status" value="Public" />
                            @else
                            <input class="width-100 center" id="item_status" type="text" readonly="true"
                                name="item_status" value="Private" />
                            @endif
                        </div>
                    </div>
                @endif

                <div class="center p-b-sm width-60">
                    <div class="width-100">
                        <h3>Description</h3>
                        <textarea rows="15" id="campaign_description" type="text" class="width-100" readonly="true" maxlength="10000"
                            name="campaign_description">{{ $item->item_description }}</textarea>
                    </div>
                </div>

                <div class="center width-60">
                    @if (Session::has('active_user'))
                        @if (Session::get('user_id') == $item->user_id)
                            <a class="btn btn-primary" href="edit/{{ $item->item_id }}">Edit</a>
                        @else
                            @if (sizeof($subscribed) == 1)
                                <form action="{{ route('unsubscribe') }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="item_id" value="{{ $item->item_id }}" />

                                    <button type="submit" class="btn btn-primary">
                                        Unsubscribe
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('subscribe') }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="item_id" value="{{ $item->item_id }}" />

                                    <button type="submit" class="btn btn-primary">
                                        Subscribe
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
