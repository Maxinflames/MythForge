<title>MythForge - Loot Group Edit</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit Loot Group Details</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST"
                                action="/loot-tables/{{ $loot_table->loot_table_id }}/items/{{ $loot_table_item->loot_table_item_id }}/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="item_title" class="col-md-5 control-label">Item Title</label>
                                    <div class="col-md-6">
                                        <input name="item_title" readonly="true" class="form-control" type="text"
                                            value="{{ $item->item_title }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="loot_table_item_dice_count" class="col-md-5 control-label">Number of Dice</label>
                                    <div class="col-md-3">
                                        <input name="loot_table_item_dice_count", class="form-control" type="number"
                                            value="{{ $loot_table_item->loot_table_item_dice_count }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="loot_table_item_roll" class="col-md-5 control-label">Dice Value</label>
                                    <div class="col-md-3">
                                        <input name="loot_table_item_roll", class="form-control" type="number"
                                            value="{{ $loot_table_item->loot_table_item_roll }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="loot_table_item_weight" class="col-md-5 control-label">Drop Chance</label>
                                    <div class="col-md-3">
                                        <input name="loot_table_item_weight", class="form-control" type="number"
                                            value="{{ $loot_table_item->loot_table_item_weight }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="loot_table_item_count" class="col-md-5 control-label">Quantity</label>
                                    <div class="col-md-3">
                                        <input name="loot_table_item_count", class="form-control" type="number"
                                            value="{{ $loot_table_item->loot_table_item_count }}">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <div class="content">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
