@props(['queued', 'match'])


<x-layout>

    <x-nav/>

    <x-center>
        <x-page-heading class="">بازی‌ها</x-page-heading>


        @if($match)
            <x-large-link-button color="success" href="play/{{ $match->id }}">ادامه بازی</x-large-link-button>
        @elseif($queued)
            <p>در حال جست‌وجو برای حریف</p>
        @elseif(empty($queued) && empty($inMatch))
            <x-forms.form method="POST" action="/play">
                <x-forms.button color="success"> شروع بازی جدید</x-forms.button>
            </x-forms.form>
        @endif
    </x-center>

</x-layout>
