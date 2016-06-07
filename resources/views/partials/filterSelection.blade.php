@if(!$filter->selectable()->isEmpty())
<div class="btn-group">
    <a href="{{ toggle_active_filters($filter) }}" class="btn btn-default btn-sm" data-toggle="tooltip" title="{{ ($filter->hasSelected()) ? trans('filters.remove') : trans('filters.about') }}" data-container="body">Filter <span class="badge {{ ($filter->hasSelected()) ? '': 'hide' }}">{{ $filter->selected()->count() }}</span></a>
    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">
        @foreach($filter->selectable() as $f)
            <li {!! active_if($f->applied())  !!} ><a href="{{ url()->filtered([$f->appliesTo()]) }}">{{ trans($f->displayString()) }}</a></li>
        @endforeach
    </ul>
</div>
@endif
<a href="{{ url()->filtered(['trash']) }}" type="button" class="btn btn-{{ ($filter->filterFor('trash')->applied()) ? 'danger' : 'default' }} btn-sm" data-toggle="tooltip" data-placement="bottom" title="Gelöschte Elemente anzeigen">
    <i class="fa fa-trash-o"></i>
</a>
