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
    <div class="width-50 center">
        <p> Thank you so much for looking at and using my site! </p>
        <p> If you have any further suggestions or questions, feel free
            to email at MaximusVan2@hotmail.com.
        </p>
        <p>Otherwise, please view our <a href="/future-goals">Future Goals</a> for this project.
        </p>
        <p>If you are interested in leaving a review for the Expo, scan the QR coded below here!
        </p>
    </div>
    <div class="content">
        <div>
            <image class="width-20" src="{{ Storage::url('/images/general/Expo_QR_Code.png') }}"
                alt="MythForge Banner Logo">
        </div>
    </div>
@endsection
