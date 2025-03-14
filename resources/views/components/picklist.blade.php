<select class="form-select select2"  @if ($isDisabled) disabled @endif aria-label="" name="{{ $fieldname }}" id="{{ $fieldname }}">
    <option value="">{{ $placeholder }}</option>

    @foreach ($picklist as $key => $value)
        <option value="{{ $key }}" @if ($key == $checkedValue) selected @endif>{{ $value }}</option>
    @endforeach
</select>