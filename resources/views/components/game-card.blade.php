@props(['game'])

@php
    $lastActivity =  \Carbon\Carbon::createFromTimestamp($game->last_activity)->diffForHumans();
@endphp

<div class="col-sm-2 mb-3 mb-sm-0 text-center">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">آخرین تغییر:</h5>
            <p class="card-text">
                {{ $lastActivity }}
            </p>
            <x-large-link-button color="success my-3" href="game/{{ $game->id }}">
                ادامه بازی
            </x-large-link-button>
        </div>
    </div>
</div>
