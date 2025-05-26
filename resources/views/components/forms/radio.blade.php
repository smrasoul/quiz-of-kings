@props(['value', 'color', 'label', 'name'])

<input type="radio" class="btn-check" name="{{ $name }}" id="{{ $name . '_' . $value }}" value="{{ $value }}" autocomplete="off">
<label {{ $attributes->merge(['class' => "btn btn-$color" ]) }}  for="{{ $name . '_' . $value }}">{{ $label }}</label>


