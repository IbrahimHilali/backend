<p>
    {{ trans($activity->getType() . '.' . $activity->getType(false)) }} entfernt
</p>

<table class="table table-striped collapse" id="activity-{{ $activity->id }}">
    @foreach($activity->log['before'] as $field => $value)
        <tr>
            <th width="20%">{{ trans($activity->getType() . '.' . $field) }}</th>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
</table>
