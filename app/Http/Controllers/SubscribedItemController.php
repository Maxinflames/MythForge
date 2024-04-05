<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;

use App\Subscribed_Item;
use Illuminate\Http\Request;

class SubscribedItemController extends Controller
{
    /**search
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::get('user_id') == null) {
            return redirect('/');
        }

        $subscribed_items = subscribed_item::select([
            'item.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from subscribed_item where subscribed_item.item_id = item.item_id) as subscriptions')
        ])
            ->join('item', 'subscribed_item.item_id', 'item.item_id')
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->groupBy('item.item_id')
            ->orderBy('item.item_id')
            ->where('subscribed_item.user_id', '=', Session::get('user_id'))
            ->get();

        return view('subscribedItem.index', compact('subscribed_items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::get('user_id') == null) {
            return redirect('/');
        }

        $text = request('search_text');

        $subscriptionSearch = subscribed_item::select([
            'subscribed_item.subscribed_item_id',
        ])
            ->join('item', 'subscribed_item.item_id', 'item.item_id')
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->where('user.user_name', 'like', '%' . $text . '%')
            ->orwhere('item.item_title', 'like', '%' . $text . '%')
            ->orwhere('game_type.game_type_title', 'like', '%' . $text . '%')
            ->get();

        $subscribed_items = subscribed_item::select([
            'item.*',
            'game_type.game_type_title',
            'user.user_name',
            db::raw('(select count(\'x\') from subscribed_item where subscribed_item.item_id = item.item_id) as subscriptions')
        ])
            ->join('item', 'subscribed_item.item_id', 'item.item_id')
            ->join('game_type', 'item.game_type_id', 'game_type.game_type_id')
            ->join('user', 'item.user_id', 'user.user_id')
            ->whereIn('subscribed_item.subscribed_item_id', $subscriptionSearch)
            ->where('subscribed_item.user_id', '=', Session::get('user_id'))
            ->groupBy('item.item_id')
            ->orderBy('item.item_id')
            ->get();

        return view('subscribedItem.index', compact('subscribed_items'));
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

        $this->validate(request(), [
            'item_id' => 'required|exists:item,item_id',
        ]);

        subscribed_item::create([
            'user_id' => session()->get('user_id'),
            'item_id' => request('item_id'),
        ]);

        return redirect('/items/' . request('item_id'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscribed_Item  $subscribed_Item
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (Session::get('user_id') == null) {
            return redirect('/');
        }

        $this->validate(request(), [
            'item_id' => 'required|exists:item,item_id',
        ]);

        subscribed_item::where('user_id','=', session()->get('user_id'))
        ->where('item_id','=', request('item_id'))
        ->delete();

        return redirect('/items/' . request('item_id'));
    }
}
