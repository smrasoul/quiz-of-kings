@props(['game', 'roundAnswers', 'round', 'userId'])

<x-layout>

    <x-status.table :game="$game" :roundAnswers="$roundAnswers" :round="$round" :userId="$userId">
        <div class="col-4">
            <h5>خلاصه‌ی راند</h5>
        </div>
        @if($round->status->value == "completed")
        <div class="col-4" dir="ltr">
            <x-small-link-button href="/game/{{ $game->id }}" color="warning">بازگشت</x-small-link-button>
        </div>
        @else
            <div class="col-4">

            </div>
        @endif
    </x-status.table>

    <div class="text-center">
        @if($round->status->value == "pending" && $roundAnswers->count() < 3)

            <x-forms.form method="POST">
                <x-forms.button color="success">ثبت پاسخ ها</x-forms.button>
            </x-forms.form>
        @else
            <x-large-link-button href="/game/{{ $game->id }}" color="success">بازگشت به بازی</x-large-link-button>
        @endif
    </div>

</x-layout>
