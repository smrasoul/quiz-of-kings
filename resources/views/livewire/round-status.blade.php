<div>
    @if($round->status->value === 'completed')
        <x-small-link-button color="warning" href="/game/{{ $game->id }}/round/{{ $round->id }}/status">مشاهده</x-small-link-button>
    @else
        @if($game->current_turn === $userId )
            <x-small-link-button href="/game/{{$game->id}}/round/{{$round->id}}" color="success">بازی کن</x-small-link-button>
        @else
            <x-small-link-button href="{{ request()->url() }}" color="cyan">نوبت حریف</x-small-link-button>
        @endif
    @endif
</div>
