<?php

namespace App\Http\Controllers;

use App\Player;
use App\Campaign;

use Illuminate\Http\Request;
use Session;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Campaign $campaign)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $active_campaign = campaign::select(['player.player_id'])
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->where('player.user_id', '=', Session::get('user_id'))
            ->where('campaign.campaign_id', '=', $campaign->campaign_id)
            ->groupBy('campaign.campaign_id')
            ->first();

        if ($active_campaign == null && session()->get('user_id') != $campaign->user_id) {
            return redirect('/campaign/' . $campaign->campaign_id);
        } else {
            Session::put('active_campaign', $campaign->campaign_id);
            if ($active_campaign != null) {
                Session::put('player_id', $active_campaign->player_id);
            }
        }

        //
        $players = Player::select(['player.*', 'user.user_name', 'player_inventory.player_inventory_id'])
            ->join('user', 'player.user_id', 'user.user_id')
            ->join('player_inventory', 'player.player_id', 'player_inventory.player_id')
            ->where('campaign_id', '=', Session::get('active_campaign'))
            ->get();

        return view('player.index', compact('players', 'campaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign, Player $player)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $active_campaign = campaign::select(['player.player_id'])
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->where('player.user_id', '=', Session::get('user_id'))
            ->where('campaign.campaign_id', '=', $campaign->campaign_id)
            ->groupBy('campaign.campaign_id')
            ->first();

        if ($active_campaign == null && session()->get('user_id') != $campaign->user_id) {
            return redirect('/campaign/' . $campaign->campaign_id);
        } else {
            Session::put('active_campaign', $campaign->campaign_id);
            if ($active_campaign != null) {
                Session::put('player_id', $active_campaign->player_id);
            }
        }

        //
        $player = Player::select(['player.*', 'user.user_name'])
            ->join('user', 'player.user_id', 'user.user_id')
            ->where('player.player_id', '=', $player->player_id)
            ->first();

        return view('player.show', compact('player', 'campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, Player $player)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $active_campaign = campaign::select(['player.player_id'])
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->where('player.user_id', '=', Session::get('user_id'))
            ->where('campaign.campaign_id', '=', $campaign->campaign_id)
            ->groupBy('campaign.campaign_id')
            ->first();

        if ($active_campaign == null && session()->get('user_id') != $campaign->user_id) {
            return redirect('/campaign/' . $campaign->campaign_id);
        } else {
            Session::put('active_campaign', $campaign->campaign_id);
            if ($active_campaign != null) {
                Session::put('player_id', $active_campaign->player_id);
            }
        }

        //
        $player = Player::select(['player.*', 'user.user_name'])
            ->join('user', 'player.user_id', 'user.user_id')
            ->where('player.player_id', '=', $player->player_id)
            ->first();

        return view('player.edit', compact('player', 'campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign, Player $player)
    {
        //
        $this->validate(request(), [
            'player_id' => 'required|exists:player,player_id',
            'player_profile_picture' => 'nullable|image',
            'player_character_name' => 'required|string|max:50',
        ]);

        if (request()->has('player_profile_picture')) {
            request('player_profile_picture')->storeAs('images/player', 'player_' . $player->player_id . '_profile.png', 'public');
            $profile_picture_name = 'player_' . $player->player_id . '_profile.png';

            Player::where('player_id', request('player_id'))->update([
                'player_profile_picture' => $profile_picture_name,
                'player_character_name' => request('player_character_name'),
            ]);
        }
        else {
            Player::where('player_id', request('player_id'))->update([
                'player_character_name' => request('player_character_name'),
            ]);
        }

        return redirect('/campaign/' . $campaign->campaign_id . '/players/' . $player->player_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //
    }
}
