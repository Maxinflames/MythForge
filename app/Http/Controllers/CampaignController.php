<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Game_Type;
use App\Party_Inventory;

use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        //
        $openCampaigns = campaign::select([
            'campaign.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from player where player.campaign_id = campaign.campaign_id) as player_count')
        ])
            ->join('game_type', 'campaign.game_type_id', 'game_type.game_type_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->groupBy('campaign.campaign_id')
            ->orderBy('campaign.campaign_id')
            ->get();

        return view('campaign.index', compact('openCampaigns'));
    }


    public function campaignsById()
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $myCampaigns = campaign::select([
            'campaign.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from player where player.campaign_id = campaign.campaign_id) as player_count')
        ])
            ->join('game_type', 'campaign.game_type_id', 'game_type.game_type_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->where('player.user_id', '=', Session::get('user_id'))
            ->orWhere('campaign.user_id', '=', Session::get('user_id'))
            ->groupBy('campaign.campaign_id')
            ->orderBy('campaign.campaign_id')
            ->get();

        return view('campaign.myCampaigns', compact('myCampaigns'));
    }

    public function campaignSearch(Request $request)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $text = request('search_text');

        $myCampaignSearch = campaign::select([
            'campaign.campaign_id',
        ])
            ->join('game_type', 'campaign.game_type_id', 'game_type.game_type_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->where('user.user_name', 'like', '%' . $text . '%')
            ->orwhere('campaign.campaign_title', 'like', '%' . $text . '%')
            ->orwhere('campaign.campaign_id', 'like', '%' . $text . '%')
            ->orwhere('game_type.game_type_title', 'like', '%' . $text . '%')
            ->get();

        $openCampaigns = campaign::select([
            'campaign.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from player where player.campaign_id = campaign.campaign_id) as player_count')
        ])
            ->join('game_type', 'campaign.game_type_id', 'game_type.game_type_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->whereIn('campaign.campaign_id', $myCampaignSearch)
            ->groupBy('campaign.campaign_id')
            ->orderBy('campaign.campaign_id')
            ->get();

        return view('campaign.index', compact('openCampaigns'));
    }

    public function campaignSearchById(Request $request)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $text = request('search_text');

        $myCampaignGroups = campaign::select([
            'campaign.campaign_id',
        ])
            ->join('game_type', 'campaign.game_type_id', 'game_type.game_type_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->where('player.user_id', '=', Session::get('user_id'))
            ->orWhere('campaign.user_id', '=', Session::get('user_id'))
            ->groupBy('campaign.campaign_id')
            ->orderBy('campaign.campaign_id')
            ->get();

        $myCampaignSearch = campaign::select([
            'campaign.campaign_id',
        ])
            ->join('game_type', 'campaign.game_type_id', 'game_type.game_type_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->where('user.user_name', 'like', '%' . $text . '%')
            ->orwhere('campaign.campaign_title', 'like', '%' . $text . '%')
            ->orwhere('campaign.campaign_id', 'like', '%' . $text . '%')
            ->orwhere('game_type.game_type_title', 'like', '%' . $text . '%')
            ->get();

        $myCampaigns = campaign::select([
            'campaign.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from player where player.campaign_id = campaign.campaign_id) as player_count')
        ])
            ->join('game_type', 'campaign.game_type_id', 'game_type.game_type_id')
            ->join('user', 'campaign.user_id', 'user.user_id')
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->whereIn('campaign.campaign_id', $myCampaignGroups)
            ->whereIn('campaign.campaign_id', $myCampaignSearch)
            ->groupBy('campaign.campaign_id')
            ->orderBy('campaign.campaign_id')
            ->get();

        return view('campaign.myCampaigns', compact('myCampaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $game_types = game_type::select(['*'])->get();

        return view('campaign.create', compact('game_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'campaign_title' => 'required|string|max:50',
            'campaign_description' => 'nullable|string|max:10000',
            'game_type_id' => 'required|exists:game_type,game_type_id',
            'campaign_player_limit' => 'required|numeric|min:1|max:20',
        ]);

        $campaign_id = Campaign::insertGetId([
            'user_id' => session()->get('user_id'),
            'game_type_id' => request('game_type_id'),
            'campaign_title' => request('campaign_title'),
            'campaign_description' => request('campaign_description'),
            'campaign_player_limit' => request('campaign_player_limit'),
        ]);

        Party_Inventory::create([
            'campaign_id' => $campaign_id,
        ]);

        return redirect('/my-campaigns');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        $active_campaign = campaign::select(['player.player_id'])
            ->leftJoin('player', 'campaign.campaign_id', 'player.campaign_id')
            ->where('player.user_id', '=', Session::get('user_id'))
            ->where('campaign.campaign_id', '=', $campaign->campaign_id)
            ->groupBy('campaign.campaign_id')
            ->first();

        if ($active_campaign == null && session()->get('user_id') != $campaign->user_id) {
            session()->forget('active_campaign');
            session()->forget('player_id');
        } else {
            Session::put('active_campaign', $campaign->campaign_id);
            Session::put('active_campaign_user', $campaign->user_id);
            if ($active_campaign != null) {
                Session::put('player_id', $active_campaign->player_id);
            }
        }

        return view('campaign.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        if (Session::get('user_id') != $campaign->user_id) {
            return redirect('/campaign/' + $campaign->campaign_id);
        } else {
            session()->put('active_campaign', $campaign->campaign_id);
            session()->put('active_campaign_owner', $campaign->user_id);
        }

        $game_types = game_type::select(['*'])
            ->get();

        return view('campaign.edit', compact('campaign', 'game_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $this->validate(request(), [
            'campaign_id' => 'required|exists:campaign,campaign_id',
            'campaign_title' => 'required|string|max:50',
            'campaign_description' => 'nullable|string|max:10000',
            'game_type_id' => 'required|exists:game_type,game_type_id',
            'campaign_player_limit' => 'required|numeric|min:1|max:20',
        ]);

        campaign::where('campaign_id', request('campaign_id'))->update([
            'campaign_title' => request('campaign_title'),
            'campaign_description' => request('campaign_description'),
            'game_type_id' => request('game_type_id'),
            'campaign_player_limit' => request('campaign_player_limit'),
        ]);

        return redirect('/campaign/' . $campaign->campaign_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
