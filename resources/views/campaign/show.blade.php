<title>Campaign Manager - {{ $campaign->campaign_title }}</title>
@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title m-b-md">
            <div>
                {{ $campaign->campaign_title }}
            </div>
        </div>

        <div class="center partial-height width-60">
            <div class="">
                <p> {{ $campaign->campaign_description }}</p>
            </div>
        </div>


        <div class="center">
            @if (!Session::has('active_campaign'))
                <a class="btn btn-primary" href="/applications/create/{{ $campaign->campaign_id }}">Apply to Join</a>
            @endif
            @if (session()->get('user_id') == $campaign->user_id)
                <a class="btn btn-primary" href="/campaign/edit/{{ $campaign->campaign_id }}">Edit</a>
            @endif
        </div>
    </div>
@endsection
