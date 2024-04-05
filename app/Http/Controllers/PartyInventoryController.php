<?php

namespace App\Http\Controllers;

use App\Party_Inventory;
use App\Campaign;
use App\Player;
use App\Party_Inventory_Item;
use App\Player_Inventory_Item;

use Session;
use Illuminate\Http\Request;

class PartyInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Campaign $campaign, Party_Inventory $party_inventory)
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
        $items = Party_Inventory_Item::select(['party_inventory_item.party_inventory_item_quantity', 'item.*'])
            ->join('item', 'party_inventory_item.item_id', 'item.item_id')
            ->join('party_inventory', 'party_inventory_item.party_inventory_id', 'party_inventory.party_inventory_id')
            ->where('party_inventory.campaign_id', '=', $campaign->campaign_id)
            ->get();

        $players = Player::select(['player.*', 'player_inventory.player_inventory_id'])
            ->join('player_inventory', 'player.player_id', 'player_inventory.player_id')
            ->where('player.campaign_id', '=', $campaign->campaign_id)
            ->get();

        return view('partyInventory.index', compact('items', 'campaign', 'party_inventory', 'player', 'players'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Party_Inventory  $party_Inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Party_Inventory $party_Inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Party_Inventory  $party_Inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign, Party_Inventory $party_Inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Party_Inventory  $party_Inventory
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request, Campaign $campaign, Party_Inventory $party_inventory)
    {
        //
        $item_data = Party_Inventory_Item::select(['*'])
            ->where('item_id', '=', request('item_id'))
            ->where('party_inventory_id', '=', $party_inventory->party_inventory_id)
            ->first();

        $this->validate(request(), [
            'item_id' => 'required|exists:item,item_id',
            'player_inventory_id' => 'required|exists:player_inventory,player_inventory_id',
            'party_inventory_item_quantity' => 'required|numeric|min:1|max:' . $item_data->party_inventory_item_quantity,
        ]);

        $item = Player_Inventory_Item::select(['*'])
            ->where('item_id', '=', request('item_id'))
            ->where('player_inventory_id', '=', request('player_inventory_id'))
            ->first();

        if ($item == null) {
            $player_item = Player_Inventory_Item::InsertGetID([
                'player_inventory_id' => request('player_inventory_id'),
                'item_id' => $item_data->item_id,
                'player_inventory_item_quantity' => request('party_inventory_item_quantity'),
            ]);
        } else {
            $new_quantity = $item->player_inventory_item_quantity + request('party_inventory_item_quantity');
            Player_Inventory_Item::where('player_inventory_item_id', $item->player_inventory_item_id)->update([
                'player_inventory_item_quantity' => $new_quantity,
            ]);
        }

        if ($item_data->party_inventory_item_quantity == request('party_inventory_item_quantity')) {
            Party_Inventory_Item::where('party_inventory_item_id', '=', $item_data->party_inventory_item_id)->delete();
        } else {
            $new_quantity = $item_data->party_inventory_item_quantity - request('party_inventory_item_quantity');
            Party_Inventory_Item::where('party_inventory_item_id', '=', $item_data->party_inventory_item_id)->update([
                'party_inventory_item_quantity' => $new_quantity,
            ]);
        }

        return redirect('campaign/' . $campaign->campaign_id . '/party-inventory/' . $party_inventory->party_inventory_id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Party_Inventory  $party_Inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party_Inventory $party_Inventory)
    {
        //
    }
}
