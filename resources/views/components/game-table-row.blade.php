@props(['game', 'userId'])

@php
    $lastActivity = \Carbon\Carbon::createFromTimestamp($game->last_activity)->diffForHumans();
@endphp

<tr>
    <td class="align-content-center">
        {{ $game->playerOne->id !== $userId ? $game->playerOne->name : $game->playerTwo->name }}
    </td>
    <td class="align-content-center">{{ $lastActivity }}</td>
    <td class="align-content-center">
        {{ $slot }}
    </td>
    <td class="align-content-center">
        <x-small-link-button href="game/{{$game->id}}" color="warning">مشاهده</x-small-link-button>
    </td>
</tr>
