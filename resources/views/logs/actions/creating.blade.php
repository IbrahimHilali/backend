<p>
    {{ trans($activity->getType() . '.' . $activity->getType(false)) }} erstellt
</p>

<table class="table collapse" id="activity-{{ $activity->id }}">
    @foreach($activity->log['after'] as $field => $value)
        <tr>
            <th width="20%">{{ trans($activity->getType() . '.' . $field) }}</th>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
</table>