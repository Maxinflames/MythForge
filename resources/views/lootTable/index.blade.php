<title>MythForge - Loot Tables</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            <div class="form-group text-center">
                <a class="btn btn-primary" href="/loot-tables/create">Create New Loot Table</a>
            </div>
            <br />
            <div class="form-group text-center">
                <table class="table table-striped">
                    <!-- Table column headers -->
                    <tr>
                        <th class="text-center">Loot Table ID</th>
                        <th class="text-center">Game Type</th>
                        <th class="text-center">Short Description</th>
                    </tr>
                    <!-- loop through database data and display for each entry -->
                    @foreach ($loot_tables as $loot_table)
                        <tr>
                            <td class="text-center width-10">{{ $loot_table->loot_table_id }}</td>
                            @if ($loot_table->game_type_title != null)
                                <td class="text-center width-25">{{ $loot_table->game_type_title }}</td>
                            @else
                                <td class="text-center width-25">---</td>
                            @endif
                            <td class="text-center width-40">{{ $loot_table->loot_table_description }}</td>
                            <td class="text-center width-5"><a class="btn btn-primary"
                                    href="/loot-tables/{{ $loot_table->loot_table_id }}">View</a></td>
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/loot-tables/{{ $loot_table->loot_table_id }}/edit">Edit</a></td>
                        </tr>
                    @endforeach
                </table>
                @if (count($loot_tables) == 0)
                    <p class="text-center">Currently there are no loot tables!</p>
                    <br />
                @endif
            </div>
        </div>
    </div>
@endsection
