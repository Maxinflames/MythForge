<?php

namespace App\Http\Controllers;

use App\Loot_Table;
use App\Loot_Table_Item;

use Illuminate\Http\Request;
use Session;

class LootTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get('user_id') == null){
            return redirect('/');
        }

        //
        $loot_tables = Loot_Table::select(['loot_table.*', 'game_type.game_type_title'])
            ->leftjoin('loot_table_item', 'loot_table.loot_table_id', 'loot_table_item.loot_table_id')
            ->leftjoin('item', 'loot_table_item.item_id', 'item.item_id')
            ->leftjoin('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_table.user_id', '=', Session::get('user_id'))
            ->groupBy('loot_table.loot_table_id')
            ->get();

        return view('lootTable.index', compact('loot_tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Session::get('user_id') == null){
            return redirect('/');
        }

        //
        return view('lootTable.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Session::get('user_id') == null){
            return redirect('/');
        }

        //
        $this->validate(request(), [
            'loot_table_description' => 'required|string|max:255',

        ]);

        $loot_table_id = Loot_Table::insertGetId([
            'user_id' => Session::get('user_id'),
            'loot_table_description' => request('loot_table_description'),
        ]);

        return redirect('/loot-tables/' . $loot_table_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loot_Table  $loot_Table
     * @return \Illuminate\Http\Response
     */
    public function show(Loot_Table $loot_table)
    {
        if(Session::get('user_id') != $loot_table->user_id){
            return redirect('/');
        }

        //
        $loot_table = Loot_Table::select(['loot_table.*', 'game_type.game_type_title'])
            ->leftjoin('loot_table_item', 'loot_table.loot_table_id', 'loot_table_item.loot_table_id')
            ->leftjoin('item', 'loot_table_item.item_id', 'item.item_id')
            ->leftjoin('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->where('loot_table.loot_table_id', '=', $loot_table->loot_table_id)
            ->first();

        $loot_table_items = Loot_Table_Item::select(['*'])
            ->join('item', 'loot_table_item.item_id', 'item.item_id')
            ->where('loot_table_item.loot_table_id', '=', $loot_table->loot_table_id)
            ->get();

        return view('lootTable.show', compact('loot_table', 'loot_table_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loot_Table  $loot_table
     * @return \Illuminate\Http\Response
     */
    public function edit(Loot_Table $loot_table)
    {
        if(Session::get('user_id') != $loot_table->user_id){
            return redirect('/');
        }
        //
        return view('lootTable.edit', compact('loot_table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loot_Table  $loot_Table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loot_Table $loot_table)
    {
        if(Session::get('user_id') != $loot_table->user_id){
            return redirect('/');
        }

        //
        $this->validate(request(), [
            'loot_table_id' => 'required|exists:loot_table,loot_table_id',
            'loot_table_description' => 'required|string|max:255',
        ]);

        Loot_Table::where('loot_table_id', '=', request('loot_table_id'))->update([
            'loot_table_description' => request('loot_table_description'),
        ]);

        return redirect('/loot-tables/' . request('loot_table_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loot_Table  $loot_Table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loot_Table $loot_Table)
    {
        //
    }
}
