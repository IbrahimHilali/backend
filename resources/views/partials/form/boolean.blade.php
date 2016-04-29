<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label">{{ field_name($field, $model) }}</label>
    <div class="col-sm-10">
        <label class="radio-inline">
            <input type="radio" name="{{ $field }}" id="{{ $field }}1"
                   value="0" {{ checked(old($field, (!is_string($model)) ? $model->{$field} : 0), 0) }}>
            Nein
        </label>
        <label class="radio-inline">
            <input type="radio" name="{{ $field }}" id="{{ $field }}2"
                   value="1" {{ checked(old($field, (!is_string($model)) ? $model->{$field} : 0), 1) }}>
            Ja
        </label>
    </div>
</div>
