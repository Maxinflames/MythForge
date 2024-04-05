<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Loot_Group;
use App\Loot_Group_Item;

use App\Party_Inventory;
use App\Player_Inventory;
use Session;
use Illuminate\Http\Request;

class LootGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::get('user_id') == null) {
            return redirect('/');
        }
        //
        $loot_groups = Loot_Group::select(['loot_group.*', 'game_type.game_type_title'])
            ->leftjoin('loot_group_item', 'loot_group.loot_group_id', 'loot_group_item.loot_group_id')
            ->leftjoin('item', 'loot_group_item.item_id', 'item.item_id')
            ->leftjoin('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_group.user_id', '=', Session::get('user_id'))
            ->groupBy('loot_group.loot_group_id')
            ->get();

        return view('lootGroup.index', compact('loot_groups'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function partyInventoryDisplay(Campaign $campaign, Party_Inventory $party_inventory)
    {
        //
        if (session()->get('user_id') != $campaign->user_id) {
            return redirect('/campaign/' . $campaign->campaign_id);
        }

        $loot_groups = Loot_Group::select(['loot_group.*', 'game_type.game_type_title'])
            ->join('loot_group_item', 'loot_group.loot_group_id', 'loot_group_item.loot_group_id')
            ->join('item', 'loot_group_item.item_id', 'item.item_id')
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_group.user_id', '=', Session::get('user_id'))
            ->where('game_type.game_type_id', '=', $campaign->game_type_id)
            ->groupBy('loot_group.loot_group_id')
            ->get();

        return view('lootGroup.party_inventory', compact('loot_groups', 'party_inventory', 'campaign'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function playerInventoryDisplay(Campaign $campaign, Player_Inventory $player_inventory)
    {
        //
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

        $loot_groups = Loot_Group::select(['loot_group.*', 'game_type.game_type_title'])
            ->join('loot_group_item', 'loot_group.loot_group_id', 'loot_group_item.loot_group_id')
            ->join('item', 'loot_group_item.item_id', 'item.item_id')
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_group.user_id', '=', Session::get('user_id'))
            ->where('game_type.game_type_id', '=', $campaign->game_type_id)
            ->groupBy('loot_group.loot_group_id')
            ->get();

        return view('lootGroup.player_inventory', compact('loot_groups', 'player_inventory', 'campaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Session::get('user_id') == null) {
            return redirect('/');
        }

        //
        return view('lootGroup.create');
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
            'loot_group_description' => 'required|string|max:255',
        ]);

        $loot_group_id = Loot_Group::insertGetId([
            'user_id' => Session::get('user_id'),
            'loot_group_description' => request('loot_group_description'),
        ]);

        return redirect('/loot-groups/' . $loot_group_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loot_Group  $loot_group
     * @return \Illuminate\Http\Response
     */
    public function show(Loot_Group $loot_group)
    {
        if (Session::get('user_id') != $loot_group->user_id) {
            return redirect('/');
        }
        //
        $loot_group = Loot_Group::select(['loot_group.*', 'game_type.game_type_title'])
            ->leftjoin('loot_group_item', 'loot_group.loot_group_id', 'loot_group_item.loot_group_id')
            ->leftjoin('item', 'loot_group_item.item_id', 'item.item_id')
            ->leftjoin('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_group.loot_group_id', '=', $loot_group->loot_group_id)
            ->first();

        $loot_group_items = Loot_Group_Item::select(['*'])
            ->join('item', 'loot_group_item.item_id', 'item.item_id')
            ->where('loot_group_id', '=', $loot_group->loot_group_id)
            ->get();

        return view('lootGroup.show', compact('loot_group', 'loot_group_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loot_Group  $loot_group
     * @return \Illuminate\Http\Response
     */
    public function edit(Loot_Group $loot_group)
    {
        //
        if (Session::get('user_id') != $loot_group->user_id) {
            return redirect('/');
        }

        return view('lootGroup.edit', compact('loot_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loot_Group  $loot_Group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loot_Group $loot_group)
    {
        //
        $this->validate(request(), [
            'loot_group_id' => 'required|exists:loot_group,loot_group_id',
            'loot_group_description' => 'required|string|max:255',
        ]);

        Loot_Group::where('loot_group_id', '=', request('loot_group_id'))->update([
            'loot_group_description' => request('loot_group_description'),
        ]);

        return redirect('/loot-groups/' . request('loot_group_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loot_Group  $loot_Group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loot_Group $loot_group)
    {
        //
    }
}
