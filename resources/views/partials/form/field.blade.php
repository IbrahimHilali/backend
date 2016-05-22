<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="input{{ ucfirst($field) }}">{{ field_name($field, $model) }}</label>
    <div class="col-sm-10">
        @if(isset($disabled) && $disabled)
            <p class="form-control-static">{{ $model->{$field} }}</p>
        @else
            <input class="form-control" id="input{{ ucfirst($field) }}" name="{{ $field }}"
                   value="{{ old($field, (isset($model) && !is_string($model)) ? $model->{$field}: null) }}">
        @endif
        @if ($errors->has($field))
            <span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
        @endif
    </div>
</div>
