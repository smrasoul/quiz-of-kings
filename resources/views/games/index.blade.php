@props(['queued', 'game'])


<x-layout>

    <x-nav/>

    <x-center>
        <x-page-heading class="">بازی‌ها</x-page-heading>


        @if($game)
            <x-large-link-button color="success" href="game/{{ $game->id }}">ادامه بازی</x-large-link-button>
        @elseif($queued)
            <p>در حال جست‌وجو برای حریف</p>
        @elseif(empty($queued) && empty($game))
            <x-forms.form method="POST" action="/games">
                <x-forms.button color="success"> شروع بازی جدید</x-forms.button>
            </x-forms.form>
        @endif
    </x-center>

</x-layout>
