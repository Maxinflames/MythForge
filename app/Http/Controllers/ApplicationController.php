<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;

use App\Application;
use App\Campaign;
use App\Player;
use App\Player_Inventory;
use App\User;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Session::get('user_id') == null){
            return redirect('/');
        }
        //
        session()->forget('active_campaign');
        session()->forget('player_id');

        $applications = application::select(['application.*', 'campaign.campaign_title', 'user.user_name'])
            ->join('campaign', 'application.campaign_id', 'campaign.campaign_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->where('application.user_id', '=', Session::get('user_id'))
            ->get();

        return view('application.index', compact('applications'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function applicationById(Campaign $campaign)
    {
        if (session()->get('user_id') == $campaign->user_id) {
            $applications = application::select(['application.*', 'campaign.campaign_title', 'user.user_name'])
                ->join('campaign', 'application.campaign_id', 'campaign.campaign_id')
                ->join('user', 'application.user_id', 'user.user_id')
                ->where('application.campaign_id', '=', $campaign->campaign_id)
                ->get();

            return view('application.applicationById', compact('applications'));
        } else {
            return redirect('/campaign/' . $campaign->campaign_id);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign)
    {
        //
        session()->forget('active_campaign');
        session()->forget('player_id');

        return view('application.create', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(), [
            'user_id' => 'required|exists:user,user_id',
            'campaign_id' => 'required|exists:campaign,campaign_id',
            'application_message' => 'nullable|string|max:255',
        ]);

        if (request('application_message') != null) {
            Application::create([
                'campaign_id' => request('campaign_id'),
                'user_id' => session()->get('user_id'),
                'application_message' => request('application_message'),
            ]);
        }
        else{
            Application::create([
            'campaign_id' => request('campaign_id'),
            'user_id' => session()->get('user_id'),
            'application_message' => request('application_message'),
        ]);
        }

        return redirect('/applications');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $campaign = campaign::select(['*'])
            ->where('campaign.campaign_id', '=', $application->campaign_id)
            ->first();
        //
        if ($campaign->user_id != Session::get('user_id')) {
            if (Session::has('active_campaign')) {
                session()->forget('active_campaign');
            }
        }

        return view('application.show', compact('application', 'campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        if (Session::has('active_campaign')) {
            $campaign = Campaign::select(['*'])
                ->where('campaign_id', '=', $application->campaign_id)
                ->first();

            if (Session::get('user_id') != $campaign->user_id) {
                session()->forget('active_campaign');
            }
        }

        $campaign = campaign::select(['*'])
            ->where('campaign.campaign_id', '=', $application->campaign_id)
            ->first();
        //
        return view('application.edit', compact('application', 'campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(request(), [
            'application_id' => 'required|exists:application,application_id',
            'application_message' => 'nullable|string|max:255',
            'application_status' => 'nullable|numeric|min:0|max:1',
        ]);

        Application::where('application_id', request('application_id'))->update([
            'application_message' => request('application_message'),
            'application_status' => request('application_status')
        ]);

        if (request('application_status') == 1) {
            $application = application::select(['*'])
                ->where('application_id', '=', request('application_id'))
                ->first();

            $user = User::select(['*'])
                ->where('user_id', '=', $application->user_id)
                ->first();

            $player_id = Player::insertGetId([
                'campaign_id' => $application->campaign_id,
                'user_id' => $user->user_id,
                'player_character_name' => $user->user_name,
                'player_profile_picture' => $user->user_profile_picture,
            ]);

            Player_Inventory::create([
                'player_id' => $player_id,
            ]);
        }

        return redirect('/applications/edit/' . request('application_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
