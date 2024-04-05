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
                                action="/loot-groups/{{ $loot_group->loot_group_id }}/items/{{ $loot_group_item->loot_group_item_id }}/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="item_title" class="col-md-5 control-label">Item Title</label>
                                    <div class="col-md-6">
                                        <input name="item_title" readonly="true" class="form-control" type="text"
                                            value="{{ $item->item_title }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="loot_group_item_quantity" class="col-md-5 control-label">Quantity</label>
                                    <div class="col-md-3">
                                        <input name="loot_group_item_quantity", class="form-control" type="number"
                                            value="{{ $loot_group_item->loot_group_item_quantity }}">
                                    </div>
                                </div>
                                @if ($errors->has('loot_group_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('loot_group_description') }}</strong>
                                    </span>
                                @endif
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
