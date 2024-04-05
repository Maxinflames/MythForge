<?php

namespace App\Http\Controllers;

use App\Loot_Group;
use App\Loot_Group_Item;
use App\Player_Inventory;
use App\Player_Inventory_Item;
use App\Campaign;
use App\Item;

use Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PlayerInventoryItemController extends Controller
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
    public function create(Campaign $campaign, Player_Inventory $player_inventory)
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

        $subscribed_items = Item::select(['item.item_id'])
            ->join('subscribed_item', 'item.item_id', 'subscribed_item.item_id')
            ->where('subscribed_item.user_id', '=', $campaign->user_id)
            ->where('item.game_type_id', '=', $campaign->game_type_id)
            ->get();

        $created_items = Item::select(['item.item_id'])
            ->where('item.user_id', '=', $campaign->user_id)
            ->where('item.game_type_id', '=', $campaign->game_type_id)
            ->get();

        $current_items = Item::select(['item.item_id'])
            ->join('player_inventory_item', 'item.item_id', 'player_inventory_item.item_id')
            ->where('player_inventory_item.player_inventory_id', '=', $player_inventory->player_inventory_id)
            ->where('item.game_type_id', '=', $campaign->game_type_id)
            ->get();

        $items = Item::select(['item.*', 'user.user_name'])
            ->join('user', 'item.user_id', 'user.user_id')
            ->whereIn('item_id', $subscribed_items)
            ->orWhereIn('item_id', $created_items)
            ->orWhereIn('item_id', $current_items)
            ->get();

        /* It frustrates me I cannot figure out how to do it this way
        $items = Item::select(['item.*'])
            ->leftjoin('subscribed_item', 'item.item_id', 'subscribed_item.item_id')
            ->leftjoin('player_inventory_item', 'item.item_id', 'player_inventory_item.item_id')
            ->where('subscribed_item.user_id', '=', $campaign->user_id)
            ->where('item.game_type_id', '=', $campaign->game_type_id)
            ->orWhere(function ($query, $campaign, $player_inventory) {
                $query->where('player_inventory_item.player_inventory_id', '=', $player_inventory->player_inventory_id)
                    ->where('item.game_type_id', '=', $campaign->game_type_id);
            })
            ->orWhere(function ($query, $campaign) {
                $query->where('item.user_id', '=', $campaign->user_id)
                    ->where('item.game_type_id', '=', $campaign->game_type_id);
            })
            ->get();
        */

        return view('playerInventoryItem.create', compact('items', 'campaign', 'player_inventory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Campaign $campaign, Player_Inventory $player_inventory)
    {
        $this->validate(request(), [
            'item_id' => 'required|exists:item,item_id',
            'player_inventory_id' => 'required|exists:player_inventory,player_inventory_id',
            'player_inventory_item_quantity' => 'required|numeric|min:1',
        ]);

        $item = Player_Inventory_Item::select(['*'])
            ->where('item_id', '=', request('item_id'))
            ->where('player_inventory_id', '=', $player_inventory->player_inventory_id)
            ->first();

        if ($item == null) {
            $player_inventory_item_id = Player_Inventory_Item::insertGetId([
                'item_id' => request('item_id'),
                'player_inventory_id' => $player_inventory->player_inventory_id,
                'player_inventory_item_quantity' => request('player_inventory_item_quantity'),
            ]);
        } else {
            $new_quantity = $item->player_inventory_item_quantity + request('player_inventory_item_quantity');
            Player_Inventory_Item::where('player_inventory_item_id', $item->player_inventory_item_id)->update([
                'player_inventory_item_quantity' => $new_quantity,
            ]);
        }

        return redirect('campaign/' . $campaign->campaign_id . '/player-inventory/' . $player_inventory->player_inventory_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player_Inventory_Item  $player_Inventory_Item
     * @return \Illuminate\Http\Response
     */
    public function show(Player_Inventory_Item $player_Inventory_Item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player_Inventory_Item  $player_Inventory_Item
     * @return \Illuminate\Http\Response
     */
    public function edit(Player_Inventory_Item $player_Inventory_Item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player_Inventory_Item  $player_Inventory_Item
     * @return \Illuminate\Http\Response
     */
    public function addLootGroup(Request $request, Campaign $campaign,  Player_Inventory $player_inventory, Loot_Group $loot_group)
    {
        //
        $loot_group_items = Loot_Group_Item::select(['*'])
        ->where('loot_group_id', '=', $loot_group->loot_group_id)
        ->get();

        foreach($loot_group_items as $loot_group_item)
        {
            $item = Player_Inventory_Item::select(['*'])
            ->where('item_id', '=', $loot_group_item->item_id)
            ->where('player_inventory_id', '=', $player_inventory->player_inventory_id)
            ->first();

            if ($item == null) {
                $player_inventory_item_id = Player_Inventory_Item::insertGetId([
                    'item_id' => $loot_group_item->item_id,
                    'player_inventory_id' => $player_inventory->player_inventory_id,
                    'player_inventory_item_quantity' => $loot_group_item->loot_group_item_quantity,
                ]);
            } else {
                $new_quantity = $item->player_inventory_item_quantity + $loot_group_item->loot_group_item_quantity;
                Player_Inventory_Item::where('player_inventory_item_id', $item->player_inventory_item_id)->update([
                    'player_inventory_item_quantity' => $new_quantity,
                ]);
            }
        }

        return redirect('campaign/' . $campaign->campaign_id . '/player-inventory/' . $player_inventory->player_inventory_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player_Inventory_Item  $player_Inventory_Item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player_Inventory_Item $player_Inventory_Item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player_Inventory_Item  $player_Inventory_Item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player_Inventory_Item $player_Inventory_Item)
    {
        //
    }
}
