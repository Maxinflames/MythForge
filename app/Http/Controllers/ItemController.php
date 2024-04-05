<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;

use App\Item;
use App\Game_Type;
use App\Subscribed_Item;

use Illuminate\Http\Request;

class ItemController extends Controller
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

        $items = item::select([
            'item.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from subscribed_item where subscribed_item.item_id = item.item_id) as subscriptions')
        ])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->where('item.item_status', '=', '1')
            ->orWhere('item.user_id', '=', session('user_id'))
            ->groupBy('item.item_id')
            ->orderBy('item.item_id')
            ->get();


        return view('item.index', compact('items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemsById()
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::get('user_id') == null) {
            return redirect('/');
        }

        $items = item::select([
            'item.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from subscribed_item where subscribed_item.item_id = item.item_id) as subscriptions')
        ])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->groupBy('item.item_id')
            ->orderBy('item.item_id')
            ->where('item.user_id', '=', Session::get('user_id'))
            ->get();

        return view('item.itemsById', compact('items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemSearch(Request $request)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $text = request('search_text');

        $itemSearch = item::select([
            'item.item_id',
        ])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->where('user.user_name', 'like', '%' . $text . '%')
            ->orwhere('item.item_title', 'like', '%' . $text . '%')
            ->orwhere('game_type.game_type_title', 'like', '%' . $text . '%')
            ->get();

        $item_collection = item::select([
            'item.item_id',
        ])
        ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
        ->join('user', 'item.user_id', 'user.user_id')
        ->where('item.item_status', '=', '1')
        ->orWhere('item.user_id', '=', session('user_id'))
        ->groupBy('item.item_id')
        ->orderBy('item.item_id')
        ->get();

        $items = item::select([
            'item.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from subscribed_item where subscribed_item.item_id = item.item_id) as subscriptions')
        ])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->whereIn('item.item_id', $itemSearch)
            ->whereIn('item.item_id', $item_collection)
            ->groupBy('item.item_id')
            ->orderBy('item.item_id')
            ->get();

        return view('item.index', compact('items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemSearchById(Request $request)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::get('user_id') == null) {
            return redirect('/');
        }

        $text = request('search_text');

        $itemSearch = item::select([
            'item.item_id',
        ])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->where('user.user_name', 'like', '%' . $text . '%')
            ->orwhere('item.item_title', 'like', '%' . $text . '%')
            ->orwhere('game_type.game_type_title', 'like', '%' . $text . '%')
            ->get();

        $items = item::select([
            'item.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from subscribed_item where subscribed_item.item_id = item.item_id) as subscriptions')
        ])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->where('item.user_id', '=', Session::get('user_id'))
            ->whereIn('item.item_id', $itemSearch)
            ->groupBy('item.item_id')
            ->orderBy('item.item_id')
            ->get();

        return view('item.itemsById', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::get('user_id') == null) {
            return redirect('/');
        }

        $game_types = game_type::select(['*'])
            ->get();

        return view('item.create', compact('game_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Session::get('user_id') == null) {
            return redirect('/');
        }
        //
        $this->validate(request(), [
            'game_type_id' => 'required|exists:game_type,game_type_id',
            'item_title' => 'required|string|max:50',
            'item_description' => 'nullable|string|max:10000',
            'item_status' => 'required|numeric|min:0|max:1',
        ]);

        $item_id = item::insertGetId([
            'user_id' => session()->get('user_id'),
            'game_type_id' => request('game_type_id'),
            'item_title' => request('item_title'),
            'item_description' => request('item_description'),
            'item_status' => request('item_status'),
        ]);

        return redirect('/items/' . $item_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
        session()->forget('active_campaign');
        session()->forget('player_id');

        $subscribed = subscribed_item::select(['*'])
            ->where('item_id', '=', $item->item_id)
            ->where('user_id', '=', Session::get('user_id'))
            ->get();

        $item_game_type = item::select(['game_type.game_type_title'])
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->first();

        return view('item.show', compact('item', 'item_game_type', 'subscribed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::get('user_id') != $item->user_id) {
            return redirect('/items/' . $item->item_id);
        } else {

            $game_types = game_type::select(['*'])
                ->get();

            return view('item.edit', compact('item', 'game_types'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
        if (Session::has('active_campaign')) {
            session()->forget('active_campaign');
        }
        if (Session::get('user_id') != $item->user_id) {
            return redirect('/');
        }

        $this->validate(request(), [
            'user_id' => 'required|exists:user,user_id',
            'game_type_id' => 'required|exists:game_type,game_type_id',
            'item_title' => 'required|string|max:50',
            'item_description' => 'nullable|string|max:10000',
            'item_status' => 'required|numeric|min:0|max:1',
        ]);

        item::where('item_id', request('item_id'))->update([
            'game_type_id' => request('game_type_id'),
            'item_title' => request('item_title'),
            'item_description' => request('item_description'),
            'item_status' => request('item_status'),
        ]);

        return redirect('/items/' . $item->item_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
