<?php

namespace App\Http\Controllers;

use App\Loot_Group_Item;
use App\Loot_Group;
use App\Loot_Table;
use App\Loot_Table_Item;
use App\Item;

use Session;
use Illuminate\Http\Request;

class LootGroupItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Loot_Group $loot_group)
    {
        if(Session::get('user_id') != $loot_group->user_id){
            return redirect('/');
        }
        //
        $loot_group = Loot_Group::select(['loot_group.*', 'game_type.game_type_id', 'game_type.game_type_title'])
            ->leftjoin('loot_group_item', 'loot_group.loot_group_id', 'loot_group_item.loot_group_id')
            ->leftjoin('item', 'loot_group_item.item_id', 'item.item_id')
            ->leftjoin('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_group.loot_group_id', '=', $loot_group->loot_group_id)
            ->first();

        if ($loot_group->game_type_title == null) {
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
                ->where('item.game_type_id', '=', $loot_group->game_type_id)
                ->get();

            $created_items = Item::select(['item.item_id'])
                ->where('item.user_id', '=', Session::get('user_id'))
                ->where('item.game_type_id', '=', $loot_group->game_type_id)
                ->get();

            $items = Item::select(['item.*', 'user.user_name', 'game_type.game_type_title'])
                ->join('user', 'item.user_id', 'user.user_id')
                ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
                ->whereIn('item_id', $subscribed_items)
                ->orWhereIn('item_id', $created_items)
                ->get();
        }

        return view('lootGroupItem.create', compact('loot_group', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Loot_Group $loot_group)
    {
        if (Session::get('user_id') != $loot_group->user_id) {
            return redirect('/');
        }
        //
        $this->validate(request(), [
            'item_id' => 'required|exists:item,item_id',
            'loot_group_id' => 'required|exists:loot_group,loot_group_id',
            'loot_group_item_quantity' => 'required|numeric|min:1',
        ]);

        $item = Loot_Group_Item::select(['*'])
            ->where('item_id', '=', request('item_id'))
            ->where('loot_group_id', '=', request('loot_group_id'))
            ->first();

        if ($item == null) {
            $loot_group_item_id = Loot_Group_Item::insertGetId([
                'item_id' => request('item_id'),
                'loot_group_id' => $loot_group->loot_group_id,
                'loot_group_item_quantity' => request('loot_group_item_quantity'),
                # For some reason this wont register the first time I initialize the quantity
            ]);

            # Thus this disgusting work around... I really don't get this
            Loot_Group_Item::where('loot_group_item_id', $loot_group_item_id)->update([
                'loot_group_item_quantity' => request('loot_group_item_quantity'),
            ]);
        }
        else {
            $new_quantity = $item->loot_group_item_quantity + request('loot_group_item_quantity');
            Loot_Group_Item::where('loot_group_item_id', $item->loot_group_item_id)->update([
                'loot_group_item_quantity' => $new_quantity,
            ]);
        }

        return redirect('loot-groups/' . $loot_group->loot_group_id);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lootTable(Loot_Group $loot_group)
    {
        if(Session::get('user_id') != $loot_group->user_id){
            return redirect('/');
        }
        //
        $loot_group = Loot_Group::select(['loot_group.*', 'game_type.game_type_id', 'game_type.game_type_title'])
            ->leftjoin('loot_group_item', 'loot_group.loot_group_id', 'loot_group_item.loot_group_id')
            ->leftjoin('item', 'loot_group_item.item_id', 'item.item_id')
            ->leftjoin('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_group.loot_group_id', '=', $loot_group->loot_group_id)
            ->first();

        if ($loot_group->game_type_title == null) {
            $loot_tables = Loot_Table::select(['loot_table.*', 'game_type.game_type_title'])
            ->join('loot_table_item', 'loot_table.loot_table_id', 'loot_table_item.loot_table_id')
            ->join('item', 'loot_table_item.item_id', 'item.item_id')
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->groupBy('loot_table.loot_table_id')
            ->get();
        } else {
            $loot_tables = Loot_Table::select(['loot_table.*', 'game_type.game_type_title'])
            ->join('loot_table_item', 'loot_table.loot_table_id', 'loot_table_item.loot_table_id')
            ->join('item', 'loot_table_item.item_id', 'item.item_id')
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('game_type.game_type_id', '=', $loot_group->game_type_id)
            ->groupBy('loot_table.loot_table_id')
            ->get();
        }

        return view('lootGroupItem.lootTable', compact('loot_group', 'loot_tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lootTableStore(Request $request, Loot_Group $loot_group, Loot_Table $loot_table)
    {
        if(Session::get('user_id') != $loot_group->user_id){
            return redirect('/');
        }
        //
        $loot_table_items = loot_table_Item::select(['*'])
        ->where('loot_table_item.loot_table_id', '=', $loot_table->loot_table_id)
        ->get();

        $item_weight_sum = 0;

        foreach ($loot_table_items as $loot_item){
            $item_weight_sum += $loot_item->loot_table_item_weight;
        }

        $value = rand(1, $item_weight_sum);
        $rolled_item = 0;

        foreach ($loot_table_items as $loot_item){
            $value -= $loot_item->loot_table_item_weight;
            if($value <= 0)
            {
                $rolled_item = $loot_item;
                break;
            }
        }

        $total_multiplier = 0;

        for($i = 1; $i <= $rolled_item->loot_table_item_dice_count; $i++)
        {
            $total_multiplier += rand(1, $rolled_item->loot_table_item_roll);
        }

        $rolled_item_quantity = $rolled_item->loot_table_item_count * $total_multiplier;

        $item = Loot_Group_Item::select(['*'])
            ->where('item_id', '=', $rolled_item->item_id)
            ->where('loot_group_id', '=', $loot_group->loot_group_id)
            ->first();

        if ($item == null) {
            Loot_Group_Item::create([
                'item_id' => $rolled_item->item_id,
                'loot_group_id' => $loot_group->loot_group_id,
                'loot_group_item_quantity' => $rolled_item_quantity,
            ]);
        }
        else {
            $new_quantity = $item->loot_group_item_quantity + $rolled_item_quantity;
            Loot_Group_Item::where('loot_group_item_id', $item->loot_group_item_id)->update([
                'loot_group_item_quantity' => $new_quantity,
            ]);
        }

        return redirect('loot-groups/' . $loot_group->loot_group_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loot_Group_Item  $loot_group_item
     * @return \Illuminate\Http\Response
     */
    public function edit(Loot_Group $loot_group, Loot_Group_Item $loot_group_item)
    {
        if(Session::get('user_id') != $loot_group->user_id){
            return redirect('/');
        }
        //
        $item = item::select(['item.*', 'game_type.game_type_title'])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('item.item_id', '=', $loot_group_item->item_id)
            ->first();

        return view('lootGroupItem.edit', compact('item', 'loot_group_item', 'loot_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loot_Group_Item  $loot_Group_Item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loot_Group $loot_group, Loot_Group_Item $loot_group_item)
    {
        if(Session::get('user_id') != $loot_group->user_id){
            return redirect('/');
        }
        //
        $this->validate(request(), [
            'loot_group_item_quantity' => 'required|numeric|min:0',
        ]);

        if (request('loot_group_item_quantity') != 0) {
            Loot_Group_Item::where('loot_group_item_id', '=', $loot_group_item->loot_group_item_id)->update([
                'loot_group_item_quantity' => request('loot_group_item_quantity'),
            ]);
        } else {
            Loot_Group_Item::where('loot_group_item_id', '=', $loot_group_item->loot_group_item_id)->delete();
        }

        return redirect('/loot-groups/' . $loot_group->loot_group_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loot_Group  $loot_Group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Loot_Group $loot_group, Loot_Group_Item $loot_group_item)
    {
        //
        if(Session::get('user_id') != $loot_group->user_id){
            return redirect('/');
        }

        Loot_Group_Item::where('loot_group_item_id', '=', $loot_group_item->loot_group_item_id)->delete();

        return redirect('/loot-groups/' . $loot_group->loot_group_id);
    }
}
