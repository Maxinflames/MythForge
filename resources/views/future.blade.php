<title>MythForge - Main Menu</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">

        <div class="content">
            <div>
                <image class="width-60" src="{{ Storage::url('/images/general/mythforge_logo.png') }}"
                    alt="MythForge Banner Logo">
            </div>
        </div>
    </div>
    <div class="width-50 margin-center">
        Future Goals:
        <ul>
            <li>Add table 'Collections' - A collection of items that allows other users to subscribe to all with one
                click.
                Can include items user created personally, or items user is subscribed to.</li>
            <li>Create an Admin Screen - Access to adding new game types, and going past all route restrictions</li>
            <li>Add JavaScript/AJAX
                <ul>
                    <li>Ideally, eliminate the majority of redirects and replace with reloads</li>
                    <li>Allow post pages to be refreshed on changes</li>
                    <li>Create live search bars, potentially replacing dropdown menus</li>
                    <li>Enable more security</li>
                    <li>Enforce page refreshes when going back on browser</li>
                </ul>
            </li>
            <li>Fix aspect ratio issues</li>
        </ul>

        <p class="center">Click <a href="/">Here</a> to return to the Main Menu.</p>
    </div>
@endsection
