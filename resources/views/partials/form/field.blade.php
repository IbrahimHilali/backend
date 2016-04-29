<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="input{{ ucfirst($field) }}">{{ field_name($field, $model) }}</label>
    <div class="col-sm-10">
        <input class="form-control" id="input{{ ucfirst($field) }}" name="{{ $field }}"
               value="{{ old($field, (isset($model) && !is_string($model)) ? $model->{$field}: null) }}">
        @if ($errors->has($field))
            <span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
        @endif
    </div>
</div>
