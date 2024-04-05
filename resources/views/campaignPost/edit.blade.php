<title>Campaign Manager - Edit Post</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">Edit Post</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST"
                                action="/campaign/{{ $campaign->campaign_id }}/posts/{{ $post->campaign_post_id }}/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="campaign_post_id" value="{{ $post->campaign_post_id }}" />

                                <div class="form-group">
                                    <label for="campaign_post_title" class="col-md-5 control-label">Post Title</label>
                                    <div class="col-md-6">
                                        <input id="campaign_post_title" type="text" class="form-control"
                                            name="campaign_post_title" value="{{ $post->campaign_post_title }}" />
                                    </div>
                                </div>
                                @if ($errors->has('campaign_post_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_post_title') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <label for="campaign_post_content" class="col-md-5 control-label">Post Content</label>
                                    <div class="col-md-7">
                                        <textarea rows="12" id="campaign_post_content" type="text" class="form-control" maxlength="10000"
                                            name="campaign_post_content">{{ $post->campaign_post_content }}</textarea>
                                    </div>
                                </div>
                                @if ($errors->has('campaign_post_content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_post_content') }}</strong>
                                    </span>
                                @endif

                                <div class="content form-group">
                                    @if ($post->campaign_post_status == 1)
                                        <input class="radio-input" id="status1" type="radio" name="campaign_post_status"
                                            checked="true" value="1" />
                                        <label class="radio-label" for="status1">Public</label>

                                        <input class="radio-input" id="status2" type="radio" name="campaign_post_status"
                                            value="0" />
                                        <label class="radio-label" for="status2">Private</label>
                                    @else
                                        <input class="radio-input" id="status1" type="radio" name="campaign_post_status"
                                            value="1" />
                                        <label class="radio-label" for="status1">Public</label>

                                        <input class="radio-input" id="status2" type="radio" name="campaign_post_status"
                                            checked="true" value="0" />
                                        <label class="radio-label" for="status2">Private</label>
                                    @endif
                                </div>
                                @if ($errors->has('campaign_post_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_post_status') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <div class="content">
                                        <button type="submit" class="btn btn-primary">
                                            Update Post
                                        </button>
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
