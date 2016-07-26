<table class="table table-responsive table-striped">
    <tbody>
    @forelse($entity->activity as $activity)
        @if ($activity->isUpdatingActivity())
            <tr>
                <td>
                    <a data-toggle="collapse" href="#activity-{{ $activity->id }}" aria-expanded="false" aria-controls="activity-{{ $activity->id }}">Am <strong>{{ $activity->created_at->format('d.m.Y H:i:s') }}</strong> von <em>{{ $activity->user->name }}</em> {{ trans('activity.actions.' . $activity->action()) }}</a>
                </td>
            </tr>
            <tr class="collapse" id="activity-{{ $activity->id }}">
                <td>
                    <table class="table" style="background-color: #ffffff;">
                        <tbody>
                        @foreach($activity->after() as $field => $value)
                            <tr>
                                <th style="width: 30%">{{ trans($activity->getType() . '.' . $field) }}</th>
                                <td>{{ $activity->before($field) }} <i class="fa fa-long-arrow-right"></i>{{ $value }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @else
            <tr>
                <td>Am <strong>{{ $activity->created_at->format('d.m.Y H:i:s') }}</strong> von <em>{{ $activity->user->name }}</em> {{ trans('activity.actions.' . $activity->action()) }}</td>
            </tr>
        @endif
    @empty
        <tr>
            <td colspan="3" class="text-center">Keine Änderungen vorgenommen.</td>
        </tr>
    @endforelse
    </tbody>
</table>
