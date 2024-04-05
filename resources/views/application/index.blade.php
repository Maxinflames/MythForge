<title>Campaign Manager - Subscribed Items</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            @if (count($applications) == 0)
                <br />
                <p class="text-center">Currently there are no applications!</p>
            @endif
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <td class="text-center width-5"></td>
                        <th class="text-center">Campaign ID</th>
                        <th class="text-center">Campaign Title</th>
                        <th class="text-center">Campaign Owner</th>
                        <th class="text-center">Status</th>
                        <td class="text-center width-5"></td>
                        <td class="text-center width-5"></td>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($applications as $application)
                        <tr>
                            <td class="text-center width-5"></td>
                            <td class="text-center width-10">{{ $application->campaign_id }}</td>
                            <td class="text-center width-10">{{ $application->campaign_title }}</td>
                            <td class="text-center width-10">{{ $application->user_name }}</td>
                            @if ($application->application_status != null)
                                <td class="text-center width-10">{{ $application->application_status }}</td>
                            @else
                                <td class="text-center width-10">---</td>
                            @endif
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/applications/{{ $application->application_id }}">View</a></td>
                            <td class="text-center width-5"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
