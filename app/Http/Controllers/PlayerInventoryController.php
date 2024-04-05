<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Player_Inventory_Item;
use App\Party_Inventory_Item;
use App\Player_Inventory;
use App\Party_Inventory;
use App\Player;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Campaign $campaign, Player_Inventory $player_inventory)
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

        //
        $items = Player_Inventory_Item::select(['player_inventory_item.player_inventory_item_quantity', 'item.*'])
            ->join('item', 'player_inventory_item.item_id', 'item.item_id')
            ->join('player_inventory', 'player_inventory_item.player_inventory_id', 'player_inventory.player_inventory_id')
            ->join('player', 'player_inventory.player_id', 'player.player_id')
            ->where('player.campaign_id', '=', $campaign->campaign_id)
            ->where('player_inventory.player_inventory_id', '=', $player_inventory->player_inventory_id)
            ->get();


        $player = Player::select(['player.player_character_name'])
            ->join('player_inventory', 'player.player_id', 'player_inventory.player_id')
            ->where('player.player_id', '=', $player_inventory->player_id)
            ->first();

        $players = Player::select(['player.*', 'player_inventory.player_inventory_id'])
            ->join('player_inventory', 'player.player_id', 'player_inventory.player_id')
            ->where('player.campaign_id', '=', $campaign->campaign_id)
            ->get();

        $party_inventory_id = Party_Inventory::select(['party_inventory_id'])
            ->where('campaign_id', '=', $campaign->campaign_id)
            ->first();

        return view('playerInventory.index', compact('items', 'campaign', 'party_inventory_id', 'player_inventory', 'player', 'players'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @param  \App\Player_Inventory  $player_inventory
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request, Campaign $campaign, Player_Inventory $player_inventory)
    {
        //
        $item_data = Player_Inventory_Item::select(['*'])
            ->where('item_id', '=', request('item_id'))
            ->where('player_inventory_id', '=', $player_inventory->player_inventory_id)
            ->first();

        $inventory_data = explode(',', request('inventory_id'));

        $data = $request->all();
        $data['inventory_id'] = $inventory_data[1];

        if ($inventory_data[0] == 'party') {

            dd('here1');
            $validator = Validator::make($data, [
                'item_id' => 'required|exists:item,item_id',
                'inventory_id' => 'required|exists:party_inventory,party_inventory_id',
                'player_inventory_item_quantity' => 'required|numeric|min:1|max:' . $item_data->player_inventory_item_quantity,
            ]);

            if ($validator->fails()) {
                return redirect('campaign/' . $campaign->campaign_id . '/player-inventory/' . $player_inventory->player_inventory_id)
                    ->withErrors($validator);
            }

            $item = Party_Inventory_Item::select(['*'])
                ->where('item_id', '=', request('item_id'))
                ->where('party_inventory_id', '=', $inventory_data[1])
                ->first();

            if ($item == null) {
                $party_item = Party_Inventory_Item::InsertGetID([
                    'party_inventory_id' => $inventory_data[1],
                    'item_id' => $item_data->item_id,
                    'party_inventory_item_quantity' => request('player_inventory_item_quantity'),
                ]);
            } else {
                $new_quantity = $item->party_inventory_item_quantity + request('player_inventory_item_quantity');
                Party_Inventory_Item::where('party_inventory_item_id', $item->party_inventory_item_id)->update([
                    'party_inventory_item_quantity' => $new_quantity,
                ]);
            }

            if ($item_data->player_inventory_item_quantity == request('player_inventory_item_quantity')) {
                Player_Inventory_Item::where('player_inventory_item_id', '=', $item_data->player_inventory_item_id)->delete();
            } else {
                $new_quantity = $item_data->player_inventory_item_quantity - request('player_inventory_item_quantity');
                Player_Inventory_Item::where('player_inventory_item_id', '=', $item_data->player_inventory_item_id)->update([
                    'player_inventory_item_quantity' => $new_quantity,
                ]);
            }
        } else {
            $validator = Validator::make($data, [
                'item_id' => 'required|exists:item,item_id',
                'inventory_id' => 'required|exists:player_inventory,player_inventory_id',
                'player_inventory_item_quantity' => 'required|numeric|min:1|max:' . $item_data->player_inventory_item_quantity,
            ]);

            if ($validator->fails()) {
                return redirect('/campaign/' . $campaign->campaign_id . '/player-inventory/' . $player_inventory->player_inventory_id)
                    ->withErrors($validator);
            }

            $item = Player_Inventory_Item::select(['*'])
                ->where('item_id', '=', request('item_id'))
                ->where('player_inventory_id', '=', $inventory_data[1])
                ->first();

            if ($item == null) {
                $party_item = Player_Inventory_Item::InsertGetID([
                    'player_inventory_id' => $inventory_data[1],
                    'item_id' => $item_data->item_id,
                    'player_inventory_item_quantity' => request('player_inventory_item_quantity'),
                ]);
            } else {
                $new_quantity = $item->party_inventory_item_quantity + request('player_inventory_item_quantity');
                Player_Inventory_Item::where('player_inventory_item_id', $item->party_inventory_item_id)->update([
                    'player_inventory_item_quantity' => $new_quantity,
                ]);
            }

            if ($item_data->player_inventory_item_quantity == request('player_inventory_item_quantity')) {
                Player_Inventory_Item::where('player_inventory_item_id', '=', $item_data->player_inventory_item_id)->delete();
            } else {
                $new_quantity = $item_data->player_inventory_item_quantity - request('player_inventory_item_quantity');
                Player_Inventory_Item::where('player_inventory_item_id', '=', $item_data->player_inventory_item_id)->update([
                    'player_inventory_item_quantity' => $new_quantity,
                ]);
            }
        }

        return redirect('campaign/' . $campaign->campaign_id . '/player-inventory/' . $player_inventory->player_inventory_id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player_Inventory  $player_Inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player_Inventory $player_Inventory)
    {
        //
    }
}
