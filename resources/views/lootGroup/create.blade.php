<title>MythForge - Create New Loot Group</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Create Loot Group</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/loot-groups/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="loot_group_description" class="col-md-5 control-label">Short
                                        Description</label>
                                    <div class="col-md-6">
                                        <input name="loot_group_description", class="form-control" type="text"
                                            value="">
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
                                                Submit
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
