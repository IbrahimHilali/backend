<p>
    {{ trans($activity->getType() . '.' . $activity->getType(false)) }} geändert <a href="{{ route($activity->getType().'.show', $activity->model_id) }}" title="Details"><i class="fa fa-link"></i></a>
</p>

<table class="table table-striped collapse" id="activity-{{ $activity->id }}">
    @foreach($activity->after() as $field => $value)
        <tr>
            <th width="20%">{{ trans($activity->getType() . '.' . $field) }}</th>
            <td width="40%">{{ $activity->log['before'][$field] }}</td>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
</table>
