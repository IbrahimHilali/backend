<p>
    {{ trans($activity->getType() . '.' . $activity->getType(false)) }} geändert
</p>

<table class="table collapse" id="activity-{{ $activity->id }}">
    @foreach($activity->log['after'] as $field => $value)
        <tr>
            <th width="20%">{{ trans($activity->getType() . '.' . $field) }}</th>
            <td width="40%">{{ $activity->log['before'][$field] }}</td>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
</table>