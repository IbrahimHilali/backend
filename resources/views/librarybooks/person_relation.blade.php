<div class="col-md-offset-2 col-md-10">
    <h3>{{ trans('librarybooks.relations.' . $name . '.name') }}</h3>

    <div class="button-container">
        <div class="generic">
            <a href="{{ route('librarybooks.relation', [$book, $name]) }}" role="button" class="btn btn-default btn-sm">
                <span class="fa fa-plus"></span>
                Person hinzufügen
            </a>
        </div>
    </div>

    <table class="table table-striped">
        <tr>
            <th width="10%">#</th>
            <th width="45%">Name</th>
            <th width="45%">Notizen</th>
        </tr>
        @forelse($book->{str_plural($name)} as $person)
            <tr>
                <td>
                    <a href="{{ route('librarypeople.show', [$person]) }}">
                        {{ $person->id }}
                    </a>
                </td>
                <td>
                    {{ $person->name }}
                </td>
                <td>
                    {{ $person->note }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align: center;">
                    <a href="{{ route('librarybooks.relation', [$book, $name]) }}">
                        {{ trans('librarybooks.relations.' . $name . '.empty') }}
                    </a>
                </td>
            </tr>
        @endforelse
    </table>
</div>