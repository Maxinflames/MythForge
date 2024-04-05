<title>Campaign Manager - Post Show</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">

        <div class="content">
            <div class="title m-b-md">
                <div>
                    <div class="form-group text-center">
                        <table class="table table-striped">
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
                                @if ($campaign->user_id == Session::get('user_id'))
                                    <td class="text-center width-5"><a class="btn btn-secondary"
                                            href="/campaign/{{ $campaign->campaign_id }}/posts/{{ $post->campaign_post_id }}/edit">Edit</a>
                                    </td>
                                @endif
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
