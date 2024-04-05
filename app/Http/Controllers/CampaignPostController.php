<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;

use App\Campaign;
use App\Campaign_Post;
use Illuminate\Http\Request;

use Carbon\Carbon;

class CampaignPostController extends Controller
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
        $campaignPosts = Campaign_Post::select(['*'])
            ->where('campaign_id', '=', Session::get('active_campaign'))
            ->get();

        return view('CampaignPost.index', compact('campaignPosts', 'campaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign)
    {
        if (session()->get('user_id') == $campaign->user_id) {
            return view('campaignPost.create', compact('campaign'));
        } else {
            return redirect('/campaign/' . $campaign->campaign_id);
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Campaign $campaign)
    {
        if (session()->get('user_id') != $campaign->user_id) {
            return redirect('/campaign/' . $campaign->campaign_id);
        }
        //
        $this->validate(request(), [
            'campaign_post_title' => 'required|string|max:50',
            'campaign_post_content' => 'nullable|string|max:10000',
            'campaign_post_status' => 'required|numeric|min:0|max:1',
        ]);

        $campaign_post_id = campaign_post::insertGetId([
            'campaign_id' => $campaign->campaign_id,
            'campaign_post_title' => request('campaign_post_title'),
            'campaign_post_content' => request('campaign_post_content'),
            'campaign_post_status' => request('campaign_post_status'),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        return redirect('/campaign/' . $campaign->campaign_id . '/posts/' . $campaign_post_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign_Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign, Campaign_Post $post)
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
        return view('campaignPost.show', compact('campaign', 'post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign_Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, Campaign_Post $post)
    {
        if (session()->get('user_id') == $campaign->user_id) {
            return view('campaignPost.edit', compact('campaign', 'post'));
        } else {
            return redirect('/campaign/' . $campaign->campaign_id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign_Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign, Campaign_Post $post)
    {
        if (session()->get('user_id') != $campaign->user_id) {
            return redirect('/campaign/' . $campaign->campaign_id);
        }
        //
        $this->validate(request(), [
            'campaign_post_id' => 'required|exists:campaign_post,campaign_post_id',
            'campaign_post_title' => 'required|string|max:50',
            'campaign_post_content' => 'nullable|string|max:10000',
            'campaign_post_status' => 'required|numeric|min:0|max:1',
        ]);

        Campaign_Post::where('campaign_post_id', request('campaign_post_id'))->update([
            'campaign_post_title' => request('campaign_post_title'),
            'campaign_post_content' => request('campaign_post_content'),
            'campaign_post_status' => request('campaign_post_status'),
            "updated_at" => Carbon::now()
        ]);

        return redirect('/campaign/' . $post->campaign_id . '/posts/' . $post->campaign_post_id);
    }
}
