<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Campaign_Chat;
use App\Campaign_Message;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Campaign $campaign, Campaign_Chat $chat)
    {

        //
        $this->validate(request(), [
            'player_id' => 'nullable|exists:player,player_id',
            'campaign_message_content' => 'required|string|min:1|max:255',
        ]);

        if (request('player_id') != null) {
            campaign_message::create([
                'campaign_chat_id' => $chat->campaign_chat_id,
                'player_id' => request('player_id'),
                'campaign_message_content' => request('campaign_message_content'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        else{
            campaign_message::create([
                'campaign_chat_id' => $chat->campaign_chat_id,
                'campaign_message_content' => request('campaign_message_content'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return redirect('/campaign/' . $campaign->campaign_id . '/chats/' . $chat->campaign_chat_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign_Message  $campaign_Message
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign_Message $campaign_Message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign_Message  $campaign_Message
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign_Message $campaign_Message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign_Message  $campaign_Message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign_Message $campaign_Message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign_Message  $campaign_Message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign_Message $campaign_Message)
    {
        //
    }
}
