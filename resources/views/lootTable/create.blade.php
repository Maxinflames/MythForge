<title>MythForge - Create New Loot Table</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Create Loot Table</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST"
                                action="/loot-tables/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="loot_table_description" class="col-md-5 control-label">Short Description</label>
                                    <div class="col-md-6">
                                        <input name="loot_table_description", class="form-control" type="text" value="">
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
