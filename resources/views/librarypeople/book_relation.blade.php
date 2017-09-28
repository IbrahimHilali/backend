<h3>{{ ucfirst(trans('librarypeople.relations.'. $relation)) }}</h3>

<table class="table table-hover">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="5%">Kat. Nr.</th>
        <th width="40%">Titel</th>
        <th width="50%">Denecke/Teitge</th>
    </tr>
    </thead>
    <tbody>
    @forelse($person->{$relation} as $book)
        <tr onclick="location.href='{{ route('librarybooks.show', [$book]) }}'"
            style="cursor: pointer;">
            <td>{{ $book->id }}</td>
            <td>{{ $book->catalog_id }}</td>
            <td>{{ \Illuminate\Support\Str::words($book->title, 10) }}</td>
            <td>{{ \Illuminate\Support\Str::words($book->denecke_teitge, 15) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align: center;">kein Buch {{ trans('librarypeople.relations.'. $relation) }}</td>
        </tr>
    @endforelse
    </tbody>
</table>