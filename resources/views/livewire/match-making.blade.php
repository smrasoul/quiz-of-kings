

<div>
    <x-center>
        @if($this->game)
            <div> حریف یافت شد! </div>
            <div>
                <x-large-link-button color="primary" href="/game/{{ $this->game->id }}"> شروع رقابت </x-large-link-button>
            </div>
        @elseif(!$this->game && $this->queue->isEmpty())
            <form wire:submit="store">
                <x-forms.button color="success">شروع بازی جدید</x-forms.button>
            </form>
        @else
            <p>در حال جست‌وجو برای حریف...</p>

            <!-- ⏱ Timer -->
            @if($matchQueue)
                <x-matchmaking-timer :start="$queuedAtTimestamp"/>
            @endif

        @endif
    </x-center>
</div>
