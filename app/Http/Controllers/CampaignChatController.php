<?php

namespace App\Http\Controllers;

use App\Campaign_Chat;
use App\Campaign_Message;
use App\Campaign;
use App\User;

use Session;
use Illuminate\Http\Request;

class CampaignChatController extends Controller
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
            Session::put('active_campaign_user', $campaign->user_id);
            if ($active_campaign != null) {
                Session::put('player_id', $active_campaign->player_id);
            }
        }

        //
        $chats = Campaign_Chat::select(['*'])
            ->where('campaign_id', '=', $campaign->campaign_id)
            ->get();

        return view('campaignChat.index', compact('campaign', 'chats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign)
    {
        if (session()->get('user_id') == $campaign->user_id) {
            return view('campaignChat.create', compact('campaign'));
        } else {
            return redirect('/campaign/' . $campaign->campaign_id);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Campaign $campaign)
    {
        //
        $this->validate(request(), [
            'campaign_chat_title' => 'required|string|max:75',
        ]);

        $campaign_chat_id = campaign_chat::insertGetId([
            'campaign_id' => $campaign->campaign_id,
            'campaign_chat_title' => request('campaign_chat_title'),
        ]);

        return redirect('/campaign/' . $campaign->campaign_id . '/chats/' . $campaign_chat_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign_Chat  $campaign_Chat
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign, Campaign_Chat $chat)
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
            Session::put('active_campaign_user', $campaign->user_id);
            if ($active_campaign != null) {
                Session::put('player_id', $active_campaign->player_id);
            }
        }

        //
        $campaign_owner = user::select(['*'])
            ->where('user_id', '=', $campaign->user_id)
            ->first();

        $campaign_messages = Campaign_Message::select(['campaign_message.*', 'player.*'])
            ->leftjoin('player', 'campaign_message.player_id', 'player.player_id')
            ->where('campaign_chat_id', '=', $chat->campaign_chat_id)
            ->get();

        return view('campaignChat.show', compact('campaign', 'chat', 'campaign_messages', 'campaign_owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign_Chat  $campaign_Chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, Campaign_Chat $campaign_Chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign_Chat  $campaign_Chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign, Campaign_Chat $campaign_Chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign_Chat  $campaign_Chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign_Chat $campaign_Chat)
    {
        //
    }
}
