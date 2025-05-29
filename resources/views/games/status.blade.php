@props(['game', 'roundAnswers', 'round', 'userId'])

<x-layout>

    <x-status.table :game="$game" :roundAnswers="$roundAnswers" :round="$round" :userId="$userId">
        <div class="col-8">
            <h5>خلاصه‌ی راند</h5>
        </div>
    </x-status.table>

    <div class="text-center">
        @if(!$round->status)
            <x-forms.form method="POST">
                <x-forms.button color="success">ادامه</x-forms.button>
            </x-forms.form>
        @else
            <x-large-link-button href="/game/{{ $game->id }}" color="success">بازگشت به بازی</x-large-link-button>
        @endif
    </div>

</x-layout>
