<title>Campaign Manager - Lore Posts</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            @if (count($campaignPosts) == 0)
                <br />
                <p class="text-center">Currently there are no posts!</p>
            @endif
            @if (Session::get('user_id') == $campaign->user_id)
                <div class="form-group text-center">
                    <a class="btn btn-primary" href="/campaign/{{ $campaign->campaign_id }}/posts/store">Create New Post</a>
                </div>
            @endif
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- loop through database data and display for each entry -->
                    @foreach ($campaignPosts as $post)
                        <tr>
                            <td class="width-5"></td>
                            <th class="text-center width-40">
                                <h4>{{ $post->campaign_post_title }}</h4>
                            </th>
                            <td class="text-center width-15">
                                <p>Created:</p>
                                <p>{{ $post->created_at }}</p>
                            </td>
                            <td class="text-center width-15">
                                <p>Last Updated:</p>
                                <p>{{ $post->updated_at }}</p>
                            </td>
                            @if ($post->campaign_post_status == 1)
                                <td class="text-center">Public</td>
                            @else
                                <td class="text-center">Private</td>
                            @endif
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/campaign/{{ $campaign->campaign_id }}/posts/{{ $post->campaign_post_id }}">View</a>
                            </td>
                            <td class="width-5"></td>
                        </tr>
                        <tr>
                            <td class="width-5"></td>
                            <td class="text-center width-25" colspan="5">{{ $post->campaign_post_content }}</td>
                            <td class="width-5"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
