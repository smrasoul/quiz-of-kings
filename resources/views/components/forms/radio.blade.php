@props(['variable', 'color', 'label', 'name'])

<input type="radio" class="btn-check" name="{{ $name }}" id="category-{{ $variable->id }}" value="{{ $variable->id }}" autocomplete="off">
<label {{ $attributes->merge(['class' => "btn btn-$color" ]) }}  for="category-{{ $variable->id }}">{{ $label }}</label>
