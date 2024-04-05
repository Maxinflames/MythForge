<?php

namespace App\Http\Controllers;

use App\Item;
use App\Loot_Table;
use App\Loot_Table_Item;

use Illuminate\Http\Request;
use Session;

class LootTableItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Loot_Table $loot_table)
    {
        if(Session::get('user_id') != $loot_table->user_id){
            return redirect('/');
        }
        //
        $loot_table = Loot_Table::select(['loot_table.*', 'game_type.game_type_id', 'game_type.game_type_title'])
            ->leftjoin('loot_table_item', 'loot_table.loot_table_id', 'loot_table_item.loot_table_id')
            ->leftjoin('item', 'loot_table_item.item_id', 'item.item_id')
            ->leftjoin('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_table.loot_table_id', '=', $loot_table->loot_table_id)
            ->first();

        if ($loot_table->game_type_title == null) {
            $subscribed_items = Item::select(['item.item_id'])
                ->join('subscribed_item', 'item.item_id', 'subscribed_item.item_id')
                ->where('subscribed_item.user_id', '=', Session::get('user_id'))
                ->get();

            $created_items = Item::select(['item.item_id'])
                ->where('item.user_id', '=', Session::get('user_id'))
                ->get();

            $items = Item::select(['item.*', 'user.user_name', 'game_type.game_type_title'])
                ->join('user', 'item.user_id', 'user.user_id')
                ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
                ->whereIn('item_id', $subscribed_items)
                ->orWhereIn('item_id', $created_items)
                ->get();
        } else {
            $subscribed_items = Item::select(['item.item_id'])
                ->join('subscribed_item', 'item.item_id', 'subscribed_item.item_id')
                ->where('subscribed_item.user_id', '=', Session::get('user_id'))
                ->where('item.game_type_id', '=', $loot_table->game_type_id)
                ->get();

            $created_items = Item::select(['item.item_id'])
                ->where('item.user_id', '=', Session::get('user_id'))
                ->where('item.game_type_id', '=', $loot_table->game_type_id)
                ->get();

            $items = Item::select(['item.*', 'user.user_name', 'game_type.game_type_title'])
                ->join('user', 'item.user_id', 'user.user_id')
                ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
                ->whereIn('item_id', $subscribed_items)
                ->orWhereIn('item_id', $created_items)
                ->get();
        }

        return view('lootTableItem.create', compact('loot_table', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Loot_Table $loot_table)
    {
        if(Session::get('user_id') != $loot_table->user_id){
            return redirect('/');
        }
        //
        $this->validate(request(), [
            'item_id' => 'required|exists:item,item_id',
            'loot_table_id' => 'required|exists:loot_table,loot_table_id',
            'loot_table_item_dice_count' => 'required|numeric|min:1',
            'loot_table_item_roll' => 'required|numeric|min:1',
            'loot_table_item_count' => 'required|numeric|min:1',
            'loot_table_item_weight' => 'required|numeric|min:1',
        ]);


        Loot_Table_Item::create([
            'item_id' => request('item_id'),
            'loot_table_id' => $loot_table->loot_table_id,
            'loot_table_item_dice_count' => request('loot_table_item_dice_count'),
            'loot_table_item_roll' => request('loot_table_item_roll'),
            'loot_table_item_count' => request('loot_table_item_count'),
            'loot_table_item_weight' => request('loot_table_item_weight'),
        ]);

        return redirect('loot-tables/' . $loot_table->loot_table_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loot_Table_Item  $loot_Table_Item
     * @return \Illuminate\Http\Response
     */
    public function show(Loot_Table_Item $loot_Table_Item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loot_Table_Item  $loot_table_item
     * @return \Illuminate\Http\Response
     */
    public function edit(Loot_Table $loot_table, Loot_Table_Item $loot_table_item)
    {
        if(Session::get('user_id') != $loot_table->user_id){
            return redirect('/');
        }
        //
        $item = item::select(['item.*', 'game_type.game_type_title'])
        ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
        ->where('item.item_id', '=', $loot_table_item->item_id)
        ->first();

        return view('lootTableItem.edit', compact('loot_table', 'loot_table_item', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loot_Table_Item  $loot_Table_Item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loot_Table $loot_table, Loot_Table_Item $loot_table_item)
    {
        if(Session::get('user_id') != $loot_table->user_id){
            return redirect('/');
        }
        //
        $this->validate(request(), [
            'loot_table_item_dice_count' => 'required|numeric|min:1',
            'loot_table_item_roll' => 'required|numeric|min:1',
            'loot_table_item_count' => 'required|numeric|min:1',
            'loot_table_item_weight' => 'required|numeric|min:1',
        ]);

        Loot_Table_Item::where('loot_group_item_id', '=', $loot_table_item->loot_table_item_id)->update([
            'item_id' => $loot_table_item->item_id,
            'loot_table_id' => $loot_table->loot_table_id,
            'loot_table_item_dice_count' => request('loot_table_item_dice_count'),
            'loot_table_item_roll' => request('loot_table_item_roll'),
            'loot_table_item_count' => request('loot_table_item_count'),
            'loot_table_item_weight' => request('loot_table_item_weight'),
        ]);

        return redirect('loot-tables/' . $loot_table->loot_table_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loot_Table_Item  $loot_Table_Item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loot_Table_Item $loot_Table_Item)
    {
        //
    }
}
