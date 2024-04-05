<title>MythForge - Loot Groups</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            <div class="form-group text-center">
                <a class="btn btn-primary" href="/loot-groups/create">Create New Loot Group</a>
            </div>
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center">Loot Group ID</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Short Description</th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($loot_groups as $loot_group)
                        <tr>
                            <td class="text-center width-10">{{ $loot_group->loot_group_id }}</td>
                            <td class="text-center width-25">{{ $loot_group->game_type_title }}</td>
                            <td class="text-center width-40">{{ $loot_group->loot_group_description }}</td>
                            <td class="text-center width-5"><a class="btn btn-primary"
                                    href="/loot-groups/{{ $loot_group->loot_group_id }}">View</a></td>
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/loot-groups/{{ $loot_group->loot_group_id }}/edit">Edit</a></td>
                            <td class="text-center width-5"></td>
                        </tr>
                    @endforeach
                </table>
                @if (count($loot_groups) == 0)
                    <p class="text-center">Currently there are no loot groups!</p>
                    <br />
                @endif
            </div>
        </div>
    </div>
@endsection
