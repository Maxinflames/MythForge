<title>MythForge - Loot Table Edit</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit Loot Table Details</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST"
                                action="/loot-tables/{{ $loot_table->loot_table_id }}/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="loot_table_id" value="{{ $loot_table->loot_table_id }}" />

                                <div class="form-group">
                                    <label for="loot_table_description" class="col-md-5 control-label">Short Description</label>

                                    <div class="col-md-6">
                                        <input name="loot_table_description", class="form-control" type="text" value="{{$loot_table->loot_table_description}}">
                                    </div>
                                </div>
                                @if ($errors->has('loot_table_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('loot_table_description') }}</strong>
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
