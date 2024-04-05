<title>MythForge - Loot Group - Add Table Item</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <td></td>
                        <th class="text-center">Loot Group ID</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Short Description</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center width-5"></td>
                        <td class="text-center width-10">{{ $loot_group->loot_group_id }}</td>
                        <td class="text-center width-25">{{ $loot_group->game_type_title }}</td>
                        <td class="text-center width-40">{{ $loot_group->loot_group_description }}</td>
                        <td class="text-center width-5"></td>
                    </tr>
                </table>
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center">Loot Table ID</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Description</th>
                        <th class="text-center width-5"></th>
                        <th class="text-center width-5"></th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($loot_tables as $loot_table)
                        <tr>
                            <td class="text-center width-15">{{ $loot_table->loot_table_id }}</td>
                            <td class="text-center width-25">{{ $loot_table->game_type_title }}</td>
                            <td class="text-center">{{ $loot_table->loot_table_description }}</td>
                            <td class="text-center"><a href="/loot-tables/{{ $loot_table->loot_table_id }}" class="btn">View</a></td>
                            <td class="text-center">
                                <form method="POST" action="/loot-groups/{{ $loot_group->loot_group_id }}/loot-table/{{ $loot_table->loot_table_id }}/store">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="loot_group_id" value="{{ $loot_group->loot_group_id }}" />
                                    <div class="inline-float">
                                        <button type="submit" class="btn btn-primary">
                                            Add
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @if (count($loot_tables) == 0)
                    <p class="text-center">Currently there are no tables!</p>
                    <br />
                @endif
            </div>
        </div>
    </div>
@endsection
