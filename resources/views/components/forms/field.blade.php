@props(['label', 'name'])

<div class="mb-5">

    @if ($label)
        <x-forms.label :$name :$label />
    @endif

    <div class="">
        {{ $slot }}

        <x-forms.error :error="$errors->first($name)" />
    </div>
</div>
